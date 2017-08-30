<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 28/08/2017
 * Time: 10:52
 */

require '../config/config.php';

if (isset($_GET['logout'])) {
    logout();
    redirect_to('index.php');
}



?>

<!DOCTYPE html>
<html lang="da">
<?php require_once 'includes/head.inc.php'; ?>
<body>
    <div class="container">
        <?php include 'includes/header.inc.php'; ?>

        <?php include 'includes/nav.inc.php'; ?>

        <!--    BREADCRUMBS-->
<!--        TODO skal ikke vises på forsiden-->
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Library</a></li>
                <li class="active">Data</li>
            </ol>
        </div>

        <!--    CONTENT-->
        <div class="row">
        <!--    SENESTE/ARKIV-->
            <aside class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <div class="row">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Mest læste</h3>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item"><a href="#">LINK</a></li>
                            <li class="list-group-item"><a href="#">LINK</a></li>
                            <li class="list-group-item"><a href="#">LINK</a></li>
                        </ul>
                    </div>
                </div>

                <hr>
                <!--NYHEDSBREV-->
                <div class="row">
                    <form method="post" action="#">
                        <div class="form-group">
                            <div class="input-group">
                                <label for="newsletter">Nyhedsbrev</label>
                                <input type="email" class="form-control" placeholder="email">
                            </div>
                        </div>
                        <button type="submit" name="sub_news" class="btn btn-primary">
                            <i class="fa fa-send-o fa-fw"></i> Tilmeld/afmeld
                        </button>
                        <!--                            TODO alert here-->
                    </form>
                </div>

                <hr>

                <div class="row">
                    <div class="panel panel-info">
                        <div class="panel-heading">Arkivet</div>
                        <ul class="list-group">
                            <li class="list-group-item"><a href="#">LINK</a></li>
                            <li class="list-group-item"><a href="#">LINK</a></li>
                            <li class="list-group-item"><a href="#">LINK</a></li>
                        </ul>
                    </div>
                </div>
            </aside>

            <!--        DYNAMIC CONTENT-->

            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <div class="container-fluid">
                    <div class="media">
                        <div class="media-right pull-right">
                            <a href="#">
    <!--                            TODO husk link til artikelsortering-->
                                <img class="media-object" src="img/car_cat.png" alt="se alle artikler vedr.">
                            </a>
                        </div>
                        <div class="media-body">
                            <h2 class="media-heading">Artikel titel</h2>
                            <h6 class="text-muted">Fredag d. klamskldm 2002.20 af <a href="#">Forfatter</a></h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad blanditiis consectetur culpa
                                dicta dolorem dolorum earum fuga illum impedit labore necessitatibus, nesciunt nisi
                                perferendis reiciendis saepe ullam veritatis voluptatibus voluptatum.</p>
                            <a class="alert-link" href="#">&dbkarow; Læs mere...</a>
                        </div>
                    </div>

                    <hr>

                    <div class="media">
                        <div class="media-left pull-right">
                            <a href="#">
                                <img class="media-object" src="https://placehold.it/64x64" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <h2 class="media-heading">Artikel titel</h2>
                            <h6 class="text-muted">Fredag d. klamskldm 2002.20</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad blanditiis consectetur culpa
                                dicta dolorem dolorum earum fuga illum impedit labore necessitatibus, nesciunt nisi
                                perferendis reiciendis saepe ullam veritatis voluptatibus voluptatum.</p>
                            <a class="alert-link" href="#"> Læs mere...</a>
                        </div>
                    </div>

                    <hr>

                </div>
            </div>
            <!--        SPONS-->
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <h4>Sponsorer</h4>
                <img src="http://lorempixel.com/120/80/" class="thumbnail" alt="lorem">
                <img src="http://lorempixel.com/120/80/" class="thumbnail" alt="lorem">
                <img src="http://lorempixel.com/120/80/" class="thumbnail" alt="lorem">
                <img src="http://lorempixel.com/120/80/" class="thumbnail" alt="lorem">
                <hr>
                <a href="#" class="alert-link"><i class="fa fa-question-circle fa-fw"></i> Din annonce her?</a>
            <!--            PLACEHOLDERS-->
            </div>
        </div>
<!--        TODO DEBUG INFO FJERN VED LANCERING-->
        <div class="row bg-warning">
            <div class="container-fluid">
                <?php show_dev_info(); ?>
            </div>
        </div>

        <?php include 'includes/footer.inc.php'; ?>
    </div> <!--..Main container-->
    <?php include 'includes/scripts.inc.php'; ?>
</body>
</html>
<?php ob_end_flush(); ?>
