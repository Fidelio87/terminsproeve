<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 01/09/2017
 * Time: 09:12
 */

checkAccess();

if (isset($_GET['id'])) {
    $artikel_id = $_GET['id'];
} else {
    redirect_to('index.php?page=artikler');
}

if ($_SESSION['bruger']['niveau'] == 200) {
    $bruger_id = $_SESSION['bruger']['id'];
    $fk_bruger_sql = " WHERE bruger_id = '$bruger_id'";

} else {
    $bruger_id = '';
    $fk_bruger_sql = '';

}

$query  = 'SELECT *
                  FROM artikler 
                  WHERE artikel_id = ' . $artikel_id;
$result = $db->query($query);
$row = $result->fetch_object();

?>


<h1 class="page-header">
    <i class="fa fa-<?php echo $sider[$side]['ikon']; ?>"></i> <?php echo $sider['artikler']['titel']; ?>
    <small>Rediger artikel</small>
</h1>

<form action="" method="post">
    <?php
    $overskrift     = $row->artikel_overskrift;
    $manchet        = $row->artikel_manchet;
    $indhold        = $row->artikel_indhold;
    $fk_bruger      = $row->fk_bruger_id;
    $fk_kategori    = $row->fk_kategori_id;

    if (isset($_POST['submit_rediger'])) {
        if (empty($_POST['overskrift']) ||
            empty($_POST['indhold']) ||
            empty($_POST['bruger']) ||
            empty($_POST['kategori'])) {
            alert('danger', 'Nogle nødvendige felter er ikke udfyldte!');

        } else {
            $overskrift     = $db->real_escape_string($_POST['overskrift']);
            $manchet        = $db->real_escape_string($_POST['manchet']);
            $indhold        = $db->real_escape_string($_POST['indhold']);
            $fk_bruger      = $db->real_escape_string($_POST['bruger']);
            $fk_kategori    = $db->real_escape_string($_POST['kategori']);
            
            $query = "UPDATE artikler SET artikel_overskrift = '$overskrift',
                                          artikel_indhold = '$indhold',
                                          fk_bruger_id = $fk_bruger,
                                          fk_kategori_id = $fk_kategori
                                      WHERE artikel_id = " . $artikel_id;

            $result = $db->query($query);
            if (!$result) { query_error($query, __LINE__, __FILE__); }

            alert('success', 'Artikel rettet');

        }
    }
    ?>
    <div class="form-group">
        <label for="bruger" class="control-label">Journalist: </label>
        <select name="bruger" class="form-control" required>
            <option hidden value="">Vælg her...</option>
            <?php
            $query = "SELECT bruger_id,
                              bruger_status,
                              bruger_fornavn,
                              bruger_efternavn,
                              fk_rolle_id
                          FROM brugere
                          $fk_bruger_sql
                          ORDER BY bruger_id";
            $result = $db->query($query);

            if (!$result) { query_error($query, __LINE__, __FILE__); }

            while ($bruger = $result->fetch_object()) {
                ?>
                <option value="<?php echo $bruger->bruger_id ?>"<?php
                if ($bruger->bruger_status == 0 || $bruger->fk_rolle_id != 1) {
                    echo ' disabled'; } ?><?php if ($bruger->bruger_id == $bruger_id ||
                                                    $row->fk_bruger_id == $bruger->bruger_id) { echo ' selected'; } ?>>
                    <?php echo $bruger->bruger_fornavn . ' ' . $bruger->bruger_efternavn; ?></option>
                <?php
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="kategori" class="control-label">Kategori: </label>
        <select name="kategori" class="form-control" required>
            <option hidden value="">Vælg her...</option>
            <?php
            $query = "SELECT * 
                          FROM kategorier
                          ORDER BY kat_navn";
            $result = $db->query($query);

            if (!$result) { query_error($query, __LINE__, __FILE__); }
            while ($kategori = $result->fetch_object()) {
//                    TODO restriktion på bruger
                ?>
                <option value="<?php echo $kategori->kat_id ?>"<?php if ($kategori->kat_aktiv == 0) {
                    echo ' disabled'; } ?><?php if ($kategori->kat_id == $fk_kategori) { echo ' selected'; } ?>>
                    <?php echo $kategori->kat_navn; ?></option>
                <?php
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="overskrift" class="control-label">Overskrift: </label>
        <input type="text" name="overskrift" class="form-control" required value="<?php
        echo $row->artikel_overskrift; ?>">
    </div>

    <div class="form-group">
        <label for="manchet" class="control-label">Manchet <span class="text-muted">Valgfrit</span>:</label>
        <textarea class="form-control" name="manchet"><?php
            echo $row->artikel_manchet; ?></textarea>
    </div>

    <div class="form-group">
        <label for="indhold" class="control-label">Indhold <span class="text-muted">Valgfrit</span>:</label>
        <!--        TODO CK-editor-->
        <textarea class="form-control" name="indhold"><?php
            echo $row->artikel_indhold; ?></textarea>
    </div>

    <button class="btn btn-success" type="submit" name="submit_rediger">
        <i class="fa fa-floppy-o"></i> Redigér artikel</button>
</form>

