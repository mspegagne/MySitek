<?php

    date_default_timezone_set('Europe/Paris');

    $composer = require_once __DIR__ . '/vendor/autoload.php';

    // Ajouter le répertoire du projet $composer->add();

    include_once __DIR__ . '/public/index.php';
