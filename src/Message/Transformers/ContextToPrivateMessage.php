<?php

namespace Messenger\Message\Transformers;


use Messenger\Message\Message;

class ContextToPrivateMessage implements \TransformerInterface
{

    /**
     * @param $context
     * @return mixed|void
     */
    public function transform($context)
    {
       return new Message(Message::TYPE_COMMON_MESSAGE, implode(" ", $context));
    }
}
