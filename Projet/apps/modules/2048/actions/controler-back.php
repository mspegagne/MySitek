<?php

//changer le nom du module
$app2048 = $app['controllers_factory'];

/* Routage du module */

$app2048->get('/', function() use ($app) {

    /* Activation de twig avec les templates du module */

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../../../../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/../../../templates/' . $app['template'] . '/',
            __DIR__ . '/../templates/',)
    ));


    return $app['twig']->render('back.twig');
});

//changer le nom du module
$app->mount('/admin/2048', $app2048);
