<?php

namespace Messenger;

use Messenger\Analyzer\Analyzer;
use Messenger\Exception\ContainerIsNotExist;
use Messenger\Publishers\Publisher;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Pimple\Container;
use Messenger\User\UserService;

class Bootstrap
{

    protected static $instance;

    /**
     * Bootstrap constructor.
     */
    protected function __construct()
    {
        $this->container           = new Container();
        $this->container['config'] = function ($c) {
            $config = require_once __DIR__ . "/../config/config.php";

            return $config;
        };

        /**
         * @param $c
         *
         * @return AMQPStreamConnection
         */
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

        /**
         * @param $c
         *
         * @return Publisher
         */
        $this->container['publisher'] = function ($c) {
            $connection  = $c['amqp.connection'];

            return new Publisher($connection);
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

        /**
         * Фабрика сущности сообщения для чата.
         *
         * @return Message\Factory
         */
        $this->container['message.factory'] = function ($c) {
            return new Message\Factory($c['user.service'], $c['analyzer']);
        };

        /**
         * Обработчи введной информации пользователем.
         *
         * @param $c
         *
         * @return Context\Handler
         */
        $this->container['context.handler'] = function ($c) {
            return new Context\Handler($c['user.service'], $c['analyzer']);
        };

        /**
         * Анализатор типа сообщения.
         *
         * @return Context\Handler
         */
        $this->container['analyzer'] = function () {
            return new Analyzer();
        };

        /**
         * Сервис для работы с пользователем.
         *
         * @param $c
         *
         * @return UserService
         */
        $this->container['user.service'] = function ($c) {
            $config = $c['config'];

            return UserService::getInstance($config['pathToTemp']);
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
