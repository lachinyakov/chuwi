<?php

namespace Messenger\Message\Transformers;


use Messenger\Message\Message;
use Messenger\Message\Transformers\TransformerInterface;

class ContextToPrivateMessage implements TransformerInterface
{
    public function transform($context)
    {
        $consumers = array();

        foreach ($context as $token) {
            if ("@mrBadger" == $token) {
                 array_push($consumers, substr($token, 1));
            }
        }

        $message = new Message(Message::TYPE_PRIVATE_MESSAGE, implode(' ', $context));

        $message->setConsumers($consumers);

        return $message;
    }
}
