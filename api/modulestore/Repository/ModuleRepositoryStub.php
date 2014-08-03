<?php

namespace Repository;

use Entity\ModuleEntityStub;

class ModuleRepositoryStub extends AbstractRepository {
    
    public function getElements($template, $page, $maxElement, $sort) {
        return array();
    }
    
    protected function getElementInDb($name) {
        return new ModuleEntityStub();
    }
}
