<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//changer le nom du module
$compte = $app['controllers_factory'];


/* Routage du module */

$compte->get('/', function() use ($app) {

    /* Activation de twig avec les templates du module */

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../../../../../../../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/../../../../../../templates/' . $app['template'] . '/',
            __DIR__ . '/../templates/', __DIR__ . '/../../../templates/',)
    ));

    $app['selected'] = 'compte';
    //TODO  modification des adresses en bdd

    return $app['twig']->render('back.twig', array());
});


$compte->post('/user', function (Request $request) use($app) {

    $csrf = $request->get('csrf');

    if ($csrf == $app['user_id']) {

        $user = array(
            "user_name" => $request->get('user_name'),
            "user_firstName" => $request->get('user_firstName'),
            "user_mail" => $request->get('user_mail')
        );

        $response = Param::saveParams($user, $app);
    } else {
        $response = 'Merci d\'executer la requete au bon endroit...';
    }

    return new Response(json_encode(['response' => $response]), 200);
});

$compte->post('/password', function (Request $request) use($app) {

    $csrf = $request->get('csrf');

    if ($csrf == $app['user_id']) {

        $old_pwd = $request->get('old_pwd');
        $new_pwd = $request->get('pass_confirmation');
        $new_pwd2 = $request->get('pass');

        $response = Param::savePwd($old_pwd, $new_pwd, $new_pwd2, $app);
    } else {
        $response = 'Merci d\'executer la requete au bon endroit...';
    }

    return new Response(json_encode(['response' => $response]), 200);
});



//changer le nom du module
$app->mount('/admin/parametres/compte', $compte);
