<?php

namespace Validator;

class ManyModeValidator implements ValidatorInterface {
    
    /**
     * Données à valider
     * @var array
     */
    protected $data;
    
    public function __construct(array $data) {
        $this->data = $data;
    }
    
    public function validate() {
        
    }
}
