<?php

namespace Entity;

class ModuleEntity {
    
    /**
     * A voir pour la BDD : http://www.doctrine-project.org/projects/orm.html
     */
    
    /**
     * Nom du module
     * @var string 
     */
    protected $name;
    
    /**
     * Nom de l'éditeur du module
     * @var string
     */
    protected $editor;
    
    /**
     * Version du module
     * Ex : 1.0.1
     * @var string
     */
    protected $version;
    
    /**
     * @var \DateTime
     */
    protected $creationDate;

    /**
     * @var \DateTime
     */
    protected $lastModificationDate;

    /**
     * Dépendances avec les autres modules et la base
     * @var array
     */
    protected $dependencies;

    /**
     * Courte description du module
     * @var string 
     */
    protected $shortDescription;
    
    /**
     * Description du module
     * @var string 
     */
    protected $description;
    
    /**
     * Nombre d'étoiles
     * @var float
     */
    protected $stars;
    
    /**
     * Nombre d'utilisateurs
     * @var int
     */
    protected $numberOfUsers;

    /**
     * URL du logo
     * @var string
     */
    protected $logo;

    /**
     * URL des images
     * @var array
     */
    protected $images;
    
    /**
     * @var OpinionEntity[]
     */
    protected $opinions;
    
    /**
     * @var array
     */
    protected $otherInformations;
}
