<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//changer le nom du module
$accueiladmin = $app['controllers_factory'];




/* Routage du module */

$accueiladmin->get('/', function() use ($app) {

    function getTxt($app, $ref) {

        return Service\getValue($app, 'accueil', 'accueil_text', $ref);
    }

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

    $description = getTxt($app, 'description');

    $box1 = getTxt($app, 'box1');

    $box2 = getTxt($app, 'box2');

    $box3 = getTxt($app, 'box3');

    return $app['twig']->render('back.twig', array(
                'description' => $description,
    ));
});

$accueiladmin->post('/description_form', function (Request $request) use($app) {

    function saveTxt($app, $ref, $data) {

        return Service\saveValue($app, 'accueil', 'accueil_text', $ref, $data);
    }
    
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
    
    $response = 'Erreur lors de l\'enregistrement';

    $csrf = $request->get('csrf');  

    if ($csrf == $app['user_id']) {

        $description = $request->get('description');

        if (saveTxt($app, 'description', $description)) {
            $response = 'Le texte a bien été modifié';
        }
    } else {
        $response = 'Merci d\'executer la requete au bon endroit...';
    }

    return new Response(json_encode(['response' => $response]), 200);
});

//changer le nom du module
$app->mount('/admin/accueil', $accueiladmin);
