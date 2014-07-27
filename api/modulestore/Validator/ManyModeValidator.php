<?php

namespace Validator;

class ManyModeValidator implements ValidatorInterface {
    
    /**
     * Données à valider
     * @var array
     */
    protected $data;

    private $validValuesForTemplateOption = array(
        'popular',
        'alphabetical',
        'most-valued',
        'most-downloaded'
    );
    
    private $validValuesForSortOption = array(
        'asc',
        'desc'
    );


    public function __construct(array $data) {
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function validate() {
        if (empty($data['names'])) {
            return $this->alternativeValidation();
        }
        return is_array($data['names']);
    }

    /**
     * Methode permettant de valider une requete complexe
     * 
     * @return boolean
     */
    protected function alternativeValidation() {
        return $this->isNotEmptyAlternativeValidation()
            && $this->isRightTypeAlternativeValidation()
            && $this->areDataValidAlternativeValidation();
    }

    /**
     * Methode permettant de valider l'instanciation pour une requête complexe
     * 
     * @return boolean
     */
    private function isNotEmptyAlternativeValidation() {
        $isNotEmpty = !empty($data['template']);
        $isNotEmpty &=!empty($data['sort']);
        $isNotEmpty &=!empty($data['max-elmt']);
        $isNotEmpty &=!empty($data['page']);
        return $isNotEmpty;
    }

    /**
     * Methode permettant de valider le typage pour une requête complexe
     * 
     * @return boolean
     */
    private function isRightTypeAlternativeValidation() {
        $isRightType = is_int($data['max-elmt']);
        $isRightType &= is_int($data['page']);
        return $isRightType;
    }

    /**
     * Methode permettant de valider le format des données pour une requête complexe
     * 
     * @return boolean
     */
    private function areDataValidAlternativeValidation() {
        $areDataValid = in_array(
            $data['template'],
            $this->validValuesForTemplateOption,
            true
        );
        
        $areDataValid &= in_array(
            $data['sort'],
            $this->validValuesForSortOption,
            true
        );
        
        $areDataValid &= ($data['max-elmt'] > 0 || $data['max-elmt'] === -1);
        $areDataValid &= ($data['page'] > 0 || $data['page'] === -1);
        
        return $areDataValid;
    }
}
