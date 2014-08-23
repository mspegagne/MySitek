<?php

use Silex\WebTestCase;

class ModuleTest extends WebTestCase {

    public function createApplication() {
        $app = require __DIR__ . '/../../apps/app.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();

        return $app;
    }
    
    public function testConvertType()
    {
        $this->assertEquals(0, Module::convertType('admin'));
        $this->assertEquals(1, Module::convertType('front'));
        $this->assertEquals(2, Module::convertType('back'));   
        $this->assertEquals(3, Module::convertType('param'));
        $this->assertEquals(4, Module::convertType('param_plus'));
    }
    
    public function testGetList()
    {
        $app = self::createApplication();
        Module::getList($app, 'test');
        $this->assertNotEmpty($app['modules_test']);        
    }
    
    public function testGetAll()
    {
        $app = self::createApplication();
        Module::getAll($app);
        $this->assertNotEmpty($app['modules']);       
    }
    
    public function testRang()
    {
        $app = self::createApplication();
        $response = Module::rang('test', 'admin', $app);
        $this->assertEquals('Erreur...', $response);       
    }
    
}