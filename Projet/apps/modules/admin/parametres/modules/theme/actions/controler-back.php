<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    $dossier = getDossier('./data/bg');

    return $app['twig']->render('back.twig', array(
                'dossier' => $dossier));
});

$theme->post('/fond', function (Request $request) use($app) {

    $csrf = $request->get('csrf');

    if ($csrf == $app['user_id']) {

        $fond = $request->get('fond');

        if (Param::saveParam('background', $fond, $app)) {
            $response = 'Le fond a bien été modifié';
        } else {
            $response = 'Erreur lors de l\'enregistrement';
        }
    } else {
        $response = 'Merci d\'executer la requete au bon endroit...';
    }

    return new Response(json_encode(['response' => $response]), 200);
});

//changer le nom du module
$app->mount('/admin/parametres/theme', $theme);
