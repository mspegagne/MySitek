<?php

namespace MySitek\Validator;

interface ValidatorInterface
{
    /**
     * @return boolean true si les données sont valides, false sinon
     */
    abstract public function validate();
}
