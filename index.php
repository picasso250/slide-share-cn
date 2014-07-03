<?php

// change the following paths if necessary
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('DEBUG') or define('DEBUG',true);

require_once __DIR__ . '/vendor/autoload.php';

$config = require (__DIR__.'/protected/config/main.php');
$db_config = $config['components']['db'];
ORM::configure($db_config['connectionString']);
ORM::configure('username', $db_config['username']);
ORM::configure('password', $db_config['password']);
ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$db_config['charset']));

$klein = new \Klein\Klein();

$klein->respond(function () {
});

$klein->respond('GET', '/', function () {
    ORM::for_table('');
    return 'Hello World!';
});
$klein->respond('GET', '/slide/[:id]', function ($request) {
    return 'Hello ' . $request->name;
});
$klein->respond('POST', '/slide/upload', function ($request) {
    return 'Hello ' . $request->name;
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