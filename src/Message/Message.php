<?php

namespace Messenger\Message;

/**
 * Class Message
 *
 * @package Messenger\Message
 */
class Message {

    const TYPE_COMMON_MESSAGE  = 0;
    const TYPE_PRIVATE_MESSAGE = 1;
    /**
     * @var int
     */
    private $type;

    /**
     * @var mixed содержимое сообщения.
     */
    private $body;

    /**
     * @var string[] Массив получателей.
     */
    protected $consumers;

    /**
     * Message constructor.
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
}
