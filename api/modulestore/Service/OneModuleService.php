<?php

namespace Service;

use Validator\OneModeValidator;

class OneModuleService extends AbstractService {
    
    public function __construct(array $data) {
        parent::__construct($data);
        
        $this->validator = new OneModeValidator($this->data);
    }
    
    public function getInfos() {
        parent::getInfos();
        // Utilisation du ModuleRepository (qui va communiquer avec la BDD)
        // return json_encode($value);
    }
}
