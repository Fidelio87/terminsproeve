<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 31/08/2017
 * Time: 21:02
 */

if ($_SESSION['bruger']['niveau'] < $sider[$side]['niveau']) {
    redirect_to('index.php');
}

if (DEV_STATUS) {
    $lipsum = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus commodi maiores quos recusandae 
    ullam. Accusamus commodi cupiditate delectus dolores eaque et exercitationem explicabo non quasi repellat. 
Accusamus aliquam iure sunt!';
} else {
    $lipsum = '';
}

if ($_SESSION['bruger']['niveau'] == 200) {
    $bruger_id = $_SESSION['bruger']['id'];
    $fk_bruger_sql = " WHERE bruger_id = '$bruger_id'";

} else {
    $bruger_id = '';
    $fk_bruger_sql = '';

}

$overskrift     = '';
$manchet        = '';
$indhold        = '';
$fk_bruger      = '';
$fk_kategori    = '';

if (isset($_POST['submit_artikel'])) {
    $overskrift     = $db->real_escape_string($_POST['overskrift']);
    $manchet        = $db->real_escape_string($_POST['manchet']);
    $indhold        = $db->real_escape_string($_POST['indhold']);
    $fk_bruger      = $db->real_escape_string($_POST['bruger']);
    $fk_kategori    = $db->real_escape_string($_POST['kategori']);
    
    if (empty($_POST['overskrift']) ||
        empty($_POST['indhold']) ||
        empty($_POST['bruger']) ||
        empty($_POST['kategori'])) {
        alert('danger', 'Nogle nødvendige felter er ikke udfyldte!');
    } else {
        $query = "INSERT INTO artikler (artikel_status,
                                    artikel_overskrift, 
                                    artikel_manchet, 
                                    artikel_indhold, 
                                    fk_bruger_id, 
                                    fk_kategori_id) 
                            VALUES (0, '$overskrift', '$manchet', '$indhold', $fk_bruger, $fk_kategori)";

        $result = $db->query($query);
        if (!$result) { query_error($query, __LINE__, __FILE__); }

        alert('success', 'Artikel oprettet - husk at sætte artikel som "aktiv" i oversigten');
    }
} //.slut-submit

?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider['artikler']['ikon']; ?>"></i> <?php echo $sider['artikler']['titel']; ?>
    <small> Opret ny artikel</small>
</h1>

<form action="" method="post">

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
                        echo ' disabled'; } ?>>
                        <?php echo $bruger->bruger_fornavn . ' ' . $bruger->bruger_efternavn; ?></option>
                    <?php
                }
                    ?>
        </select>
    </div>
<!--    KATEGORI-->
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
                        echo ' disabled'; } ?>>
                        <?php echo $kategori->kat_navn; ?></option>
                    <?php
                }
                    ?>
        </select>
    </div>

    <div class="form-group">
        <label for="overskrift" class="control-label">Overskrift: </label>
        <input type="text" name="overskrift" class="form-control" required value="">
    </div>

    <div class="form-group">
        <label for="manchet" class="control-label">Manchet <span class="text-muted">Valgfrit</span>:</label>
        <textarea class="form-control" name="manchet"></textarea>
    </div>

    <div class="form-group">
        <label for="indhold" class="control-label">Indhold <span class="text-muted">Valgfrit</span>:</label>
<!--        TODO CK-editor-->
        <textarea class="form-control" name="indhold"><?php echo $lipsum; ?></textarea>
    </div>

    <button class="btn btn-success" type="submit" name="submit_artikel">
        <i class="fa fa-floppy-o"></i> Opret artikel</button>
</form>