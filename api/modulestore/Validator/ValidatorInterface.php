<?php

namespace Validator;

interface ValidatorInterface {
    
    /**
     * @return boolean true si les données sont valides, false sinon
     */
    public function validate();
}
