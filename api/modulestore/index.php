<?php

date_default_timezone_set('Europe/Paris');

// Chemin vers le répertoire de l'application
defined('APPLICATION_PATH') || define(
    'APPLICATION_PATH',
    (
        getenv('APPLICATION_PATH')
        ? getenv('APPLICATION_PATH')
        : realpath(dirname(__FILE__) . '/application')
    )
);

// Environnement de l'application
defined('APPLICATION_ENV') || define(
    'APPLICATION_ENV',
    (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production')
);

set_include_path(
    implode(
        PATH_SEPARATOR,
        array(
            realpath(APPLICATION_PATH . '/../library'),
            get_include_path(),
        )
    )
);

// Defini le fichier de configuration par défaut
$defaultConfigFile = APPLICATION_PATH . '/config/application.ini';
defined('APPLICATION_CONFIG') || define(
    'APPLICATION_CONFIG',
    (getenv('APPLICATION_CONFIG') ? getenv('APPLICATION_CONFIG') : $defaultConfigFile)
);

// Composer
$composer = require_once __DIR__ . '/vendor/autoload.php';

/**
 * @todo Ajouter le répertoire du projet $composer->add();
 * plutot que d'avoir l'autoloader tout moche du dessous
 */

spl_autoload_register(
    function ($class) {
        $class = str_replace('\\', '/', $class);
        include __DIR__ . "/library/$class.php";
    },
    true,
    true
);

// Point d'entrée de l'application
include_once __DIR__ . '/public/index.php';
