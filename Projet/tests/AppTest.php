<?php

use Silex\WebTestCase;

class AppTest extends WebTestCase {

    public function createApplication() {
        $app = require __DIR__ . '/../apps/app.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();

        return $app;
    }
 
    public function testIndex() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/accueil/');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertTrue($crawler->filter('html:contains("Accueil")')->count() > 0);
    }

}
