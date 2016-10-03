<?php

namespace Messenger\Message;

use Messenger\Analyzer\Analyzer;
use Messenger\Message\Transformers\TransformerInterface;
use Messenger\User\UserService;

/**
 * Класс фабрика сообщения.
 * Предназначен для анализа введённых пользователем
 * данных и на основе их основе формирования сообщения.
 *
 * Class Factory
 * @package Messenger\Message
 */
class Factory
{
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var Analyzer
     */
    protected $analyzer;
    protected $transformers;

    /**
     * @param $analyzer
     * @param $userService
     */
    public function __construct($userService, $analyzer)
    {
        $this->userService = $userService;
        $this->analyzer    = $analyzer;
        $this->initTransformers();
    }

    /**
     * Инициализирует табличный метод initTransformers()
     */
    private function initTransformers()
    {
        $this->transformers = array(
            Message::TYPE_COMMON_MESSAGE  => new Transformers\ContextToCommonMessage,
            Message::TYPE_PRIVATE_MESSAGE => new Transformers\ContextToPrivateMessage($this->userService),
        );
    }

    /**
     * Возвращает сформированное сообщение для Publisher
     *
     * @param string[] $context Массив данных для формирования сообщения.
     *
     * @return Message
     */
    public function getMessageFromContext($context)
    {
        $type = $this->analyzer->getTypeOfMessage($context);
        /**
         * @var TransformerInterface $transformer
         */
        $transformer = $this->transformers[$type];
        $message     = $transformer->transform($context);

        return $message;
    }
}
