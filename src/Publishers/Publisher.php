<?php

namespace Messenger\Publishers;

use Messenger\Exception\MethodNotAllowed;
use Messenger\Message\Message;
use Messenger\Publishers\PublisherInterface;
use Messenger\User\UserService;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Messenger\Publishers\PrivatePublisher;


class Publisher implements PublisherInterface
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
            Message::TYPE_PRIVATE_MESSAGE => new PrivatePublisher($this->connection, $this->userService),
        );

        return $classes[$type];
    }
}
