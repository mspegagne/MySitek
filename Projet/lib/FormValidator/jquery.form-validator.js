

var myLanguage = {
    errorTitle: 'Erreur d\'envoi !',
    requiredFields: 'Le champs doit être rempli',
    badTime: 'L\'heure n\'est pas correcte',
    badEmail: 'L\'adresse email n\'est pas correcte',
    badTelephone: 'Le numéro de téléphone n\'est pas correct',
    badSecurityAnswer: 'Vous avez donné une mauvaise réponse à la question de securité',
    badDate: 'La date n\'est pas correcte',
    lengthBadStart: 'La valeur doit se située entre ',
    lengthBadEnd: ' caractères',
    lengthTooLongStart: 'La valeur est plus longue que',
    lengthTooShortStart: 'La valeur est plus courte que ',
    notConfirmed: 'La valeur n\'est pas identique',
    badDomain: 'Nom de domaine incorect',
    badUrl: 'The input value is not a correct URL',
    badCustomVal: 'The input value is incorrect',
    badInt: 'Le nombre n\'est pas correct',
    badSecurityNumber: 'Your social security number was incorrect',
    badUKVatAnswer: 'Incorrect UK VAT Number',
    badStrength: 'Votre mot de passe n\'est pas assez complexe',
    badNumberOfSelectedOptionsStart: 'Vous devez choisir au moins ',
    badNumberOfSelectedOptionsEnd: ' réponses',
    badAlphaNumeric: 'La valeur ne peut contenir uniquement des caractères alphanumériques',
    badAlphaNumericExtra: ' et ',
    wrongFileSize: 'Le fichier sélectionné est trop lourd',
    wrongFileType: 'Le fichier sélectionné n\'est pas autorisé',
    groupCheckedRangeStart: 'Merci de choisir entre ',
    groupCheckedTooFewStart: 'Merci de choisir au moins ',
    groupCheckedTooManyStart: 'Merci de choisir au maximum ',
    groupCheckedEnd: ' item(s)',
    badCreditCard: 'Le numéro de carte de crédit n\'est pas correct',
    badCVV: 'The CVV number was not correct'
};

function valiSend(form)
{
    $.validate({
        language: myLanguage,
        form: '#' + form,
        modules: 'security'
    });

    // Lorsque je soumets le formulaire
    $('#' + form).on('submit', function(e) {

        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire

        var $this = $(this); // L'objet jQuery du formulaire

        if ($("input.error")[0]) {

            Notif('<p>Le formulaire est invalide</p>', 5000);

        } else {
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: $this.attr('action'), // Le nom du fichier indiqué dans le formulaire
                type: $this.attr('method'), // La méthode indiquée dans le formulaire (get ou post)
                data: $this.serialize(), // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
                dataType: 'json', // JSON
                beforeSend: function() {
                    $('#load' + form).show();
                    $('#icon' + form).hide();
                },
                success: function(json) { // Je récupère la réponse du fichier PHP
                    $('#load' + form).hide();
                    $('#icon' + form).show();
                    Notif(json.response, 5000); // J'affiche cette réponse
                }
            });
        }
    });
}