<?php

namespace Front;

use Front\Helper\OneModeHelper;

abstract class Receiver {

    /**
     * Methode permettant de receptionner un element Json et de le rediriger
     * vers les methodes de traitement adapté
     * 
     * @param string $jsonElement
     * 
     * @throws ReceptionError
     * 
     * @see \JsonSerializable
     */
    public static function receive($jsonElement) {

        $receivedArray = json_decode($jsonElement, true);

        $mode = $receivedArray['mode'];

        if (empty($mode)) {
            throw new ReceptionException("Mode non trouvé dans l'élément Json");
        }

        switch ($mode) {
            case "one":
                OneModeHelper::translate($receivedArray);
                break;
            case "many":
                break;
            default :
                throw new ReceptionException("Mode inconnu pour l'élément Json");
        }
    }

}
