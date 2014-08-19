<?php

/**
 * @brief Function usuelles
 */

/**
 * @brief Renvoie l'array des fichiers dispo dans le dossier
 * @param String $dir_nom
 * @return Array of String $fichier 
 */
function getDossier($dir_nom) {

    $dir = opendir($dir_nom) or die('Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
    $fichier = array(); // on déclare le tableau contenant le nom des fichiers
    $dossier = array(); // on déclare le tableau contenant le nom des dossiers

    while ($element = readdir($dir)) {
        if ($element != '.' && $element != '..') {
            if (!ereg("^\.", $element)) { // supprime les fichiers cachés
                if (!is_dir($dir_nom . '/' . $element)) {
                    $fichier[] = $element;
                } else {
                    $dossier[] = $element;
                }
            }
        }
    }

    closedir($dir);

    if (!empty($fichier)) {
        sort($fichier); // pour le tri croissant, rsort() pour le tri décroissant
    }

    return $fichier;
}
