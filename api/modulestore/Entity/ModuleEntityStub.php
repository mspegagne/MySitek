<?php

namespace Entity;

class ModuleEntityStub extends ModuleEntity {
    
    public function __construct() {
        
        $this->name = 'Module Stub';
        $this->editor = 'MySitek Inc.';
        $this->version = '0.1.1';
        $this->creationDate = new \DateTime("2014-07-20 11:14:15.638276");
        $this->lastModificationDate = new \DateTime("2014-08-02 11:14:15.638276");
        $this->dependencies = array();
        $this->shortDescription = 'Module Stub est un exemple de module.';
        $this->description = 'Module Stub permet de faire des tests sans utiliser de base de donnée.';
        $this->stars = 3.5;
        $this->numberOfUsers = 500;
        $this->logo = 'http://upload.wikimedia.org/wikipedia/commons/thumb/d/d1/Wikipedia-logo-v2-fr.svg/150px-Wikipedia-logo-v2-fr.svg.png';
        $this->images = array();
        $this->opinions = array();
        $this->otherInformations = array();
    }
}
