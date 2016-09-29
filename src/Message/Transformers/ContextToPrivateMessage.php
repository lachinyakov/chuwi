<?php

namespace Messenger\Message\Transformers;


use Messenger\Message\Message;
use Messenger\Message\Transformers\TransformerInterface;

class ContextToPrivateMessage implements TransformerInterface
{
    /**
     * Трансформирует контекст в сообщение.
     *
     * @param $context
     * @return mixed
     */
    public function transform($context)
    {
        $consumers = array();

        foreach ($context as $token) {
            /**
             * @todo: Доделать проверку пользователей искать в проекте по  CheckHasUser
             */
            if ("@mrBadger" == $token || "@cds" == $token) {
                 array_push($consumers, substr($token, 1));
            }
        }

        $message = new Message(Message::TYPE_PRIVATE_MESSAGE, implode(' ', $context));

        $message->setConsumers($consumers);

        return $message;
    }
}
