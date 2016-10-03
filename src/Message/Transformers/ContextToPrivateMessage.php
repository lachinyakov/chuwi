<?php

namespace Messenger\Message\Transformers;


use Messenger\Message\Message;
use Messenger\Message\Transformers\TransformerInterface;
use Messenger\User\UserService;

class ContextToPrivateMessage implements TransformerInterface
{
    const PRIVATE_MESSAGE_TAG = '@';
    /**
     * @var UserService
     */
    private $userService;

    /**
     * ContextToPrivateMessage constructor.
     *
     * @param $userService
     */
    public function __construct($userService)
    {
        $this->userService = $userService;
    }

    /**
     * Трансформирует контекст в сообщение.
     *
     * @param $context
     *
     * @return mixed
     */
    public function transform($context)
    {
        $consumers = $this->getConsumersFromContext($context);
        $message = new Message(
            Message::TYPE_PRIVATE_MESSAGE, implode(' ', $context)
        );

        $message->setConsumers($consumers);

        return $message;
    }

    /**
     * @param $context
     *
     * @return mixed
     * @internal param $usersNames
     *
     */
    protected function getConsumersFromContext($context)
    {
        $consumers = array();
        $usersNames = $this->userService->getUsersNames();
        foreach ($context as $token) {
            if (! self::PRIVATE_MESSAGE_TAG == $token[0]) {
                break;
            }

            $consumerName = substr($token, 1);
            if (! in_array($consumerName, $usersNames)) {
                break;
            }

            $consumer = $this->userService->getUserByName($consumerName);
            array_push($consumers, $consumer);
        }

        return $consumers;
    }
}
