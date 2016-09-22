<?php

class User
{
    protected $name;

    /**
     * @var string
     */
    protected $encriptKey;
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
        $this->encriptKey = $data['encriptKey'];
        $this->routingKey = $data['routingKey'];
    }

    /**
     * @return string
     */
    public function getEncriptKey()
    {
        return $this->encriptKey;
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
