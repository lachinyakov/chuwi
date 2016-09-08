<?php

namespace Messenger;

use Messeger\Exception\ContainerIsNotExist;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Pimple\Container;

class Bootstrap
{

    protected static $instance;

    /**
     * Bootstrap constructor.
     */
    protected function __construct()
    {
        $this->container = new Container();

        $this->container['config'] = function($c) {
            $config = require_once __DIR__ . "/../config/config.php";

            return $config;
        };

        $this->container['amqp.connection'] = function($c) {
            $config = $c['config'];
            $connection = new AMQPStreamConnection(
                $config['host'],
                $config['port'],
                $config['user'],
                $config['password']
            );

            return $connection;
        };

        $this->container['sender'] = function($c) {
            $connection = $c['amqp.connection'];

             return new Sender($connection);
        };

        /**
         * @param $c
         * @return Consumer
         */
        $this->container['consumer'] = function($c) {
            $connection = $c['amqp.connection'];

             return new Consumer($connection);
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
     * @return mixed
     * @throws ContainerIsNotExist
     */
    public function getContainer($key) {
        if ($this->container->offsetExists($key)) {
            return $this->container->offsetGet($key);
        } else {
            throw new ContainerIsNotExist("$key is not exist");
        }
    }
}
