#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Config;
use App\Workers\RenewalWorker;

// Load configuration
Config::load();

// Handle graceful shutdown
pcntl_signal(SIGTERM, function() {
    exit(0);
});

pcntl_signal(SIGINT, function() {
    exit(0);
});

$worker = new RenewalWorker();
$worker->start();

