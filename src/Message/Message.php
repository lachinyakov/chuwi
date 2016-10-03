<?php

namespace Messenger\Message;
use Messenger\User\User;

/**
 * Class Message
 *
 * @package Messenger\Message
 */
class Message
{

    const TYPE_COMMON_MESSAGE  = 'public';
    const TYPE_PRIVATE_MESSAGE = 'private';
    /**
     * @var int
     */
    protected $type;

    /**
     * @var mixed содержимое сообщения.
     */
    protected $body;

    /**
     * @var User[] Массив получателей.
     */
    protected $consumers;

    /**
     * Message constructor.
     *
     * @param $type
     * @param $body
     */
    public function __construct($type, $body)
    {
        $this->type = $type;
        $this->body = $body;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    public function setConsumers($consumers)
    {
        $this->consumers = $consumers;
    }

    public function getFields()
    {
        return array(
            "body"      => $this->body,
            "type"      => $this->type,
            "consumers" => $this->consumers,
        );
    }

    /**
     * @return \string[]
     */
    public function getConsumers()
    {
        return $this->consumers;
    }
}
