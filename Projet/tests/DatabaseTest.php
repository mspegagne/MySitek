<?php

use Silex\WebTestCase;

class DatabaseTest extends WebTestCase {

    public function createApplication() {
        $app = require __DIR__ . '/../apps/app.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();

        return $app;
    }

    /**
    * @small
    */
    public function testDatabase() {
        $app = self::createApplication();
        $response = FALSE;
        $sql = "INSERT INTO param (ref, value) VALUES (?,?)";
        if ($app['db']->executeUpdate($sql, array(testing, testing))) {
            $response = TRUE;
        }
        $sql = "DELETE FROM param WHERE ref = ?";
        if (!$app['db']->executeUpdate($sql, array(testing))) {
            $response = FALSE;
        }
        $this->assertTRUE($response);
    }

}