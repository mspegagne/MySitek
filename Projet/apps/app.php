<?php

$app = new Silex\Application();

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\Common\Persistence\ObjectManager;


/* Activation de doctrine */

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_sqlite',
        'path' => __DIR__ . '/../data/app.db',
    ),
));

/* Parametres du site */

$app['debug'] = true;
$app['url'] = 'http://'.$_SERVER['HTTP_HOST'].'/';
$app['selected'] = ''; //module en cours (pour affichage lien actif)

require_once __DIR__ . '/../lib/model/Param.php';
Param::load($app);


/* Recuperation du template */

$sql = "SELECT * FROM templates WHERE selected = 1";
$retour = $app['db']->fetchAssoc($sql);
$app['template'] = $retour['name'];


/* Recuperation des modules */

//front à 1 signifie que le module à une partie publique
$sql = "SELECT * FROM modules WHERE selected = 1 AND front = 1 ORDER BY rang ASC";
$app['modules_front'] = $app['db']->fetchAll($sql);

//front à 2 signifie module back
$sql = "SELECT * FROM modules WHERE selected = 1 AND front = 2 ORDER BY rang ASC";
$app['modules_back'] = $app['db']->fetchAll($sql);

//front à 0 signifie module uniquement admin
$sql = "SELECT * FROM modules WHERE selected = 1 AND front = 0 ORDER BY rang ASC";
$app['modules_admin'] = $app['db']->fetchAll($sql);

//front à 3 signifie module param
$sql = "SELECT * FROM modules WHERE selected = 1 AND front = 3 ORDER BY rang ASC";
$app['modules_param'] = $app['db']->fetchAll($sql);

//front à 4 signifie module param_plus
$sql = "SELECT * FROM modules WHERE selected = 1 AND front = 4 ORDER BY rang ASC";
$app['modules_param_plus'] = $app['db']->fetchAll($sql);

//liste modules
$sql = "SELECT * FROM modules WHERE front != -1 ORDER BY rang ASC";
$app['modules'] = $app['db']->fetchAll($sql);



/* Securisation */

$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

require_once __DIR__ . '/../lib/model/UserProvider.php';

/* FIREWALL */
$app['security.firewalls'] = array(
    'user' => array(
        'pattern' => '^/admin/',
        'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check'),
        'logout' => array('logout_path' => '/admin/logout'),
        'users' => $app->share(function () use ($app) {
            return new UserProvider($app['db']);
        }),
    ),
);

        
        
/* Login */

$app->register(new Silex\Provider\SessionServiceProvider());


$app->get('/login', function(Request $request) use ($app) {

    #echo (new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder())->encodePassword('foo', '');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/templates/' . $app['template'] . '/')
    ));

    return $app['twig']->render('login.twig', array(
                'error' => $app['security.last_error']($request),
                'last_username' => $app['session']->get('_security.last_username')
    ));
});



/* Routage */

$app->get('/', function() use ($app) {

    return $app->redirect('/' . $app['index']);
});

$app->get('/admin/', function() use ($app) {

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/templates/' . $app['template'] . '/')
    ));

    return $app['twig']->render('admin.twig', array(
                'hello' => 'Hello world Admin !',
    ));
});

$app->get('/admin/notif/{notif}', function($notif) use ($app) {

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/templates/' . $app['template'] . '/')
    ));

    switch ($notif) {
        case 'installok':
            return $app['twig']->render('admin.twig', array(
                        'hello' => 'Hello world Admin !',
                        'notif' => 'Le fichier est maintenant installé', //notif peut contenir du html
                        'time' => '5000'
            ));
        case 'installnok':
            return $app['twig']->render('admin.twig', array(
                        'hello' => 'Hello world Admin !',
                        'notif' => 'Erreur lors de l\\\'installation...',//Il faut mettre trois barres pour escape
                        'time' => '5000'
            ));
        default :
            return $app->redirect('/admin/');
    }
});

