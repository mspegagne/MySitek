<?php

namespace Service;

use Validator\OneModeValidator;
use Repository\ModuleRepository;

class OneModuleService extends OneAbstractService {
    
    public function __construct(array $data) {
        $this->data = $data;
        $this->validator = new OneModeValidator($this->data);
        $this->repository = new ModuleRepository();
    }
}
