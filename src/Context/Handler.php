<?php

namespace Messenger\Context;

use Messenger\User\UserService;
use Pimple\Container;

class Handler
{
    /**
     * Конечный массив данных, введёных пользователем
     * для создания сообщения.
     *
     * @var string[]
     */
    protected $context;
    /**
     * @var Container
     */
    protected $container;

    /**
     * Handler constructor.
     *
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }


    /**
     * Обрабатывает первичный масссив аргументов,
     * введеный пользователем и формирует в требуемый контекст.
     *
     * @param $arguments
     */
    public function handle($arguments)
    {
        array_shift($arguments);
        if (!empty($arguments)) {
            $this->consumeArguments($arguments);
        } else {
            $this->offerSetArguments();
        }
    }

    /**
     * Принимает и обрабатывает аргументы,
     * в случае, если не добавлен ни один пользователь - предлагает его
     * добавить.
     *
     * @param $arguments
     *
     * @return mixed
     */
    private function consumeArguments($arguments)
    {
        $this->context = $arguments;

        if ('@mrBadger' === $arguments[0]) {
            return $arguments;
        } else {
            $this->offerAddConsumers();
        }
    }

    /**
     * Возвращает Список доступных пользователй для отправки приватным
     * сообщением.
     *
     * @param $input
     * @param $index
     *
     * @return string[]
     */
    public function getUsers($input, $index)
    {
        /**
         * @var UserService $userService
         */
        $userService = $this->container['user.service'];

        return $userService->getUsersNames();
    }

    /**
     * Предлагает ввести получателей.
     */
    private function offerAddConsumers()
    {
        readline_completion_function(
            array(
                $this,
                'getUsers',
            )
        );
        $consumeConsumers = trim(readline("Input Consumers: "));
        if (!empty($consumeConsumers)) {
            $consumers = explode(" ", $consumeConsumers);
            foreach ($consumers as $key => $consumer) {
                $consumers[$key] = '@' . $consumer;
            }

            $this->context = array_merge($consumers, $this->context);
        }
    }

    /**
     * Предлагает ввести сообщение.
     */
    private function offerSetArguments()
    {
        echo "\nPlease Input message: ";
        $message = trim(fgets(STDIN));

        if (!empty($message)) {
            $this->consumeArguments(explode(" ", $message));
        }
    }

    /**
     * Возвращает сформированный контекст.
     *
     * @return string[]
     */
    public function getContext()
    {
        return $this->context;
    }
}
