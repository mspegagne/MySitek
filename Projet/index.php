<?php

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/apps/app.php';

spl_autoload_register(
    function ($class) {
        $class = str_replace('\\', '/', $class);
        include __DIR__ . "/library/$class.php";
    },
    true,
    true
);

$app->run();
