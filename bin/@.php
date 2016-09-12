#!/usr/bin/php
<?php

$consumers = array(
    "@msBadger",
    "@v",
    "dghost",
    "domio",
    "irvis",
    "ilia",
    "max",
    "alexander",
    "cnam",
    "moshhh",
);


function consumers() {
    global $consumers;

    return $consumers;
};

if (isset($argv)) {
    consumeMessage();
}

function consumeMessage() {
    readline_completion_function('consumers');
    $input = readline("Send message: ");

    var_dump($input);
    exit;
    print "message send\n";
}


