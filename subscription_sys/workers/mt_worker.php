#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Config;
use App\Workers\MtWorker;

// Load configuration
Config::load();

// Handle graceful shutdown
pcntl_signal(SIGTERM, function() {
    \App\RabbitMQ::close();
    exit(0);
});

pcntl_signal(SIGINT, function() {
    \App\RabbitMQ::close();
    exit(0);
});

$worker = new MtWorker();
$worker->start();

