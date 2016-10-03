<?php

namespace Messenger\Context;

use Messenger\Analyzer\Analyzer;
use Messenger\Message\Message;
use Messenger\User\UserService;

class Handler
{
    const TOKEN_USER_TAG = '@';

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var Analyzer
     */
    protected $analyzer;
    protected $context;

    /**
     * Handler constructor.
     *
     * @param $userService
     * @param $analyzer
     */
    public function __construct($userService, $analyzer)
    {
        $this->userService = $userService;
        $this->analyzer    = $analyzer;
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
        $typeOfMessage = $this->analyzer->getTypeOfMessage($arguments);
        if (Message::TYPE_PRIVATE_MESSAGE != $typeOfMessage) {
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
    public function getUsers($input = '', $index = 0)
    {
        return $this->userService->getUsersNames();
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
                $consumers[$key] = self::TOKEN_USER_TAG . $consumer;
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
