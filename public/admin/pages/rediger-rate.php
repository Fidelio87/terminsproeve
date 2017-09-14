<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 14/09/2017
 * Time: 10:50
 */
checkAccess();

if (isset($_GET['id'])) {
    $rate_id = $_GET['id'];
}

$query  = 'SELECT * FROM rater WHERE rate_id = ' . $rate_id;
$result = $db->query($query);
$row = $result->fetch_object();

$visninger   = '';
$pris        = '';


?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider['rater']['ikon']; ?>"></i><?php echo $sider['rater']['titel']; ?>
    <small>Rediger rate</small>
</h1>

<form action="" method="post">
    <?php
    $visninger  = $row->rate_visning;
    $pris       = $row->rate_pris;

    if (isset($_POST['rediger_rate'])) {
        if (empty($_POST['visning']) ||
            empty($_POST['pris'])) {
            alert('danger', 'Nogle nødvendige felter er ikke udfyldte!');

        } else {
            $visninger = $db->real_escape_string($_POST['visning']);
            $pris      = $db->real_escape_string($_POST['pris']);

            $query = "UPDATE rater SET rate_visning = $visninger, rate_pris = $pris WHERE rate_id = " . $rate_id;

            $result = $db->query($query);
            if (!$result) { query_error($query, __LINE__, __FILE__); }

            alert('success', 'Rate rettet');

        }
    }
    ?>
    <div class="form-group">
        <label for="visning" class="control-label">Visninger: </label>
        <input type="number" name="visning" class="form-control" value="<?php echo $visninger; ?>" autofocus>
    </div>

    <div class="form-group">
        <label for="pris" class="control-label">Pris: </label>
        <input type="number" step="0.01" min="0" name="pris" class="form-control" value="<?php echo $pris; ?>">
    </div>

    <button class="btn btn-success" type="submit" name="rediger_rate">
        <i class="fa fa-floppy-o"></i> Redigér rate</button>
</form>
