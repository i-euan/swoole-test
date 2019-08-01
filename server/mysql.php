<?php

/**
 * 适用场景: 如阅读文章加阅读量,先输出内容异步更新阅读量
 */
class AsyncMysql
{
    public $db;
    public $config = [
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'root',
        'password' => 'root',
        'database' => 'test',
    ];

    public function __construct()
    {
        $this->db = new Swoole\Coroutine\MySQL();
        $this->db->connect($this->config);
    }

    /**
     * @* @param str $sql 要执行的sql语句
     */
    public function query($sql)
    {
        return $this->db->query($sql);
    }

    public function __destruct()
    {
        $this->db->close();
    }
}

$sql = "select * from test";
// swoole中的一些跟coroutine协程相关的接口， 必须要在协程中执行，
go(function () use ($sql) {
    $db = new AsyncMysql;
    $res = $db->query($sql);
    var_dump($res);
});
//由于是异步所以会先输出echo后输出var_dump;
echo $sql . PHP_EOL;
