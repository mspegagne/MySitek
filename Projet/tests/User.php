<?php

namespace Model;

/**
 * @brief Classe de gestion du compte user associé au site
 * A completer au fur et à mesure
 * TODO #USER : une entrée en API qui enregistre un nouveau user (lors de l'installation de mysitek setup-mysitek.php)
 * $newId = uniqid(rand());
 */ 
class User {

    private $user_name;
    private $user_firstName;
    private $user_mail;    
    private $user_list; 
    private $user_id;    
    private $user_url;

    /**
    * @brief Constructeur à partir de l'app
    * @param App $app 
    * @return User 
    */  
    public function __construct($app) {

        $this->user_name = $app['user_name'];
        $this->user_firstName = $app['user_firstName'];
        $this->user_id = $app['user_id'];        
        $this->user_mail = $app['user_mail'];
        $this->user_list = $app['modules'];        
        $this->user_url = $app['url'];
    }
    
    /**
    * @brief Enregistre dans nos base l'user
    * @param Array $user
    * @return Rien du tout pour éviter bug en cas de pb
    */
    public function maj($user) {
        
        //TODO #USER : maj dans nos base de name firstname et mail uniquement.       
        
    }
    
    /**
    * @brief Verfication anti-piratage, comparaison avec nos bdd 
    * @param App $app
    * @return Boolean TRUE si ok
    */
    public static function checkList($app) {
        
        $user_id = $app['user_id'];        
        $user_list = $app['modules'];   
        
        //TODO #USER : envoyer $user_list et $user_id pour comparaison.
        $confirmation = TRUE; //ou false en fonction du retour de l'api
        return $confirmation;
    }

 
}
