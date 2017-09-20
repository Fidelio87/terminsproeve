<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 19/09/2017
 * Time: 10:25
 */

if (isset($_GET['fritekst'])) {
    $fritekst = $db->escape_string($_GET['fritekst']);
}


?>

<h2><?php echo $side_titel; ?></h2>




<!--FORM-->
<div class="row">
    <form action="" method="post" class="form">
        <div class="form-group">
            <label for="fritekst" class="control-label">Fritekst</label>
            <input type="text" class="form-control" placeholder="Fritekst" name="fritekst">
        </div>
        <div class="checkbox">
            <?php

            $query_bruger = "SELECT * FROM brugere WHERE fk_rolle_id = 1 AND bruger_status = 1";
            $result_bruger = $db->query($query_bruger);

            while ($row_bruger = $result_bruger->fetch_object()) {
                ?>
                <label class="checkbox-inline">
                    <input name="forfatter[]" value="<?php echo $row_bruger->bruger_id; ?>" type="checkbox"> <?php echo $row_bruger->bruger_fornavn. ' ' . $row_bruger->bruger_efternavn; ?>
                </label>
                <?php
            }

            ?>
        </div>

        <div class="checkbox">
            <?php

            $query_kat = "SELECT * FROM kategorier WHERE kat_aktiv = 1";
            $result_kat = $db->query($query_kat);

            while ($row_kat = $result_kat->fetch_object()) {
                ?>
                <label class="checkbox-inline">
                    <input name="kat[]" value="<?php echo $row_kat->kat_id; ?>" type="checkbox"> <?php echo $row_kat->kat_navn; ?>
                </label>
                <?php
            }

            ?>
        </div>

        <div class="form-group">
            <div class="form-group">
                <label for="" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input type="date" name="tid_fra" class="form-control" id="" placeholder="">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="input-daterange input-group" id="date-picker">
<!--                <span class="input-group-addon">fra</span>-->
                <input type="text" class="input-sm form-control" name="start" />
                <span class="input-group-addon">til</span>
                <input type="text" class="input-sm form-control" name="end" />
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-search fa-fw"></i> Submit</button>
    </form>
</div>
<!--FEJLBESKED-->
<!--RESULTATER-->
<div class="row">

<?php

if (isset($_GET['query']) && $_GET['query'] === 'true') {
    $query_soeg = "SELECT * 
                    FROM artikler 
                    WHERE artikel_overskrift LIKE '%" . $fritekst . "%' OR
                    artikel_manchet LIKE '%" . $fritekst . "%' OR 
                    artikel_indhold LIKE '%" . $fritekst . "%'";
    $result_soeg = $db->query($query_soeg);

    if (!$result_soeg) { query_error($query_soeg, __LINE__, __FILE__); }

    while ($soeg = $result_soeg->fetch_object()) {
        ?>

            <h4><?php echo $soeg->artikel_overskrift; ?></h4>
            <p><?php echo $soeg->artikel_indhold; ?></p>
            <p>Forfatter <b><?php echo $soeg->fk_bruger_id; ?></b></p>

<?php
    }
}

?>
</div>

