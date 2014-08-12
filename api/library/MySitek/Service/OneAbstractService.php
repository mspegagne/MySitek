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
        return $this->repository->getElementByName($this->data['name']);
    }
}
