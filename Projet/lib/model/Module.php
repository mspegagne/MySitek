<?php

/**
 * @brief Classe de gestion des modules
 * A completer au fur et à mesure
 */
class Module {

    private $name;
    private $lien;
    private $icon;
    private $front;
    private $versiondispo;
    private $prix;

    //A modifier et à compléter, c'est juste pour avoir une idée.

    /**
     * @brief Constructeur à partir du lien
     * @param String $file identifiant du module = $lien
     * @return User 
     */
    public function __construct($file) {

        //TODO #MODULE : construire le module avec l'API
    }

    /**
     * @brief converti le type en son numero corrsepondant en bdd
     * @param String $type
     * @return numero
     */
    public static function convertType($type) {

        switch ($type) {
            case 'admin':
                return 0;
            case 'front':
                return 1;
            case 'back':
                return 2;
            case 'param':
                return 3;
            case 'param_plus':
                return 4;
            default :
                return 1;
        }
    }

    /**
     * @brief Recupération de la liste des modules de type $type sélectionnés sur l'app
     * @param App $app
     * @param String $type
     * @return $app['modules_' . $type . '']
     */
    public static function getList($app, $type) {
       
        $num = Module::convertType($type);
        
        $sql = "SELECT * FROM modules WHERE selected = 1 AND front = ? ORDER BY rang ASC";
        $app['modules_' . $type . ''] = $app['db']->fetchAll($sql, array($num));
    }
    
    /**
     * @brief Recupération de la liste des modules installés sur l'app
     * @param App $app
     * @return $app['modules']
     */
    public static function getAll($app) {

        $sql = "SELECT * FROM modules WHERE front != -1 ORDER BY rang ASC";
        $app['modules'] = $app['db']->fetchAll($sql);
    }
    
    /**
     * @brief Analyse le résultat du tableau ordonné et enregistre le nvl ordre
     * @param String $result = Tableau serialize
     * @param String $type 
     * @param App $app
     * @return String $response 
     */
    public static function rang($result, $type, $app) {

        $table = Module::convertType($type);
    
        $result = '&' . $result;
        $explode = explode('&table-'.$table.'[]=', $result);
        $i = 0;

        $response = '';

        foreach ($explode as $value) {
            $i++;
            $sql = "UPDATE modules SET rang = " . $i . " WHERE lien = ? AND front = ".$table."";
            if (!$app['db']->executeUpdate($sql, array($value))) {
                $response = 'Erreur...';
            }
        }
        
        return $response;
    }

}
