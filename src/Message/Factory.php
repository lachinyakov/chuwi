<?php

namespace Messenger\Message;

use Messenger\Message\Message;
use Messenger\Message\Transformers\TransformerInterface;

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
    protected $transformers;

    /**
     * Analisator constructor.
     */
    public function __construct()
    {
        $this->initTransformers();
    }

    /**
     * Анализирует введёные данные.
     *
     * @param $context
     *
     * @return int
     */
    private function analiseType($context)
    {
        $type = Message::TYPE_COMMON_MESSAGE;
        if ("@mrBadger" == $context[0]) {
            $type = Message::TYPE_PRIVATE_MESSAGE;
        }

        return $type;
    }

    /**
     * Инициализирует табличный метод initTransformers()
     */
    private function initTransformers()
    {
        $this->transformers = array(
            Message::TYPE_COMMON_MESSAGE  => new Transformers\ContextToCommonMessage,
            Message::TYPE_PRIVATE_MESSAGE => new Transformers\ContextToPrivateMessage,
        );
    }

    /**
     * Возвращает сформированное сообщение для Sender
     *
     * @param string[] $context Массив данных для формирования сообщения.
     * @return Message
     */
    public function getMessageFromContext($context)
    {
        $type = $this->analiseType($context);
        /**
         * @var TransformerInterface $transformer
         */
        $transformer = $this->transformers[$type];
        $message     = $transformer->transform($context);

        return $message;
    }
}
