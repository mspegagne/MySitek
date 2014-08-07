#!/usr/bin/env php
<?php

spl_autoload_register(
    function ($class) {
        $class = str_replace('\\', '/', $class);
        include __DIR__ . "/../library/$class.php";
    },
    true,
    true
);

require_once '../vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new MySitek\Command\OneModuleInfo());
$application->add(new MySitek\Command\TestMyServer());
$application->run();