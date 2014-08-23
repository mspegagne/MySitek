<?php

/**
 * @brief Classe de gestion des parametres
 *
 */
class Param {

    private $ref;
    private $value;

    /**
     * @brief Constructeur à partir de la ref
     * @param String $ref reference du param en bdd
     * @return Param avec la valeur
     */
    public function __construct($ref, $app) {

        $sql = "SELECT * FROM param WHERE ref = '" . $ref . "'";
        $retour = $app['db']->fetchAssoc($sql);

        if ($retour == '') {

            $this->ref = $ref;
            $this->value = '';
        } else {

            $this->ref = $ref;
            $this->value = $retour['value'];
        }
    }

    /**
     * @brief Retourne la ref du param en cours
     * @return $this->ref
     */
    private function getRef() {

        return $this->ref;
    }

    /**
     * @brief Retourne la valeur du param en cours
     * @return $this->value
     */
    private function getValue() {

        return $this->value;
    }

    /**
     * @brief Met à jour la ref
     * @param String $value
     */
    public function setRef($value) {

        $this->ref = $value;
    }

    /**
     * @brief Met à jour la valeur du param
     * @param String $value
     */
    public function setValue($value) {

        $this->value = $value;
    }

    /**
     * @brief Sauvegarde les valeurs aux refs donnees
     * @param Array $array $ref => $val
     * @param App $app
     * @return String $response confirmation envoi
     */
    public static function saveParams($array, $app) {

        $sql = "UPDATE param SET value = ? WHERE ref = ?";

        $response = 'Erreur lors de l\'enregistrement...';

        foreach ($array as $ref => $value) {
            if ($app['db']->executeUpdate($sql, array($value, $ref))) {
                
                $response = 'Les données ont bien été enregistrées';
            }
        }
        return $response;
    }

    /**
     * @brief Sauvegarde la valeur à la ref donnee
     * @param String $ref
     * @param String value
     * @param App $app
     * @return String $response confirmation envoi
     */
    public static function saveParam($ref, $value, $app) {

        $sql = "SELECT * FROM param WHERE ref = '" . $ref . "'";
        $retour = $app['db']->fetchAssoc($sql);

        $response = FALSE;

        if ($retour == '') {

            $sql = "INSERT INTO param (ref, value) VALUES (?,?)";
            if ($app['db']->executeUpdate($sql, array($ref, $value))) {
                $response = TRUE;
            }
        } else {

            $sql = "UPDATE param SET value = ? WHERE ref = ?";
            if ($app['db']->executeUpdate($sql, array($value, $ref))) {
                $response = TRUE;
            }
        }

        return $response;
    }

    /**
     * @brief Supprime un param à partir de la ref donnee
     * @param String $ref
     * @param App $app
     * @return String $response confirmation suppression
     */
    public static function deleteParam($ref, $app) {

        $sql = "SELECT * FROM param WHERE ref = '" . $ref . "'";
        $retour = $app['db']->fetchAssoc($sql);

        $response = FALSE;

        if ($retour == '') {

            $response = TRUE;
        } else {

            $sql = "DELETE FROM param WHERE ref = ?";
            if ($app['db']->executeUpdate($sql, array($ref))) {
                $response = TRUE;
            }
        }

        return $response;
    }

