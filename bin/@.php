#!/usr/bin/php
<?php



$consumers = array(
    "v",
    "moshhh",
    "cnam",
    "domio"
);


function consumers() {
    global $consumers;
    return $consumers;
};

function sendMessage() {
    readline_completion_function('consumers');

    $input = readline("Send message: ");



    print "message send\n";
}

