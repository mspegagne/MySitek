<?php

namespace MySitek\Service;

use MySitek\Validator\ValidatorInterface;
use MySitek\Repository\RepositoryInterface;

abstract class AbstractService
{
    /**
     * Données à valider
     * @var array
     */
    protected $data;

    /**
     * Validateur associé
     * @var ValidatorInterface 
     */
    protected $validator;

    /**
     * Repository associé
     * @var RepositoryInterface 
     */
    protected $repository;

    abstract public function __construct(array $data);

    /**
     * @return array
     * 
     * @abstract
     */
    abstract public function getInfos();

    protected function validateData()
    {
        if (!$this->validator->validate()) {
            throw new InvalidException("Les données Json sont invalides");
        }
    }
}
