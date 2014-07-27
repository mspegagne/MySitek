<?php

namespace Repository;

use Entity\ModuleEntity;

class ModuleRepository implements RepositoryInterface {
    
    /**
     * @var ModuleEntity[]
     */
    protected $modules;
    
    public function getElementByName($name) {
        /**
         * @todo vérifier si le nom est valide
         */
        return $this->modules[$name];
    }
}
