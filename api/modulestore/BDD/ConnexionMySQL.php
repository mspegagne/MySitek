<?php

namespace BDD;

function setMySQLConnexion() {
    /**
     * @link http://php.net//manual/fr/function.parse-ini-file.php
     */
    $config = parse_ini_file('./config.ini', true);

    //$env = getenv('APPLICATION_ENV');
    $env = "production";

    $mysqlConfig = $config[$env];
    unset($config);
    unset($env);
    /**
     * @link http://php.net/manual/fr/book.mysql.php
     */
    $connect = mysql_connect(
            $mysqlConfig['db.mysql.serveur'], $mysqlConfig['db.mysql.utilisateur'], $mysqlConfig['db.mysql.mdp']
    );

    if ($connect == 0) {
        throw new MySQLConnexionException("Connexion au serveur échouée");
    }
    unset($connect);

    $databaseSelect = mysql_select_db($mysqlConfig['db.mysql.base']);
    unset($mysqlConfig);

    if ($databaseSelect == 0) {
        throw new MySQLConnexionException("Connexion à la base de données échouée");
    }
    unset($databaseSelect);
}

// @todo UTILISATION PREFERABLE DE DOCTRINE !