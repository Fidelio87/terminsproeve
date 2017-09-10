<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 08/09/2017
 * Time: 11:12
 */

checkAccess();

if (isset($_POST['kategori_submit'])) {
    redirect_to('index.php?page=ansvar&id=' . $_POST['kategori']);
}

if (isset($_GET['id']) && intval($_GET['id'])) {
    $kat_id = $_GET['id'];
}

if (isset($_POST['ikke_red']) && is_array($_POST['ikke_red'])) {
    foreach ($_POST['ikke_red'] as $red) {
        $red = intval($red);
        $query = 'INSERT INTO ansvar VALUES (' . $red . ', ' . $kat_id . ')';
        $db->query($query) or die($db->errno);
    }
    if ($db->affected_rows > 0) {
        alert('success', 'Redaktør(er) tilføjet');
    } else {
        alert('danger', 'Ups, noget gik galt');
    }
}

if (isset($_POST['er_red']) && is_array($_POST['er_red'])) {
    foreach ($_POST['er_red'] as $red) {
        $red = intval($red);
        $query = "DELETE FROM ansvar WHERE fk_bruger_id = $red AND fk_kategori_id = $kat_id";
        $db->query($query) or die($db->errno);
    }
    if ($db->affected_rows > 0) {
        alert('success', 'Redaktør(er) fjernet');
    } else {
        alert('danger', 'Ups, noget gik galt');
    }
}

?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider[$side]['ikon']; ?>"></i> <?php echo $sider[$side]['titel']; ?>
</h1>

<div class="row">
    <form action="" method="post" class="form">
        <div class="form-group">
            <label for="" class="control-label">Vælg kategori</label>
            <select name="kategori" class="form-control">
                <option hidden value="">Vælg her</option>
                <?php

                $query  = 'SELECT kat_id, kat_navn, kat_aktiv FROM kategorier ORDER BY kat_navn';
                $result = $db->query($query);

                while ($kat = $result->fetch_object()) {
                    ?>
                    <option <?php if ($kat->kat_aktiv == 0) { echo 'disabled'; }
                    if (isset($kat_id) && $kat->kat_id == $kat_id) { echo 'selected'; }
                                    ?> value="<?php
                    echo $kat->kat_id; ?>"><?php echo $kat->kat_navn; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <button type="submit" name="kategori_submit" class="btn btn-primary">Vælg kategori</button>
    </form>
</div>
<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6">
        <form action="" method="post">
            <div class="form-group">
                <label for="" class="control-label">Tilføj redaktører</label>
                <select class="form-control" name="ikke_red[]" multiple>
                    <?php
                    $query = "SELECT bruger_id, bruger_fornavn, bruger_efternavn 
                          FROM brugere 
                          WHERE bruger_id NOT IN (
                                                  SELECT fk_bruger_id 
                                                  FROM ansvar 
                                                  WHERE fk_kategori_id = $kat_id) AND fk_rolle_id = 1";
                    $result = $db->query($query);
                    while ($row = $result->fetch_object()) {
                        ?>
                        <option value="<?php echo $row->bruger_id; ?>"><?php
                            echo $row->bruger_fornavn . ' ' . $row->bruger_efternavn; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="er_red" class="btn btn-primary">Tilføj</button>
        </form>
    </div>
    <div class="col-sm-12 col-md-6">
        <form action="" method="post">
            <div class="form-group">
                <label for="" class="control-label">Fjern redaktører</label>
                <select class="form-control" name="er_red[]" multiple>
                    <?php
                    $query = "SELECT bruger_id, bruger_fornavn, bruger_efternavn 
                          FROM brugere
                          INNER JOIN ansvar ON brugere.bruger_id = ansvar.fk_bruger_id
                          WHERE fk_kategori_id = $kat_id AND fk_rolle_id = 1";
                    $result = $db->query($query);
                    while ($row = $result->fetch_object()) {
                        ?>
                        <option value="<?php echo $row->bruger_id; ?>"><?php
                            echo $row->bruger_fornavn . ' ' . $row->bruger_efternavn; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="ikke_red" class="btn btn-warning">Fjern</button>
        </form>
    </div>
</div>
