<?php


if (!empty($_SESSION['search']['query'])) {
    $fritekst = $_SESSION['search']['query'];
    $forfatter_sql = '';
    $kat_sql = '';
    $tid_sql = '';
    $fritekst_sql = " AND (artikel_overskrift LIKE '%$fritekst%'
                         OR
                         artikel_manchet LIKE '%$fritekst%'
                          OR
                          artikel_indhold LIKE '%$fritekst%')";
}

if (isset($_POST['submit_soeg_adv'])) {
    //slet indhold i søgnings-session
    $_SESSION['search'] = [''];
    //ny værdi kommer efter formen er
    if (!empty($_POST['fritekst'])) {
        $fritekst = $db->real_escape_string($_POST['fritekst']);
        $fritekst_sql = " AND (artikel_overskrift LIKE '%$fritekst%' OR artikel_manchet LIKE '%$fritekst%' OR artikel_indhold LIKE '%$fritekst%')";
    } else {
        $fritekst_sql = '';
    }

    if (!empty($_POST['forfatter'])) {
        $forfatter = implode(' OR fk_bruger_id = ', $_POST['forfatter']);
//        var_dump($forfatter);
        $forfatter_sql = " AND (fk_bruger_id = " . $forfatter . ")";
    } else {
        $forfatter_sql = '';
    }

    if (!empty($_POST['kat'])) {
        $kat = implode(' OR fk_kategori_id = ', $_POST['kat']);
//        var_dump($kat);
        $kat_sql = " AND (fk_kategori_id = " . $kat . ")";
    } else {
        $kat_sql = '';
    }

    if (!empty($_POST['tid_fra']) && !empty($_POST['tid_til'])) {
        $tid_fra = $_POST['tid_fra'];
        $tid_til = $_POST['tid_til'];

        $tid_sql = " AND artikel_skrevet BETWEEN '$tid_fra' AND '$tid_til'";

    } else {
        $tid_sql = '';
    }
}
?>

<div class="row">
    <h2><?php echo $side_titel; ?></h2>
</div>

<!--FORM-->
<div class="row">
    <form action="" method="post" class="form">
        <div class="form-group">
            <label for="fritekst" class="control-label">Fritekst</label>
            <input type="text" class="form-control" placeholder="Fritekst" name="fritekst" value="">
        </div>
<!--        Forfattere-->
        <div class="form-group">
            <label for="forfatter" class="control-label">Forfatter</label>
            <div class="checkbox">
                <?php

                $query_bruger = 'SELECT * FROM brugere WHERE fk_rolle_id = 1 AND bruger_status = 1';
                $result_bruger = $db->query($query_bruger);

                if (!$result_bruger) { query_error($query_bruger, __LINE__, __FILE__); }

                while ($row_bruger = $result_bruger->fetch_object()) {
                    ?>
                    <label class="checkbox-inline">
                        <input name="forfatter[]" value="<?php echo $row_bruger->bruger_id; ?>" type="checkbox"> <?php echo $row_bruger->bruger_fornavn. ' ' . $row_bruger->bruger_efternavn; ?>
                    </label>
                    <?php
                }

                ?>
            </div>
        </div>
<!--        Kategorier-->
        <label for="kat" class="control-label">Kategori</label>
        <div class="checkbox">
            <?php

            $query_kat = 'SELECT * FROM kategorier WHERE kat_aktiv = 1';
            $result_kat = $db->query($query_kat);

            if (!$result_kat) { query_error($query_kat, __LINE__, __FILE__); }

            while ($row_kat = $result_kat->fetch_object()) {
                ?>
                <label class="checkbox-inline">
                    <input name="kat[]" value="<?php echo $row_kat->kat_id; ?>" type="checkbox"> <?php
                    echo $row_kat->kat_navn; ?>
                </label>
                <?php
            }

            ?>
        </div>
<!--        DATEPICKER-->
        <div class="form-group">
            <label for="tid_til" class="control-label">Vælg periode</label>
            <div class="input-daterange input-group" id="date-picker">
                <span class="input-group-addon">fra</span>
                <input type="text" class="input-sm form-control" name="tid_fra" />
                <span class="input-group-addon">til</span>
                <input type="text" class="input-sm form-control" name="tid_til" />
            </div>
        </div>

        <div class="btn-group">
            <button type="submit" name="submit_soeg_adv" class="btn btn-info">
                <i class="fa fa-search fa-fw"></i> Søg</button>
        </div>
    </form>
</div>
<!--FEJLBESKED-->
<!--RESULTATER-->
<div class="row">

<?php

$query_soeg = "SELECT artikel_id,
                      DATE_FORMAT(artikel_skrevet, '%e. %b %Y kl. %H:%i') AS artikel_skrevet_dato,
                      artikel_overskrift,
                      artikel_manchet,
                      SUBSTR(artikel_indhold, 1, 200) as kort_indhold,
                      bruger_fornavn, 
                      bruger_efternavn, 
                      kat_navn
                FROM artikler 
                LEFT JOIN brugere ON artikler.fk_bruger_id = brugere.bruger_id
                LEFT JOIN kategorier ON artikler.fk_kategori_id = kategorier.kat_id
                WHERE
                1=1
                $fritekst_sql
                $forfatter_sql
                $kat_sql
                $tid_sql
                ORDER BY artikel_visninger DESC";
$result_soeg = $db->query($query_soeg);

if (!$result_soeg) { query_error($query_soeg, __LINE__, __FILE__); }

$row_count = $result_soeg->num_rows;

if ($row_count > 0) {
    alert('success', 'Vi fandt <b>' . $row_count . '</b> resultater på din søgning!');
    while ($soeg = $result_soeg->fetch_object()) {
        ?>

            <div class="media">
                <div class="media-body">
                    <h2 class="media-heading"><?php echo $soeg->artikel_overskrift; ?></h2>
                    <h6 class="text-muted"><?php echo $soeg->artikel_skrevet_dato; ?> af:
                        <a href="index.php?page=redaktion"><?php
                            echo $soeg->bruger_fornavn . ' ' . $soeg->bruger_efternavn; ?></a></h6>
                    <h5><i><?php echo $soeg->artikel_manchet; ?></i></h5>
                    <p><?php echo $soeg->kort_indhold; ?>...</p>
                    <div class="well">
                        <a href="index.php?page=artikel&id=<?php echo $soeg->artikel_id; ?>">-> Gå til artikel</a>
                    </div>
                </div>
            </div>
            <hr>

        <?php
    }
} else {
    alert('warning', 'Ingen resultater på din søgning.');
}



?>
</div>

