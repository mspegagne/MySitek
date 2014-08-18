<?php

//changer le nom du module
$theme = $app['controllers_factory'];


/* Routage du module */

$theme->get('/', function() use ($app) {

    /* Activation de twig avec les templates du module */

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../../../../../../../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/../../../../../../templates/' . $app['template'] . '/',
            __DIR__ . '/../templates/', __DIR__ . '/../../../templates/',)
    ));

    
    $app['selected'] = 'theme';

    $response = Param::getBackground($app);
    
    return $app['twig']->render('back.twig', array(
                'dossier' => $response));
});

//changer le nom du module
$app->mount('/admin/parametres/theme', $theme);
