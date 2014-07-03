<?php

// change the following paths if necessary


// remove the following lines when in production mode
defined('DEBUG') or define('DEBUG',true);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/protected/components/lib.php';

$config = require (__DIR__.'/protected/config/main.php');
if (isset($_SERVER['HTTP_APPNAME'])) {
    $config = array_merge($config, require __DIR__.'/protected/config/server.php');
}
$db_config = $config['components']['db'];
ORM::configure($db_config['connectionString']);
ORM::configure('username', $db_config['username']);
ORM::configure('password', $db_config['password']);
ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$db_config['charset']));

$klein = new \Klein\Klein();

$klein->respond(function () {
});

$klein->respond('GET', '/', function () use ($config) {
    $list = ORM::for_table('ppt')
        ->order_by_desc('id')
        ->limit(100)
        ->find_many();
    include __DIR__.'/protected/views/ppt/index.phtml';
});
$klein->respond('GET', '/slide/[:id]', function ($request) {
    return 'Hello ' . $request->name;
});
$klein->respond('POST', '/upload', function ($request) use ($config) {
    $ppt = ORM::for_table('ppt')->create();
    $ppt->name = $request->name;
    if (!isset($_FILES['url']['name'])) {
        plog('no $_FILES[url]', 'LEVEL_ERROR');
        die('请选择文件');
    }
    $error = $_FILES['url']['error'];
    if ($error) {
        plog('upload error '.$error, 'error');
        header('Location:/');
        exit;
    }
    $ppt->url = upload($config['params']['upload_root'], $_FILES['url']['tmp_name']);
    $ppt->created = date('Y-m-d H:i:s');
    $ppt->save();
    header('Location:/');
    exit;
});

$klein->respond('GET', '/upload', function ($request) {
    include __DIR__.'/protected/views/ppt/create.phtml';
});

$klein->respond('GET', '/mem/', function ($request) {
    $list = ORM::for_table('mem')
        ->order_by_desc('id')
        ->limit(7)
        ->find_many();
    include __DIR__.'/protected/views/mem/list.phtml';
});
$klein->respond('GET', '/mem/add', function ($request) {
    include __DIR__.'/protected/views/mem/add.phtml';
});
$klein->respond('POST', '/mem/add', function ($request) {
    $mem = ORM::for_table('mem')->create();
    $mem->content = $request->content;
    $mem->created = date('Y-m-d H:i:s');
    $mem->save();
    header('Location:/mem/');
    exit;
});

$klein->dispatch();