<?php

namespace Messenger;

use Messenger\Exception\ContainerIsNotExist;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Pimple\Container;
use Service;

class Bootstrap
{

    protected static $instance;

    /**
     * Bootstrap constructor.
     */
    protected function __construct()
    {
        $this->container = new Container();

        $this->container['config'] = function ($c) {
            $config = require_once __DIR__ . "/../config/config.php";

            return $config;
        };

        $this->container['amqp.connection'] = function ($c) {
            $config     = $c['config'];
            $connection = new AMQPStreamConnection(
                $config['host'],
                $config['port'],
                $config['user'],
                $config['password']
            );

            return $connection;
        };

        $this->container['sender'] = function ($c) {
            $connection = $c['amqp.connection'];

            return new Sender($connection);
        };

        /**
         * @param $c
         *
         * @return Consumer
         */
        $this->container['consumer'] = function ($c) {
            $config     = $c['config'];
            $connection = $c['amqp.connection'];

            return new Consumer($connection, $config['chatUser']);
        };

        $this->container['message.factory'] = function () {
            return new Message\Factory();
        };

        $this->container['context.handler'] = function () {
            return new Context\Handler();
        };

        $this->container['service.users'] = function ($c) {
            $config = $c['config'];

            return new Service($config['pathToTemp']);
        };
    }

    /**
     * @return Bootstrap
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param $key
     *
     * @return mixed
     * @throws ContainerIsNotExist
     */
    public function getContainer($key)
    {
        if ($this->container->offsetExists($key)) {
            return $this->container->offsetGet($key);
        } else {
            throw new ContainerIsNotExist("$key is not exist");
        }
    }
}
