<?php
$file = __DIR__ . "/1.txt";
//echo $file;
/*****************************  读操作  ***********************************/
/**
 * swoole_async_readfile会将文件内容全部复制到内存，所以不能用于大文件的读取
 * 如果要读取超大文件，请使用swoole_async_read函数
 * swoole_async_readfile最大可读取4M的文件，受限于SW_AIO_MAX_FILESIZE宏
 * 4.3以上弃用
 */
// $res = swoole_async_readfile($file, function ($filename, $content) {
//     echo "{$filename}:{$content}" . PHP_EOL;
// });

use Swoole\Coroutine as co;

/**
 * 同swoole_async_readfile
 */
// co::create(function () use ($file)   co::create 可以用go关键字代替
// go(function () use ($file)
// {
//     $r =  co::readFile($file);
//     var_dump($r);
// });


// $fp = fopen($file, "r");
// go(function () use ($fp)
// {
//     //fseek($fp, 2);	//指针复位，第二个参数是偏移量
//     $r =  co::fread($fp);
//     var_dump($r);
// });

/*****************************  写操作  ***********************************/

$fp = fopen($file, "a+");
co::create(function () use ($fp)
{
    $r =  co::fwrite($fp, "hello world\n", 5);
    var_dump($r);
});


echo '1' . PHP_EOL;		//因为异步执行，这行会先输出出来