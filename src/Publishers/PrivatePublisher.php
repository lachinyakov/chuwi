<?php

namespace Messenger\Publishers;

use Messenger\Message\Message;
use Messenger\Publishers\PublisherInterface;
use Messenger\User\User;
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
     * PrivatePublisher constructor.
     *
     * @param $connection
     */
    public function __construct($connection)
    {
        $this->connection  = $connection;

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
        /**
         * @var User $consumer
         */
        foreach ($consumers as $consumer) {
            echo "\n" . $consumer->getName() . " ";
            $channel->exchange_declare(
                $exchange, 'topic', false, false, false
            );

            $msg        = new AMQPMessage($message->getBody());
            $routingKey = $consumer->getName();
            $channel->basic_publish($msg, $exchange, $routingKey);

            echo " [v] \n";
        }
        $channel->close();
        $this->connection->close();
    }
}
