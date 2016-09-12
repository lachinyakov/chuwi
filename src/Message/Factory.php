<?php

namespace Messenger\Message;

use Messenger\Message\Message;

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
     * @var array
     */
    private $context;

    /**
     * @var Message;
     */
    private $message;


    protected $transformers;

    /**
     * Analisator constructor.
     * @param $context
     */
    public function __construct($context)
    {
        $this->context = $context;
        $this->initTransformers();
        $this->transform($context);
    }

    /**
     * Возвращает сообщение.
     *

     * @return \Messenger\Message\Message
     */
    public function getMessage()
    {
        return $this->message;
    }


    private function transform($context)
    {
        $type = $this->analiseType($context);
        /**
         * @var \TransformerInterface $transformer
         */
        $transformer = $this->transformers[$type];
        $message     = $transformer->transform($context);

        return $message;

    }

    /**
     * Анализирует введёные данные.
     * На основе их формирует
     *
     * @param $context
     *
     * @return int
     */
    private function analiseType($context)
    {
        $type = Message::TYPE_COMMON_MESSAGE;
        if ("@consumer" == $context[0]) {
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
}
