<?php

namespace Repository;

use Entity\ModuleEntity;

abstract class AbstractRepository
{

    // Cache de 5 minutes
    const MAXCACHETIME = 300;

    /**
     * @var ModuleEntity[]
     */
    protected $elements;
    
    /**
     * Methode permettant de récupérer un élément à partir de son nom
     * 
     * @param string $name
     * 
     * @return array
     * Exemple :
     * {
     *   'description' => string,
     *   ...
     * }
     * 
     * @throws NotFoundException
     */
    public function getElementByName($name)
    {
        if (!key_exists($name, $this->elements)) {
            return $this->getElementInDb($name);
        }
        return $this->getCacheValue($name);
    }

    /**
     * Methode permettant de récupérer plusieurs éléments
     * avec un tableau de noms
     * 
     * @param string[] $names
     * 
     * @return array
     * Exemple : 
     * {
     *   'name1' => {
     *     'description' => string,
     *     ...
     *   },
     *   ...
     * }
     */
    public function getElementByNames(array $names)
    {
        $elements = array();
        foreach ($names as $name) {
            try {
                $elements[$name] = $this->getElementByName($name);
            } catch (NotFoundException $e) {
                $elements[$name] = array();
            }
        }
        return $elements;
    }

    /**
     * Methode permettant de récupérer un ou plusieurs élement(s)
     * avec un système de template
     * 
     * @param string $template
     * @param int $page
     * @param array $options
     * 
     * @abstract
     */
    abstract public function getElements($template, $page, array $options);
    
    /**
     * Methode permettant de récupérer un élément en BDD
     * 
     * @param string $name
     * 
     * @abstract
     */
    abstract protected function getElementInDb($name);
    
    protected function getCacheValue($name)
    {
        $cacheAge = $this->elements[$name]['cache_age'];
        $now = new \DateTime('now');
        $diff = $cacheAge->getTimestamp() - $now->getTimestamp();
        if ($diff > self::MAXCACHETIME) {
            return $this->getElementInDb($name);
        }
        return $this->elements[$name];
    }
}
