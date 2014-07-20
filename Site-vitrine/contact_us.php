<!DOCTYPE html>
<html lang="fr">

    <?php include_once "./share/head.php"; ?>

    <body id="page-top" data-spy="scroll" data-target=".navbar-custom">

        <?php
        $preciseLink = true;
        include_once "./share/nav.php";
        ?>

        <section id="contact-us" class="contact-us content-section">
            <div class="container">
                <div class="col-lg-offset-2 col-lg-8">
                    <div class="clearfix"></div>
                    <h2>Nous contacter</h2>
                    
                    <?php
                    if (!empty($succeed)) {
                        switch ($succeed) {
                            case 1:
                                echo '<div class="alert alert-success"><strong><span class="glyphicon glyphicon-send"></span>  Votre message à bien été envoyé.</strong></div>';
                                break;
                            case 2:
                                echo '<div class="alert alert-danger"><strong><span class="glyphicon glyphicon-remove"></span>  Erreur! Mauvaise valeur pour le test.</strong></div>';
                                break;
                            default :
                                break;
                        }
                    }
                    ?>

                    <form role="form" action="contact_us_post.php" method="post" >
                        <div class="well well-sm"><strong><i class="glyphicon glyphicon-ok form-control-feedback"></i> Champs requis</strong></div>
                        <div class="form-group">
                            <label for="InputName">Votre nom</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="InputName" id="InputName" placeholder="Entrez votre nom" required>
                                <span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="InputEmail">Votre email</label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="InputEmail" name="InputEmail" placeholder="Entrez votre email" required  >
                                <span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="InputMessage">Votre message</label>
                            <div class="input-group">
                                <textarea name="InputMessage" id="InputMessage" class="form-control" rows="5" required></textarea>
                                <span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="InputReal">Combien font 4+3 ?</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="InputReal" id="InputReal" required>
                                <span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
                            </div>
                        </div>
                        <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info center-block">
                    </form>
                </div>
            </div>
        </section>

        <?php
        include_once "./share/footer.php";
        include_once "./share/scripts.php";
        ?>

    </body>
</html>

