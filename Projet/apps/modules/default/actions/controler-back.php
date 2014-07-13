<?php

//changer le nom du module
$defaultadmin = $app['controllers_factory'];

/* Routage du module */

$defaultadmin->get('/', function() use ($app) {

    /* Activation de twig avec les templates du module */

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../../../../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/../../../templates/' . $app['template'] . '/',
            __DIR__ . '/../templates/',)
    ));

    $app['selected'] = 'default';

    return $app['twig']->render('back.twig', array(
                'hello' => 'Hello world Back !'
    ));
});

//changer le nom du module
$app->mount('/admin/default', $defaultadmin);
