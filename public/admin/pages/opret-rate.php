<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 14/09/2017
 * Time: 10:15
 */

checkAccess();

?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider['rater']['ikon']; ?>"></i> <?php echo $sider['rater']['titel']; ?>
    <small> Opret ny rate</small>
</h1>

<form method="post" action="" enctype="multipart/form-data">
    <?php
    $visninger  = '';
    $pris     = '';

    if (isset($_POST['opret_rate'])) {

        $visninger = $db->real_escape_string($_POST['visninger']);
        $pris      = $db->real_escape_string($_POST['pris']);

        if (!empty($visninger) || !empty($pris)) {

            $query  = "INSERT INTO rater (rate_visning, rate_pris) VALUES ('$visninger', $pris)";
            $result = $db->query($query);
            if (!$result) {
                query_error($query, __LINE__, __FILE__);
            }

            alert('success', 'Raten blev opretet med success');
        } else {
            alert('danger', 'Nogle nødvendige felter er ikke udfyldt!');
        }
    }

    ?>

    <div class="form-group">
        <label for="visninger" class="control-label">Visninger</label>
        <input name="visninger" class="form-control" value="<?php echo $visninger; ?>" autofocus required>
    </div>
    <div class="form-group">
        <label for="pris" class="control-label">Visninger</label>
        <input name="pris" class="form-control" value="<?php echo $pris; ?>" required>
    </div>

    <button name="opret_rate" class="btn btn-primary">
        <i class="fa fa-check-circle fa-fw"></i> Opret rate</button>
</form>