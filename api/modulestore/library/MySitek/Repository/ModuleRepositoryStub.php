<?php

namespace MySitek\Repository;

use MySitek\Entity\ModuleEntityStub;

class ModuleRepositoryStub extends AbstractRepository
{
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
