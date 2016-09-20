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


consumeInput($argv);

function consumeInput($input) {
    $bootstrap      = \Messenger\Bootstrap::getInstance();
    /**
     * @var \Messenger\Context\Handler $contextHandler
     */
    $contextHandler = $bootstrap->getContainer('context.handler');
    $contextHandler->handle($input);
    $context        = $contextHandler->getContext();
    /**
     * @var \Messenger\Message\Factory $messageFactory
     */
    $messageFactory = $bootstrap->getContainer('message.factory');
    $message        = $messageFactory->getMessageFromContext($context);
    var_dump($message);
}


