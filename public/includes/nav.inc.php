<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 29/08/2017
 * Time: 13:09
 */

if (isset($_GET['kategori_id'])) {
    $kat_id = $_GET['kategori_id'];
}


?>

<nav class="navbar navbar-default">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <?php

                    $query = 'SELECT side_url, side_nav_label, fk_kategori_id
                              FROM sider
                              WHERE side_status = 1 AND side_nav_visning = 1
                              ORDER BY side_nav_sortering';
                    $result = $db->query($query);

                    if (!$result) { query_error($query, __LINE__, __FILE__); }

                    while ($row = $result->fetch_object()) {
                        ?>
                        <li <?php if ($row->side_url === $side_url) { echo 'active'; } ?>>
                            <a href="index.php?page=<?php echo $row->side_url; ?>">
                                <?php echo $row->side_nav_label ?></a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
        <!--            SEARCH BAR-->
                <?php

                if (isset($_POST['submit_soeg'])) {

                    $soeg_input = $_POST['soeg'];

                    redirect_to('index.php?page=soegning&query=true&fritekst=' . $soeg_input);
                }
                ?>
                <form method="post" action="" class="navbar-form navbar-right" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control input-sm" placeholder="Søg" name="soeg">
                    </div>
                    <button type="submit" class="btn btn-default btn-sm" name="submit_soeg">
                        <i class="fa fa-search fa-fw"></i>
                    </button>
                </form>
                <a class="navbar-right pull-right" href="admin/login.php"><i class="fa fa-user-secret fa-fw"></i>
                    Admin</a>
            </div><!-- /.navbar-collapse -->
        </nav>