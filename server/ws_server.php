<?php
/**
 * websocket server
 */
CONST HOST = "0.0.0.0";
CONST PORT = 8080;
class Ws
{
    public $ws;
    public function __construct()
    {
        $this->ws = new swoole_websocket_server(HOST,PORT);
        $this->ws->on('open', [$this,'on_open']);
        $this->ws->on('message', [$this,'on_message']);
        $this->ws->on('close', [$this,'on_close']);
        $this->ws->start();
    }

    /**
     * 监听链接
     * @* @param obj $ws ws对象
     * @* @param obj $request 请求对象
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
        $ws->push($frame->fd, "this is server");
    }

    /**
     * 监听客户端断开链接
     */
    public function on_close($ws, $fd)
    {
        echo "client {$fd} closed\n";
    }
}

new Ws();