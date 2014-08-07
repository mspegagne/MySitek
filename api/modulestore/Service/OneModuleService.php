<?php

namespace Service;

use Validator\OneModeValidator;
use Repository\ModuleRepositoryStub;

class OneModuleService extends OneAbstractService
{
    
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->validator = new OneModeValidator($this->data);
        /**
         * @todo Changer ce comportement (qui est utilisé pour les tests)
         */
        $this->repository = new ModuleRepositoryStub();
    }
}
