<?php
echo date('i:s') . PHP_EOL;

$workers = [];

for ($i = 0; $i < 10; $i++) {
    $process = new Swoole\Process(function (Swoole\Process $obj) use ($i) {
        $content = request($i);
        echo $content;
        $obj->write($content);
    }, true);
    $pid = $process->start();
    $workers[$pid] = $process;
}

function request($i)
{
    sleep(2);
    return "success" . $i . PHP_EOL;
}

// foreach ($workers as $process) {
//     echo $process->read();
// }

echo date('i:s');

foreach ($workers as $process) {
    echo $process->read();
}
