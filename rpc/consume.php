<?php

require_once __DIR__ . '/../vendor/autoload.php';

$room      = isset($argv[1]) && !empty($argv[1]) ? $argv[1] : '';
$bootstrap = \Messenger\Bootstrap::getInstance();
$consumer  = $bootstrap->getContainer('consumer');
/**
 * @var \Messenger\Consumer $consumer
 */
$consumer->consume($room);

