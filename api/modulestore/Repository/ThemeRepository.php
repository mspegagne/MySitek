<?php

namespace Repository;

class ThemeRepository extends AbstractRepository {

    /**
     * {@inheritdoc}
     */
    public function getElements($template, $page, $maxElement, $sort) {
        /**
         * @todo
         */
    }
    
    protected function getElementInDb($name) {
        $this->elements[$name] = array();
        
        /**
         * @todo récuperation de l'élément en BDD
         */
        
        $this->elements[$name]['cache_age'] = new \DateTime('now');
        
        return $this->elements[$name];
    }
}
