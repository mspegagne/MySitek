<?php

namespace Service;

abstract class ManyAbstractService extends AbstractService{

    /**
     * {@inheritdoc}
     */
    public function getInfosInJson() {
        $this->validateData();
        $modules = $this->treatData();
        return json_encode($modules);
    }
    
    /**
     * Methode permettant de récupérer les informations demandées selon le type de requêtes
     * 
     * @return Elements[]
     */
    protected function treatData() {
        if(!empty($this->data['names'])) {
            return $this->repository->getElementByNames($this->data['names']);
        }
        return $this->repository->getElements(
            $this->data['template'],
            $this->data['page'],
            $this->data['max-elmt'],
            $this->data['sort']
        );
    }
}
