<?php

namespace Messenger;

use Messenger\Message\Message;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Consumer
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;
    private $userName;

    /**
     * Consumer constructor.
     *
     * @param $connection
     * @param $userName
     */
    public function __construct($connection, $userName)
    {
        $this->connection = $connection;
        $this->userName   = $userName;
    }

    /**
     * Заускает вход
     */
    public function consume()
    {
        $channel       = $this->connection->channel();
        $exchangesList = $this->getExchangesList();
        $callback      = function ($msg) {
            echo ' [x] ', $msg->body, "\n";
        };
        foreach ($exchangesList as $exchange => $routingKey) {
            $channel->exchange_declare(
                $exchange, 'topic', false, false, false
            );
            list($queue_name, ,) = $channel->queue_declare(
                "", false, false, true, false
            );
            $channel->queue_bind($queue_name, $exchange, $routingKey);
            $channel->basic_consume(
                $queue_name, '', false, true, false, false, $callback
            );
        }

        echo ' Hello ' . $this->userName . '. To exit press CTRL+C', "\n";

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $this->connection->close();
    }

    protected function getExchangesList()
    {
        return array(
            Message::TYPE_COMMON_MESSAGE  => 'ShareQueue',
            Message::TYPE_PRIVATE_MESSAGE => $this->userName,
        );
    }
}
