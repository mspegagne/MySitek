<?php

include_once '../index.php';

$apiService = new \MySitek\Service\ApiService('api.mysitek.com');

/**
 * @todo Charger les données à partir de l'api
 */
$carrousselData[0]['title'] = 'Titre 1';
$carrousselData[0]['description'] = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi, labore, magni illum nemo ipsum quod voluptates ab natus nulla possimus incidunt aut neque quaerat mollitia perspiciatis assumenda asperiores consequatur soluta.';
$carrousselData[0]['image'] = 'data/responsive.jpg';
$carrousselData[1]['title'] = 'Titre 2';
$carrousselData[1]['description'] = 'Description 2';
$carrousselData[1]['image'] = 'data/responsive.jpg';
$carrousselData[2]['title'] = 'Titre 3';
$carrousselData[2]['description'] = 'Description 3';
$carrousselData[2]['image'] = 'data/responsive.jpg';

$pageData[0]['title'] = '2048';
$pageData[0]['description'] = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi, labore, magni illum nemo ipsum quod voluptates ab natus nulla possimus incidunt aut neque quaerat mollitia perspiciatis assumenda asperiores consequatur soluta.';
$pageData[0]['image'] = 'data/2048.png';
$pageData[0]['price'] = 'free';
$pageData[1]['title'] = 'Test Module 1';
$pageData[1]['description'] = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi, labore, magni illum nemo ipsum quod voluptates ab natus nulla possimus incidunt aut neque quaerat mollitia perspiciatis assumenda asperiores consequatur soluta.';
$pageData[1]['image'] = 'data/2048.png';
$pageData[1]['price'] = '16000€';
$pageData[2]['title'] = 'Test Module 2';
$pageData[2]['description'] = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi, labore, magni illum nemo ipsum quod voluptates ab natus nulla possimus incidunt aut neque quaerat mollitia perspiciatis assumenda asperiores consequatur soluta.';
$pageData[2]['image'] = 'data/responsive.jpg';
$pageData[2]['price'] = '800€';


$apiModule = $apiService->getOneModule('Module Stub');

$pageData[3]['title'] = $apiModule['name'];
$pageData[3]['description'] = $apiModule['description'];
$pageData[3]['image'] = reset($apiModule['images']);
$pageData[3]['price'] = $apiModule['price'] . '€';

?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Bienvenue sur le Store de MySitek. Cette ici que vous pourrez vous procurer de nouveaux modules et de nouveaux thèmes.">
        <meta name="author" content="Mathieu SPEGAGNE et Bruno MATRY">

        <title>MySitek Store</title>

        <link rel="icon" type="image/png" href="img/favicon.png"/>
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

        <link href="css/module.css" rel="stylesheet">
    </head>


    <body>
        <div class="container">
            <div id="custom_carousel" class="carousel slide" data-ride="carousel" data-interval="2500"> 
                <div class="carousel-inner">
                    <?php foreach ($carrousselData as $key => $data): ?>
                        <div class="item <?php if ($key == 0): ?>active<?php endif; ?>">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3"><img src="<?php echo $data['image']; ?>" class="img-responsive"></div>
                                    <div class="col-md-9">
                                        <h3><?php echo $data['title']; ?></h3>
                                        <p><?php echo $data['description']; ?></p>
                                    </div>
                                </div>
                            </div>            
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="container">
            <div id="store" class="row" >
                <?php foreach ($pageData as $data): ?>
                    <div class="col-sm-3 module">
                        <div class="col-item">
                            <div class="photo">
                                <img src="<?php echo $data['image']; ?>" class="img-responsive" alt="" />
                            </div>
                            <div class="info">
                                <div class="row">
                                    <div class="price col-md-6">
                                        <h5><?php echo $data['title']; ?></h5>
                                        <h5 class="price-text-color"><?php echo $data['price']; ?></h5>
                                    </div>
                                    <div class="rating hidden-sm col-md-6">
                                        <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                        </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                        </i><i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <h6><?php echo $data['description']; ?></h6>                
                                <div class="separator clear-left">
                                    <p id="2048" class="btn-add" style="cursor: pointer;">
                                        <i class="fa fa-download"></i>
                                        <i id="wait2048" class="fa fa-spinner fa-spin" style="display: none;"></i>
                                        Install
                                    </p>
                                    <p class="btn-details">
                                        <i class="fa fa-list"></i><a href="" >Acheter</a>
                                    </p>
                                </div>
                                <div class="clearfix">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.min.js"></script>
        <script src="js/module.js"></script>
        <script type="text/javascript">


            $("#2048").click(function() {

                $.ajax({
                    type: "POST",
                    url: '/admin/install',
                    data: {type: "modules", file: "2048"},
                    beforeSend: function() {
                        $('#wait2048').show();
                    },
                    success: function() {
                        $('#wait2048').hide();
                    },
                    error: function(request, error) { // Info Debuggage si erreur         
                        alert("Erreur :" + request.responseText);
                    }

                })
                        .done(function(msg) {
                            if (msg === '') {
                                Notif('<p>2048 est maintenant installé</p>', 5000);

                            }
                            else {
                                Notif('<p>Erreur lors de l\\\'installation...</p>', 5000);

                            }
                        });
                return false;

            });
        </script>
    </body>
</html>