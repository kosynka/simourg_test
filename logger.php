<?php

umask(0000);
if (!defined('START_MICROTIME')) {
    define('START_MICROTIME', microtime(true));
}
if (!defined('REQUEST_CUSTOM_ID')) {
    define(
        'REQUEST_CUSTOM_ID',
        (new DateTime())->format('Ymd_His_u_') . rand(0000000, 9999999)
    );
}

$log = fopen(__DIR__ . '/log/base_logs.log', 'a');
if ($log !== false) {
    fwrite($log, json_encode([
        'GET' => $_GET,
        'POST' => $_POST,
        'INPUT' => file_get_contents('php://input'),
        'COOKIE' => $_COOKIE,
        'HTTP_HEADERS' => getallheaders(),
        'SERVER' => $_SERVER,
    ]) . PHP_EOL);
    fclose($log);
}
