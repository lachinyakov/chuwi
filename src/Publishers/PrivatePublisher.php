<?php

namespace Messenger\Publishers;

use Messenger\Message\Message;
use Messenger\Publishers\PublisherInterface;
use Messenger\User\UserService;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class PrivatePublisher implements PublisherInterface
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
     * PrivatePublisher constructor.
     *
     * @param $connection
     * @param $userService
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
    public function publish($message)
    {
        $consumers = $message->getConsumers();
        $channel   = $this->connection->channel();
        $exchange  = $message->getType();
        foreach ($consumers as $consumer) {
            echo "\n $consumer \n";
            $consumer = $this->userService->getUserByName($consumer);
            $channel->exchange_declare(
                $exchange, 'topic', false, false, false
            );

            $msg        = new AMQPMessage($message->getBody());
            $routingKey = $consumer->getName();
            $channel->basic_publish($msg, $exchange, $routingKey);
        }
        $channel->close();
        $this->connection->close();
    }
}
