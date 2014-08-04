<?php

namespace Service;

use Validator\OneModeValidator;
use Repository\ThemeRepository;

class OneThemeService extends OneAbstractService {
    
    public function __construct(array $data) {
        $this->data = $data;
        $this->validator = new OneModeValidator($this->data);
        $this->repository = new ThemeRepository();
    }
}