$app->get('/admin/achat/{type}/{file}', function ($type, $file) use ($app) {

    require_once __DIR__ . '/../lib/payplug/lib/Payplug.php';

    Payplug::setConfigFromFile(__DIR__ . '/../lib/payplug/parameters.json');

    $ipn = 'http://api.mysitek.com/payplug/ipn.php?user=' . $app['user'] . '&amp;type=' . $type . '&amp;module=' . $file . '';
    $install = $app['url'] . 'admin/install/' . $type . '/' . $file . '';

    //TODO #API : Récupération de l'objet module et remplir à partir la variable prix ci dessous :
    $prix = '0150';

    if ($prix == 0) {
        //TODO #TOKEN
        //execution de $ipn
        //l'api sait à partir du nom du module que le prix est de 0
        //Donc maj token               

        return $app->redirect('/admin/install/' . $type . '/' . $file . '');
    } else {


        //TODO : Récupération des variables ci dessous à partir des parametres en db client :
        $prenom = 'john';
        $nom = 'doe';

        $paymentUrl = PaymentUrl::generateUrl(array(
                    'amount' => $prix,
                    'currency' => 'EUR',
                    'ipnUrl' => $ipn,
                    'returnUrl' => $ipn,
                    'email' => $app['user'],
                    'firstName' => $prenom,
                    'lastName' => $nom
        ));

        header("Location: $paymentUrl");
        exit();

        return '';
    }
});


$app->get('/admin/delete/{type}/{file}', function($type, $file) use ($app) {
    
    require_once __DIR__ . '/../lib/model/Install.php';
    
    $error = Install::delete($file, $type, $app);

    if ($error == '') {
        return $app->redirect('/admin/maj/notif/deleteok');
    } else {
        return $app->redirect('/admin/maj/notif/deletenok');
    }
});


$app->post('/admin/update', function (Request $request) use ($app) {
    
    $type = $request->get('type'); 
    $file = $request->get('file'); 
    
    require_once __DIR__ . '/../lib/model/Install.php';

    //TODO #TOKEN : checkToken pour confirmer paiement si ok alors install
    //a voir car possible pb de timing, les deux scripts sont exécutés en meme tps à l'issu du paiement...
    //au pire ca installe (le client doit d'abord trouver l'url) et il se fera niquer lors du checkToken :P
    //peut également servir pour une future periode de test 

    $error = Install::update($file, $type, $app);
  
    return new Response($error,200);
    
});


$app->post('/admin/install', function (Request $request) use ($app) {
    
    $type = $request->get('type'); 
    $file = $request->get('file'); 
    
    require_once __DIR__ . '/../lib/model/Install.php';

    //TODO #TOKEN : checkToken pour confirmer paiement si ok alors install
    //a voir car possible pb de timing, les deux scripts sont exécutés en meme tps à l'issu du paiement...
    //au pire ca installe (le client doit d'abord trouver l'url) et il se fera niquer lors du checkToken :P
    //peut également servir pour une future periode de test 

    $error = Install::installation($file, $type, $app);

    return $error;
    
});


$app->get('/admin/install/{type}/{file}', function ($type, $file) use ($app) {

    require_once __DIR__ . '/../lib/model/Install.php';
    
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.class_path' => __DIR__ . '/../vendor/Twig/lib',
        'twig.path' => array(__DIR__ . '/templates/' . $app['template'] . '/')
    ));

    //TODO #TOKEN : checkToken pour confirmer paiement si ok alors install
    //a voir car possible pb de timing, les deux scripts sont exécutés en meme tps à l'issu du paiement...
    //au pire ca installe (le client doit d'abord trouver l'url) et il se fera niquer lors du checkToken :P
    //peut également servir pour une future periode de test 
    
    $error = Install::installation($file, $type, $app);

    if ($error == '') {
        return $app->redirect('/admin/notif/installok');
    } else {
        return $app->redirect('/admin/notif/installnok');
    }
});

//Routage des différents modules

foreach ($app['modules_back'] as $module) {

    include_once __DIR__ . '/modules/' . $module['lien'] . '/actions/controler-back.php';
}

foreach ($app['modules_admin'] as $module) {

    include_once __DIR__ . '/modules/admin/' . $module['lien'] . '/actions/controler-back.php';
}

foreach ($app['modules_param_plus'] as $module) {

    include_once __DIR__ . '/modules/' . $module['lien'] . '/actions/controler-back.php';
}

foreach ($app['modules_param'] as $module) {

    include_once __DIR__ . '/modules/admin/parametres/modules/' . $module['lien'] . '/actions/controler-back.php';
}

foreach ($app['modules_front'] as $module) {

    include_once __DIR__ . '/modules/' . $module['lien'] . '/actions/controler-back.php';
    include_once __DIR__ . '/modules/' . $module['lien'] . '/actions/controler-front.php';
}



return $app;



