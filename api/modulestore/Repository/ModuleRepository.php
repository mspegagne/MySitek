<?php

namespace Repository;

class ModuleRepository extends AbstractRepository {
    
    /**
     * {@inheritdoc}
     */
    public function getElements($template, $page = -1, $maxElement = -1, $sort = 'asc') {
        /**
         * @todo
         */
    }

    protected function getElementInDb($name) {
        $this->modules[$name] = array();
        $element = array();
        
        /**
         * @todo récuperation de l'élément en BDD
         */
        
        $this->modules[$name]['cache_age'] = new \DateTime('now');
        
        return $this->modules[$name];
    }
    
    
}
