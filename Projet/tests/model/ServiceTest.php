<?php

class ServiceTest extends PHPUnit_Framework_TestCase {
  
   public function testGetDossier()
    {
        $dossier = Service\getDossier(__DIR__ . '/../../apps/');
        $this->assertNotEmpty($dossier);        
    }
    
}