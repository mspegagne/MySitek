<?php

//changer le nom du module
$default = $app['controllers_factory'];

/* Routage du module */

$default->get('/', function() use ($app) {

    /* Activation de twig avec les templates du module */

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../../../../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/../../../templates/' . $app['template'] . '/',
            __DIR__ . '/../templates/',)
    ));

    $app['selected'] = 'dashboard';

    return $app['twig']->render('index.twig', array(
                'hello' => 'Hello world !'
    ));
});

//changer le nom du module
$app->mount('/default', $default);
