<?php

//changer le nom du module
$store = $app['controllers_factory'];

/* Routage du module */

$store->get('/', function() use ($app) {

    /* Activation de twig avec les templates du module */

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../../../../../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/../../../../templates/' . $app['template'] . '/',
            __DIR__ . '/../templates/',)
    ));

    //TODO #API : récupération de la liste des modules avec API -> remplissage array pour transmettre à twig

    return $app['twig']->render('back.twig', array(
                'hello' => 'Hello world Module ! Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.'
    ));
});

//changer le nom du module
$app->mount('/admin/store', $store);
