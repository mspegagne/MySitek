<?php

namespace Repository;

use Entity\ModuleEntity;

class ModuleRepository implements RepositoryInterface {
    
    /**
     * @var ModuleEntity[]
     */
    protected $modules;
    
    /**
     * {@inheritdoc}
     */
    public function getElementByName($name) {
        /**
         * @todo vérifier si le nom est valide
         */
        return $this->modules[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function getElementByNames(array $names) {
        /**
         * @todo
         */
    }

    /**
     * {@inheritdoc}
     */
    public function getElements($template, $page = -1, $maxElement = -1, $sort = 'asc') {
        /**
         * @todo
         */
    }

}
