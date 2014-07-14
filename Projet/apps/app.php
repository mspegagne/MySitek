<?php

$app = new Silex\Application();

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/* Activation de doctrine */

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_sqlite',
        'path' => __DIR__ . '/../data/app.db',
    ),
));

use Doctrine\Common\Persistence\ObjectManager;

/* Parametres du site */

$app['siteName'] = 'MySitek';
$app['debug'] = true;
$app['selected'] = ''; //module en cours (pour affichage lien actif)


/* Recuperation du template */

$sql = "SELECT * FROM templates WHERE selected = 1";
$retour = $app['db']->fetchAssoc($sql);
$app['template'] = $retour['name'];

/* Recuperation du module index */

$sql = "SELECT * FROM modules WHERE accueil = 1";
$retour = $app['db']->fetchAssoc($sql);
$app['index'] = $retour['lien'];



/* Recuperation des modules */

//front à 1 signifie que le module à une partie publique
$sql = "SELECT * FROM modules WHERE selected = 1 AND front = 1";
$app['modules_front'] = $app['db']->fetchAll($sql);

//front à 0 signifie module back
$sql = "SELECT * FROM modules WHERE selected = 1 AND front = 0";
$app['modules_back'] = $app['db']->fetchAll($sql);

//front à -1 signifie module uniquement admin
$sql = "SELECT * FROM modules WHERE selected = 1 AND front = -1";
$app['modules_admin'] = $app['db']->fetchAll($sql);



/* ADD TEMPLATE A implementer dans install.php */

// $sql = "INSERT INTO templates (name,selected) VALUES (?,?)";
// $app['db']->executeUpdate($sql, array(--valeurs--));



/* ADD MODULE  A implementer dans install.php */


// $sql = "INSERT INTO modules (name, lien, icon, selected, front, accueil) VALUES (?,?,?,?,?,?)";
// $app['db']->executeUpdate($sql, array(--valeurs--));


/* Securisation */

$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

include_once __DIR__ . '/../lib/model/UserProvider.php';
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
                'hello' => 'Hello world Admin !'
    ));
    
});

//Routage des différents modules

foreach ($app['modules_back'] as $module) {

    include_once __DIR__ . '/modules/' . $module['lien'] . '/actions/controler-back.php';
}

foreach ($app['modules_admin'] as $module) {

    include_once __DIR__ . '/modules/admin/' . $module['lien'] . '/actions/controler-back.php';
}


foreach ($app['modules_front'] as $module) {
    
    include_once __DIR__ . '/modules/' . $module['lien'] . '/actions/controler-back.php';
    include_once __DIR__ . '/modules/' . $module['lien'] . '/actions/controler-front.php';
}



return $app;



