<?php

require_once __DIR__ . '/../vendor/autoload.php';

$message   = isset($argv[1]) && !empty($argv[1]) ? $argv[1] : 'empty';
$bootstrap = \Messenger\Bootstrap::getInstance();
$sender    = $bootstrap->getContainer('sender');
$sender->send($message);
