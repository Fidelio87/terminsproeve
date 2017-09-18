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

if (isset($_GET['page'])) {
    $side_url = $db->real_escape_string($_GET['page']);
} else {
    $side_url = '';
}

$query  = "SELECT side_url, side_titel, side_indhold, kat_navn, side_include_filnavn
            FROM sider
            LEFT JOIN kategorier ON sider.fk_kategori_id = kategorier.kat_id
            LEFT JOIN side_includes ON sider.fk_side_include_id = side_includes.side_include_id
            WHERE side_url = '$side_url' AND side_status = 1";
$result = $db->query($query);
$side    = $result->fetch_object();

if (!$result) {
    query_error($query, __LINE__, __FILE__);
}

$side_titel = isset($side) ? $side->side_titel : 'HTTP 404';

?>

<!DOCTYPE html>
<html lang="da">
<?php require_once 'includes/head.inc.php'; ?>
<body>
    <div class="container">
        <?php include 'includes/header.inc.php'; ?>

        <?php include 'includes/nav.inc.php'; ?>

        <!--    BREADCRUMBS-->

        <?php
        //breadcrumb vises ikke på forsiden
        if (isset($_GET['page']) && $_GET['page'] != '') {
            ?>
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Library</a></li>
                <li class="active">Data</li>
            </ol>
        </div>
    <?php
        }
        ?>

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
                            <?php

                            $query = "SELECT artikel_id, 
                                              artikel_status, 
                                              artikel_overskrift,
                                              SUBSTR(artikel_overskrift, 1, 25) as kort_overskrift, 
                                              artikel_visninger
                                      FROM artikler
                                      WHERE artikel_status = 1
                                      ORDER BY artikel_visninger DESC
                                      LIMIT 5";
                            $result = $db->query($query);
                            if (!$result) { query_error($query, __LINE__, __FILE__); }

                            while ($row = $result->fetch_object()) {
                                ?>
                                <li class="list-group-item small">
                                    <a href="index.php?page=artikel&id=<?php echo $row->artikel_id; ?>" title="<?php echo $row->artikel_overskrift; ?>"><?php
                                        echo $row->kort_overskrift; ?>...</a>
                                </li>
                            <?php
                            }
                            ?>

                        </ul>
                    </div>
                </div>

                <hr>
                <!--NYHEDSBREV-->

                <?php

                if (isset($_POST['sub_news']) && !empty($_POST['nyhedsbrev_email'])) {
                    echo '<div class="row">';
                    behandl_nyhedsbrev($_POST['nyhedsbrev_email']);
                    echo '</div>';
                }

                ?>
                <div class="row">
                    <form method="post">
                        <div class="form-group">
                            <div class="input-group">
                                <label for="newsletter">Nyhedsbrev</label>
                                <input type="email" name="nyhedsbrev_email" class="form-control" placeholder="email">
                            </div>
                        </div>
                        <button type="submit" name="sub_news" class="btn btn-primary">
                            <i class="fa fa-send-o fa-fw"></i> Tilmeld/afmeld
                        </button>
                    </form>
                </div>

                <hr>

                <div class="row">
                    <div class="panel panel-info">
                        <div class="panel-heading">Arkivet</div>
                        <ul class="list-group">
                            <?php

                            $query = 'SELECT artikel_id,
                                              artikel_status,
                                              artikel_overskrift,
                                              SUBSTR(artikel_overskrift, 1, 25) as kort_overskrift,
                                              artikel_visninger
                                      FROM artikler
                                      WHERE artikel_status = 1
                                      ORDER BY artikel_oprettet DESC
                                      LIMIT 5';
                            $result = $db->query($query);
                            if (!$result) {
                                query_error($query, __LINE__, __FILE__);
                            }

                            while ($row = $result->fetch_object()) {
                                ?>
                                <li class="list-group-item small">
                                    <a href="index.php?page=artikel&id=<?php echo $row->artikel_id; ?>" title="<?php
                                    echo $row->artikel_overskrift; ?>"><?php
                                        echo $row->kort_overskrift; ?>...</a>
                                </li>
                                <?php
                            }
                            ?>

                        </ul>
                    </div>
                </div>
            </aside>

            <!--        DYNAMIC CONTENT-->

            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <div class="container-fluid">
                    <?php
                    if (isset($side->side_include_filnavn)&&
                        file_exists('pages/' . $side->side_include_filnavn)) {
                        include 'pages/' . $side->side_include_filnavn;
                    } else {
//                        TODO redirect 4040
                        echo 'Try again!';
                    }
                    ?>
                </div>
            </div>
            <!--        SPONS-->
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <h4>Sponsorer</h4>
                <?php

                if (isset($kat_id)) {
                    $reklame_sql = "WHERE fk_kategori_id = " . $kat_id;
                } else {
                    $reklame_sql = "ORDER BY rand() LIMIT 5";
                }

                $query = "SELECT reklame_navn, reklame_img FROM reklamer $reklame_sql";
                $result = $db->query($query);
                if (!$result) { query_error($query, __LINE__, __FILE__); }

                while ($row = $result->fetch_object()) {
                    ?>
                    <a href="#" class="thumbnail"><img src="img/ads/<?php
                        echo $row->reklame_img; ?>" class="thumbnail" alt="<?php
                        echo $row->reklame_navn; ?>"></a>
                <?php
                }
                ?>
                <hr>
                <a href="index.php?page=sponsor-info" class="alert-link">
                    <i class="fa fa-question-circle fa-fw"></i> Din annonce her?</a>
            <!--            PLACEHOLDERS-->
            </div>
        </div>
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
