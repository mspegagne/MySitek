<?php

namespace Service;

use Validator\OneModeValidator;
use Repository\ModuleRepository;

class OneModuleService extends AbstractService {
    
    public function __construct(array $data) {
        $this->data = $data;
        $this->validator = new OneModeValidator($this->data);
        $this->repository = new ModuleRepository();
    }
    
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
