<?php

namespace Messenger\Publishers;

use Messenger\Exception\MethodNotAllowed;
use Messenger\Message\Message;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Publisher implements PublisherInterface
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * Consumer constructor.
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
        $typeMessage = $message->getType();
        /**
         * @var PublisherInterface $publisher
         */
        $publisher   = $this->getPublishByMessageType($typeMessage);
        $publisher->publish($message);
    }

    public function call()
    {
        throw new MethodNotAllowed();
    }

    private function getPublishByMessageType($type)
    {
        $classes = array(
            Message::TYPE_COMMON_MESSAGE  => new CommonPublisher($this->connection),
            Message::TYPE_PRIVATE_MESSAGE => new PrivatePublisher($this->connection),
        );

        return $classes[$type];
    }
}
