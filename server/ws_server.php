<?php
/**
 * websocket server
 */
class Ws
{
    protected $host = "0.0.0.0";
    protected $port = 8080;
    public $ws;
    public function __construct()
    {
        $this->ws = new swoole_websocket_server($this->host,$this->port);

        $this->ws->set([
            'worker_num' => 4,
            'task_worker_num' => 2
        ]);
        
        $this->ws->on('open', [$this,'on_open']);
        $this->ws->on('message', [$this,'on_message']);
        $this->ws->on('close', [$this,'on_close']);
        $this->ws->on('task', [$this,'on_task']);
        $this->ws->on('finish', [$this,'on_finish']);
        $this->ws->start();
    }

    /**
     * 监听链接
     */
    public function on_open($ws, $request)
    {
        var_dump($request->fd, $request->get);
    }

    /**
     * 监听客户端消息
     */
    public function on_message($ws, $frame)
    {
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $data = [
            'task' => 1,
            'fd' => $frame->fd
        ];
        $ws->task($data);
        $ws->push($frame->fd, "this is server");
    }

    /**
     * 监听客户端断开链接
     */
    public function on_close($ws, $fd)
    {
        echo "client {$fd} closed\n";
    }

    /**
     * 监听任务
     */
    public function on_task($ws, $task_id, $src_worder_id, $data)
    {
        echo "task callback:";
        sleep(5);
        var_dump($task_id, $data);
        return "task success";
    }

    /**
     * 
     */
    public function on_finish($ws, $task_id, $data)
    {
        var_dump($task_id.$data);
    }
}

new Ws();