<?php

namespace MySitek\Entity;

class ModuleEntity
{

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

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEditor($editor)
    {
        $this->editor = $editor;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function setCreationDate(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function setLastModificationDate(\DateTime $lastModificationDate)
    {
        $this->lastModificationDate = $lastModificationDate;
    }

    public function setDependencies($dependencies)
    {
        $this->dependencies = $dependencies;
    }

    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setStars($stars)
    {
        $this->stars = $stars;
    }

    public function setNumberOfUsers($numberOfUsers)
    {
        $this->numberOfUsers = $numberOfUsers;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    public function setImages($images)
    {
        $this->images = $images;
    }

    public function setOpinions(OpinionEntity $opinions)
    {
        $this->opinions = $opinions;
    }

    public function setOtherInformations(array $otherInformations)
    {
        $this->otherInformations = $otherInformations;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEditor()
    {
        return $this->editor;
    }

    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @return \DateTime
     */
    public function getLastModificationDate()
    {
        return $this->lastModificationDate;
    }

    public function getDependencies()
    {
        return $this->dependencies;
    }

    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStars()
    {
        return $this->stars;
    }

    public function getNumberOfUsers()
    {
        return $this->numberOfUsers;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function getOpinions()
    {
        return $this->opinions;
    }

    public function getOtherInformations()
    {
        return $this->otherInformations;
    }
}
