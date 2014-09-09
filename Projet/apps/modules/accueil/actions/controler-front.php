<?php

//changer le nom du module
$accueil = $app['controllers_factory'];

/* Routage du module */

$accueil->get('/', function() use ($app) {

    /* Activation de twig avec les templates du module */

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../../../../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/../../../templates/' . $app['template'] . '/',
            __DIR__ . '/../templates/',)
    ));

    $app->register(new Silex\Provider\DoctrineServiceProvider(), array(
        'dbs.options' => array(
            'app' => array(
                'driver' => 'pdo_sqlite',
                'path' => __DIR__ . '/../../../../data/app.db',
            ),
            'accueil' => array(
                'driver' => 'pdo_sqlite',
                'path' => __DIR__ . '/../../../../data/accueil/accueil.db',
            ),
        ),
    ));

    $app['selected'] = 'accueil';

    function getTxt($app, $ref) {

        return Service\getValue($app, 'accueil', 'accueil_text', $ref);
    }

    $description = getTxt($app, 'description');

    $box1 = getTxt($app, 'box1');

    $box2 = getTxt($app, 'box2');

    $box3 = getTxt($app, 'box3');

    return $app['twig']->render('front.twig', array(
                'description' => $description,
                'box1' => $box1,
                'box2' => $box2,
                'box3' => $box3,
    ));
});

//changer le nom du module
$app->mount('/accueil', $accueil);
