#!/usr/bin/php
<?php
require_once __DIR__ . '/../vendor/autoload.php';


$consumers = array(
    "mrBadger",
    "v",
    "dghost",
    "domio",
    "irvis",
    "ilia",
    "max",
    "alexander",
    "cnam",
    "moshhh",
    "slack/me",
    "slack/barabule4ka",
    "telegram"
);


function consumers() {
    global $consumers;

    return $consumers;
};

if (isset($argv[1])) {
    consumeMessage($argv);
}

function consumeMessage($context) {

    array_shift($context);
    readline_completion_function('consumers');

    $consumeConsumers = trim(readline("Input Consumers: "));
    if (!empty($consumeConsumers)){
        $consumers = explode(" ", $consumeConsumers);
        foreach ($consumers as $key => $consumer)
        {
            $consumers[$key] = '@' . $consumer;
        }

        $context = array_merge($consumers, $context);
    }
    $bootstrap = \Messenger\Bootstrap::getInstance();
    /**
     * @var \Messenger\Message\Factory $messageFactory
     */
    $messageFactory = $bootstrap->getContainer('message.factory');
    $message = $messageFactory->getMessageFromContext($context);
    var_dump($message);
}


