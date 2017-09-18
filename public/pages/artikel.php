<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 30/08/2017
 * Time: 14:59
 */

if (isset($_GET["id"])) {
    $art_id = intval($_GET["id"]);

    set_artikel_visning($art_id);
}

$kommm_navn = '';
$komm_email = '';
$komm_tekst = '';

$query = "SELECT DATE_FORMAT(artikel_skrevet, '%e. %b %Y kl. %H:%i') as skrevet_tid,
                DATE_FORMAT(artikel_redigeret, '%e. %b %Y kl. %H:%i') as redigeret_tid,
                artikel_overskrift,
                artikel_manchet,
                artikel_indhold,
                bruger_fornavn,
                bruger_efternavn
                FROM artikler
                INNER JOIN brugere ON artikler.fk_bruger_id = brugere.bruger_id
                WHERE artikel_id = '$art_id'
                LIMIT 1";

$result = $db->query($query);
$row = $result->fetch_object();
if (!$result) {
    query_error($query, __LINE__, __FILE__);
}

if (isset($row->redigeret_tid)) {
    $red_tid = ' (red: ' . $row->redigeret_tid . ')';
} else {
    $red_tid = '';
}

?>

    <h2 class="text-lead"><?php echo $row->artikel_overskrift; ?></h2>
    <p><i><?php echo $row->artikel_manchet; ?></i></p>
    <p><?php echo $row->artikel_indhold; ?></p>
    <br>
    <p class="text-muted">Af <?php echo $row->bruger_fornavn . ' ' . $row->bruger_efternavn; ?>, <?php
        echo $row->skrevet_tid  . $red_tid; ?></p>
<hr>
    <h3>Kommentarer</h3>
    <?php
    $query = "SELECT * FROM kommentarer
                WHERE fk_artikel_id = '$art_id'
                ORDER BY kommentar_oprettet";

    $result = $db->query($query);

    $row_count = $result->num_rows;
    if (!$result) {
        query_error($query, __LINE__, __FILE__);
    }

    if ($row_count > 0) {
        while ($row = $result->fetch_object()) {
            ?>
            <h5># - <a href="mailto:<?php echo $row->kommentar_email; ?>">
                    <?php echo $row->kommentar_brugernavn; ?></a> <?php
                echo $row->kommentar_oprettet; ?></h5>
            <p><?php echo $row->kommentar_tekst; ?></p>
            <br>
            <hr>
<?php
        }
    } else {
        alert('warning', 'Ingen kommentarer til denne artikel');
    }


    if (isset($_POST['submit_kommentar'])) {
        $komm_navn = $db->real_escape_string($_POST['navn']);
        $komm_email = $db->real_escape_string($_POST['email']);
        $komm_tekst = $db->real_escape_string($_POST['tekst']);

        $query = "INSERT INTO kommentarer (kommentar_brugernavn, kommentar_email, kommentar_tekst, fk_artikel_id) 
              VALUES ('$komm_navn', '$komm_email', '$komm_tekst', $art_id)";
        $result = $db->query($query);
        if (!$result) { query_error($query, __LINE__, __FILE__); }

        alert('success', 'Kommentar oprettet');

        redirect_to('index.php?page=artikel&id=' . $art_id);
    }

    ?>

    <div class="container-fluid">
        <form action="" method="post" class="form-horizontal" role="form">
            <div class="form-group">
                <label for="">Dit navn</label>
                <input type="text" class="form-control" value="" name="navn" required>
                <label for="">Din email</label>
                <input type="email" class="form-control" value="" name="email" required>
                <label for="">Kommentar</label>
<!--                TODO max input 300 karakterer -->
                <textarea cols="30" rows="10" class="form-control" name="tekst"></textarea>
            </div>
            <div class="form-group">
                <div class="col-sm-8">
                    <button type="submit" name="submit_kommentar" class="btn btn-primary">Udfør</button>
                </div>
                <div class="col-sm-4">
                    <button type="reset" class="btn btn-warning">Ryd</button>
                </div>
            </div>
        </form>
    </div>
