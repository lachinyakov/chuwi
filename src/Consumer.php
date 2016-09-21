<?php

namespace Messenger;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class Consumer {
    /**
     * @var AMQPStreamConnection
     */
    private $connection;
    private $userName;

    /**
     * Consumer constructor.
     * @param $connection
     * @param $userName
     */
    public function __construct($connection, $userName)
    {
        $this->connection = $connection;
        $this->userName   = $userName;
    }

    /**
     * @param string $exchange наименование обменника.
     */
    public function consume() {
        $channel = $this->connection->channel();
        $channel->exchange_declare($this->userName, 'fanout', false, false, false);

        list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);


        $channel->queue_bind($queue_name, $this->userName);

        echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";

        $callback = function($msg){
          echo ' [x] ', $msg->body, "\n";
        };

        $channel->basic_consume($queue_name, '', false, true, false, false, $callback);

        while(count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $this->connection->close();
    }
}
