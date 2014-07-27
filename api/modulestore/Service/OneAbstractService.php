<?php

namespace Service;

abstract class OneAbstractService extends AbstractService {
    
    /**
     * {@inheritdoc}
     */
    public function getInfosInJson() {
        $this->validateData();
        $name = $this->data['name'];
        $module = $this->repository->getElementByName($name);
        
        return json_encode($module);
    }
}
