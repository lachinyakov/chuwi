<?php

namespace Messenger;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Sender {
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
     * @param string $message сообщениею
     */
    public function send($message)
    {
        $channel = $this->connection->channel();
        $channel->exchange_declare('exchange', 'fanout', false, false, false);
        $msg    = new AMQPMessage($message);
        $channel->basic_publish($msg, 'exchange');
        $channel->close();
        $this->connection->close();

        return true;
    }
}
