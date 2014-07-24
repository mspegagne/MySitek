<?php

namespace Validator;

interface ValidatorInterface {
    
    /**
     * @return boolean true si les données sont bonnes, false sinon
     */
    public function validate();
}
