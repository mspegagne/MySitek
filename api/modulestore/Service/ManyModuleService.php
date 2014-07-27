<?php

namespace Service;

use Validator\ManyModeValidator;
use Repository\ModuleRepository;

class ManyModuleService extends AbstractService {
    
    public function __construct(array $data) {
        $this->data = $data;
        $this->validator = new ManyModeValidator($this->data);
        $this->repository = new ModuleRepository();
    }

    /**
     * {@inheritdoc}
     */
    public function getInfosInJson() {
        $this->validateData();
        $modules = $this->treatData();
        return json_encode($modules);
    }
    
    protected function treatData() {
        
    }
}
