<?php

namespace Messenger\User;

class User
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $encryptKey;
    /**
     * @var string
     */
    protected $routingKey;

    /**
     * User constructor.
     *
     * @param $data
     *
     * @return User
     */
    public function __construct($data)
    {
        $this->name       = $data['name'];
        $this->encryptKey = $data['encryptKey'];
        $this->routingKey = $data['routingKey'];
    }

    /**
     * @return string
     */
    public function getEncriptKey()
    {
        return $this->encryptKey;
    }

    /**
     * @return string
     */
    public function getRoutingKey()
    {
        return $this->routingKey;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}
