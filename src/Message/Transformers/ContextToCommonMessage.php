<?php

namespace Messenger\Message\Transformers;


use Messenger\Message\Message;
use Messenger\Message\Transformers\TransformerInterface;

class ContextToCommonMessage implements TransformerInterface
{
    /**
     * @param $context
     * @return mixed
     */
    public function transform($context)
    {
       return new Message(Message::TYPE_COMMON_MESSAGE, implode(' ', $context));
    }
}
