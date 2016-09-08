#!/usr/bin/php
<?php

$consumers = array(
    "v",
    "moshhh",
    "cnam",
    "domio"
);


readline_completion_function('consumers');

$input = readline("Send message: ");

print "message send\n";
