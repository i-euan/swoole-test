<?php
class AsyncRedis
{
    public $host = '127.0.0.1';
    public $port = 6379;
    public $redis;
    public $options = [
        'connect_timeout' => 1,
        'timeout' => 5
    ];

    public function __construct()
    {
        $this->redis = new Swoole\Coroutine\Redis($this->options);
        $this->redis->connect($this->host, $this->port);
    }

    //获取值
    public function get($key)
    {
        return $this->redis->get($key);
    }

    //设置值
    public function set($key, $value)
    {
        $this->redis->set($key, $value);
    }

    //事务开启
    public function multi()
    {
        $this->redis->multi();
    }

    //事务提交
    public function exec()
    {
        $this->redis->exec();
    }
}

go(function () {
    $redis = new AsyncRedis;
    $redis->multi();
    $redis->set('euan', 18);
    $res = $redis->get('euan');
    $redis->exec();
    var_dump($res);
});
echo 1;