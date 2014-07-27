<?php

namespace Validator;

class OneModeValidator implements ValidatorInterface {

    /**
     * Données à valider
     * @var array
     */
    protected $data;

    public function __construct(array $data) {
        $this->data = $data;
    }
    
    /**
     * {@inheritdoc}
     */
    public function validate() {
        return !empty($data['name']);
    }
}
