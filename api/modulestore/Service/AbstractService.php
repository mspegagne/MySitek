<?php

namespace Service;

use Validator\ValidatorInterface;

abstract class AbstractService {
    
    /**
     * Données à valider
     * 
     * @var array
     */
    protected $data;
    
    /**
     * Validateur associé
     * 
     * @var ValidatorInterface 
     */
    protected $validator;

    public function __construct(array $data) {
        $this->data = $data;
    }
    
    protected function validateData() {
        if(!$this->validator->validate()) {
            throw new InvalidException("Les données Json sont invalides");
        }
    }
    
    public function getInfos() {
        $this->validateData();
    }
}
