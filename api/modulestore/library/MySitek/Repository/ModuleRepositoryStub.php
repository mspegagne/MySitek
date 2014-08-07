<?php

namespace MySitek\Repository;

use MySitek\Entity\ModuleEntityStub;

class ModuleRepositoryStub extends ModuleRepository
{
    public function getElementByName($name)
    {
        return $this->moduleToArray(new ModuleEntityStub());
    }

    public function getElements($template, $page = -1, array $options = null)
    {
        /**
         * @todo Compléter cette méthode
         */
    }

    protected function getElementInDb($name)
    {
        return new ModuleEntityStub();
    }
}
