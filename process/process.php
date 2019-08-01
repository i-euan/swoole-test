<?php
/**
 * 进程管理
 * 使用netstat查看端口占用
 * 使用pstree查看进程树
 */
$process = new Swoole\Process(function (Swoole\Process $process) {
    // var_dump(1);
    $process->exec('/www/server/php/72/bin/php', [__DIR__ . '../server/ws_server.php']);
}, false);
$pid = $process->start();
var_dump($pid);
swoole_process::wait();