    /**
     * @brief Sauvegarde le nouveau mail temporairement et envoie mail confirm
     * @param String $mail
     * @param App $app
     * @return String $response confirmation envoi
     */
    public static function saveMail($mail, $app) {

        $response = FALSE;

        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {


            $token = uniqid(rand());
            $url = $app['url'] . 'admin/parametres/compte/verif/' . $token;
            $saveMail = Param::saveParam('mail_temp', $mail, $app);
            $saveToken = Param::saveParam('mail_token', $token, $app);

            if ($saveMail && $saveToken) {

                if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) { // On filtre les serveurs qui présentent des bogues.
                    $passage_ligne = "\r\n";
                } else {
                    $passage_ligne = "\n";
                }
                //=====Déclaration des messages au format texte et au format HTML.
                $message_txt = "Merci de bien vouloir aller à l'adresse web ci-dessous pour confirmer votre adresse mail. Ce lien vous redirige vers votre site internet. Merci d'ignorer ce mail s'il ne vous est pas destiné. " . $url;
                $message_html = '<html><head></head><body>Merci de bien vouloir cliquer sur le lien ci-dessous pour confirmer votre adresse mail. Ce lien vous redirige vers votre site internet. <br>Merci d\'ignorer ce mail s\'il ne vous est pas destiné. <br><a href="' . $url . '">' . $url . '</a></body></html>';

                //==========
                //=====Création de la boundary.
                $boundary = "-----=" . md5(rand());
                $boundary_alt = "-----=" . md5(rand());

                //==========
                //=====Définition du sujet.
                $sujet = "Validation de l'addresse mail";

                //=========
                //=====Création du header de l'e-mail.
                $header = "From: \"MySitek\"<contact@mysitek.com>" . $passage_ligne;
                $header.= "Reply-to: \"MySitek\" <contact@mysitek.com>" . $passage_ligne;
                $header.= "MIME-Version: 1.0" . $passage_ligne;
                $header.= "Content-Type: multipart/mixed;" . $passage_ligne . " boundary=\"$boundary\"" . $passage_ligne;

                //==========
                //=====Création du message.
                $message = $passage_ligne . "--" . $boundary . $passage_ligne;
                $message.= "Content-Type: multipart/alternative;" . $passage_ligne . " boundary=\"$boundary_alt\"" . $passage_ligne;
                $message.= $passage_ligne . "--" . $boundary_alt . $passage_ligne;
                //=====Ajout du message au format texte.
                $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"" . $passage_ligne;
                $message.= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
                $message.= $passage_ligne . $message_txt . $passage_ligne;
                //==========
                $message.= $passage_ligne . "--" . $boundary_alt . $passage_ligne;
                //=====Ajout du message au format HTML.
                $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $passage_ligne;
                $message.= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
                $message.= $passage_ligne . $message_html . $passage_ligne;

                //==========
                //=====On ferme la boundary alternative.
                $message.= $passage_ligne . "--" . $boundary_alt . "--" . $passage_ligne;
                //==========
                $message.= $passage_ligne . "--" . $boundary . $passage_ligne;

                if (mail($mail, $sujet, $message, $header)) {
                    $response = TRUE;
                }
            }
        }
        return $response;
    }

    /**
     * @brief Valide le mail en attente à partid du token
     * @param String $token
     * @param App $app
     * @return String $response confirmation
     */
    public static function validMail($token, $app) {

        $response = 'Erreur...';

        $userToken = $app['security']->getToken();
        $user = $userToken->getUser();
        $username = $user->getUsername();

        if ($token == $app['mail_token']) {

            if (Param::saveParam('user_mail', $app['mail_temp'], $app)) {

                $sql = "UPDATE users SET username = ? WHERE username = ?";

                if ($app['db']->executeUpdate($sql, array($app['mail_temp'], $username))) {

                    if ((Param::deleteParam('mail_temp', $app)) && (Param::deleteParam('mail_token', $app))) {

                        $user = array(
                            "user_name" => $app['user_name'],
                            "user_firstName" => $app['user_firstName'],
                            "user_mail" => $app['mail_temp']
                        );

                        User::maj($user);

                        $response = 'Le mail est désormais valide et vous servira d\'identifiant de connexion';
                    }
                }
            }
        }
        return $response;
    }

    /**
     * @brief Sauvegarde le nouveau password après verif
     * @param String $old_pwd
     * @param String $new_pwd
     * @param String $new_pwd2
     * @param App $app
     * @return String $response confirmation envoi
     */
    public static function savePwd($old_pwd, $new_pwd, $new_pwd2, $app) {

        $response = 'Erreur...';

        $token = $app['security']->getToken();
        $user = $token->getUser();
        $username = $user->getUsername();
        $old_pwd_bdd = $user->getPassword();

        $crypt_old = (new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder())->encodePassword($old_pwd, '');

        if ($crypt_old == $old_pwd_bdd) {

            if ($new_pwd == $new_pwd2) {

                $crypt = (new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder())->encodePassword($new_pwd, '');

                $sql = "UPDATE users SET password = ? WHERE username = ?";
                if ($app['db']->executeUpdate($sql, array($crypt, $username))) {
                    $response = 'Le mot de passe a bien été enregistré';
                } else {
                    $response = 'Erreur lors de l\'enregistrement...';
                }
            } else {
                $response = 'Les mots de passes ne sont pas identiques';
            }
        } else {
            $response = 'L\'ancien mot de passe ne correspond pas...';
        }
        return $response;
    }

    /**
     * @brief Charge tous les params dans l'application
     */
    public static function load($app) {

        $sql = "SELECT * FROM param";
        $retour = $app['db']->fetchAll($sql);

        foreach ($retour as $param) {
            $ref = $param['ref'];
            $value = $param['value'];
            $app[$ref] = $value;
        }
    }

}
