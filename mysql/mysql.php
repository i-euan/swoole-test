<?php

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

    public function query($sql)
    {
        return $this->db->query($sql);
    }

    public function __destruct()
    {
        $this->db->close();
    }
}

go(function () {
    $db = new AsyncMysql;
    $sql = "select * from test";
    $res = $db->query($sql);
    var_dump($res);
});
