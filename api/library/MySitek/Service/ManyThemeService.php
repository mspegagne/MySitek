<?php

namespace MySitek\Service;

use MySitek\Validator\ManyModeValidator;
use MySitek\Repository\ThemeRepository;

class ManyThemeService extends ManyAbstractService
{
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->validator = new ManyModeValidator($this->data);
        $this->repository = new ThemeRepository();
    }
}
