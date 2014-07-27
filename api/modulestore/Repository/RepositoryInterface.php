<?php

namespace Repository;

interface RepositoryInterface {

    /**
     * Methode permettant de récupérer un élément à partir de son nom
     * 
     * @param string $name
     */
    public function getElementByName($name);

    /**
     * Methode permettant de récupérer plusieurs éléments avec un tableau de noms
     * 
     * @param string[] $names
     */
    public function getElementByNames(array $names);

    /**
     * Methode permettant de récupérer un élement avec un système de template
     * 
     * @param string $template
     * @param int $page
     * @param int $maxElement
     * @param string $sort
     */
    public function getElements($template, $page, $maxElement, $sort);
}
