<?php

namespace Messenger\Publishers;

use Messenger\Message\Message;
use Messenger\Publishers\PublisherInterface;
use Messenger\User\UserService;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class CommonPublisher implements PublisherInterface
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;


    /**
     * PrivatePublisher constructor.
     *
     * @param $connection
     */
    public function __construct($connection)
    {
        $this->connection  = $connection;
    }


    /**
     * @param Message $message сообщение
     *
     * @return bool
     */
    public function publish($message)
    {
        $channel  = $this->connection->channel();
        $exchange = $message->getType();
        $channel->exchange_declare(
            $exchange, 'fanout', false, false, false
        );
        $msg = new AMQPMessage($message->getBody());
        $channel->basic_publish($msg, $exchange, 'ShareQueue');
        $channel->close();
        $this->connection->close();
    }
}
