<?php

namespace Messenger;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class Consumer {
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * Consumer constructor.
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $exchange наименование обменника.
     */
    public function consume() {
        $channel = $this->connection->channel();
        $channel->exchange_declare('exchange', 'fanout', false, false, false);

        list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

        $channel->queue_bind($queue_name, 'exchange');

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
