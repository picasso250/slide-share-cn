<?php
function plog($msg, $level = 'debug')
{
    $date = date('Y-m-d H:i:s');
    $info = array(
        'level' => $level,
        'msg' => $msg,
        'date' => $date,
    );
    if (isset($_SERVER['HTTP_APPNAME'])) {
        $kv = new SaeKV();
        // 初始化KVClient对象
        $ret = $kv->init();

        // 更新key-value
        $ret = $kv->set($date, $info);
    } else {
        error_log(json_encode($info)."\n", 3, dirname(__DIR__).'/runtime/application.log');
    }
}


function upload($upload_root, $url)
{
    $date = '/' . date('Ymd');
    $root = $upload_root . $date;
    if (!is_dir($root)) {
        plog("$root is not dir", 'LEVEL_WARNING');
        if (is_file($root)) {
            plog("$root is file", 'LEVEL_ERROR');
            return '';
        }
        mkdir($root, 0777, true);
    }
    $content = file_get_contents($url);
    $len_in = strlen($content);
    $path = '/' . microtime() . '.pdf';
    $url = $root . $path;
    $len = file_put_contents($url, $content);
    if ($len != $len_in) {
        plog(" $len $len_in not match, write not enough", 'LEVEL_WARNING');
        return '';
    }
    return $date.$path;
}