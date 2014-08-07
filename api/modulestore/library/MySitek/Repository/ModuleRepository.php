<?php

namespace MySitek\Repository;

use MySitek\Entity\ModuleEntity;

class ModuleRepository extends AbstractRepository
{
    const DATEFORMAT = 'Y-m-d H:i:s';

    /**
     * {@inheritdoc}
     */
    public function getElements($template, $page = -1, array $options = null)
    {
        /**
         * @todo Compléter cette méthode
         */
    }

    protected function getElementInDb($name)
    {
        $this->elements[$name] = array();

        /**
         * @todo récuperation de l'élément en BDD
         */

        $this->elements[$name]['cache_age'] = new \DateTime('now');

        return $this->elements[$name];
    }

    protected function moduleToArray(ModuleEntity $module)
    {
        return array(
            "name" => $module->getName(),
            "editor" => $module->getEditor(),
            "version" => $module->getVersion(),
            "creation_date" =>
                $module->getCreationDate()->format(self::DATEFORMAT),
            "last_modification_date" => 
                $module->getLastModificationDate()->format(self::DATEFORMAT),
            "dependencies" => $module->getDependencies(),
            "shortDescription" => $module->getShortDescription(),
            "description" => $module->getDescription(),
            "stars" => $module->getStars(),
            "number_of_users" => $module->getNumberOfUsers(),
            "logo" => $module->getLogo(),
            "images" => $module->getImages(),
            "opinions" => $module->getOpinions(),
            "otherInformations" => $module->getOtherInformations()
        );
    }
}
