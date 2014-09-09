<?php

//changer le nom du module
$accueiladmin = $app['controllers_factory'];

/* Routage du module */

$accueiladmin->get('/', function() use ($app) {

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

    function getTxt($app, $ref) {

        return Service\getValue($app, 'accueil', 'accueil_text', $ref);
    }

    $description = getTxt($app, 'description');

    $box1 = getTxt($app, 'box1');

    $box2 = getTxt($app, 'box2');

    $box3 = getTxt($app, 'box3');

    return $app['twig']->render('back.twig', array(
                'description' => $description,
    ));
});

//changer le nom du module
$app->mount('/admin/accueil', $accueiladmin);
