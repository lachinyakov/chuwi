<?php

namespace Messenge\Message;

class Consumer
{
    protected $name;

    protected $routingKey;

    protected $encryptKey;


    /**
     * Consumer constructor.
     * @param $name
     * @param $routingKey
     * @param $encyptKey
     */
    public function __construct($name, $routingKey, $encyptKey)
    {
        $this->name       = $name;
        $this->routingKey = $routingKey;
        $this->encyptKey  = $encyptKey;
    }
}