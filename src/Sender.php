<?php

namespace Messenger;

use Messenger\Exception\MethodNotAllowed;
use Messenger\Message\Message;
use Messenger\User\UserService;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Sender
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * Consumer constructor.
     */
    public function __construct($connection, $userService)
    {
        $this->connection  = $connection;
        $this->userService = $userService;
    }

    /**
     * @param Message $message сообщениею
     *
     * @return bool
     */
    public function send($message)
    {
        $consumers = $message->getConsumers();
        $channel   = $this->connection->channel();
        foreach ($consumers as $consumer) {
            $consumer   = $this->userService->getUserByName($consumer);
            $routingKey = $consumer->getName();
            $channel->exchange_declare($routingKey, 'fanout', false, false, false);
            $msg = new AMQPMessage($message);
            $channel->basic_publish($msg, 'exchange');
        }
        $channel->close();
        $this->connection->close();
    }

    public function call()
    {
        throw new MethodNotAllowed();
    }
}
