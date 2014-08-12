<?php

namespace MySitek\Repository;

class ThemeRepository extends AbstractRepository
{

    /**
     * {@inheritdoc}
     */
    public function getElements($template, $page = -1, array $options = null)
    {
        /**
         * @todo Compléter cette méthode
         */
    }

    protected function getElementInDb($name)
    {
        $this->elements[$name] = array();

        /**
         * @todo récuperation de l'élément en BDD
         */

        $this->elements[$name]['cache_age'] = new \DateTime('now');

        return $this->elements[$name];
    }
}
