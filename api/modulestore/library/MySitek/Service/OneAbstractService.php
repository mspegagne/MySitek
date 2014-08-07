<?php

namespace MySitek\Service;

abstract class OneAbstractService extends AbstractService
{
    /**
     * {@inheritdoc}
     */
    public function getInfos()
    {
        $this->validateData();
        $name = $this->data['name'];
        $module = $this->repository->getElementByName($name);

        return $module;
    }
}
