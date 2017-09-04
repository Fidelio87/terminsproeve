<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 01/09/2017
 * Time: 11:23
 */

if ($_SESSION['bruger']['niveau'] < $sider[$side]['niveau']) {
    redirect_to('index.php');
}

//if (isset($_GET['id'])) {
//    $kommentar_id = $_GET['id'];
//}

?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider['menu']['ikon']; ?>"></i><?php echo $sider['menu']['titel']; ?>
    <small>Rediger menu-visning</small>
</h1>

<?php

$query  = 'SELECT side_id, 
                  side_nav_sortering, 
                  side_nav_label, 
                  side_titel
            FROM sider 
            WHERE fk_kategori_id >= 1 AND side_status = 1 AND side_nav_visning = 1';
$result = $db->query($query);

while ($row = $result->fetch_object()) {

    $id                = $row->side_id;
    $nav_sortering     = $row->side_nav_sortering;
    $side_label        = $row->side_nav_label;
?>

<form action="index.php?page=menu&id=<?php echo $id; ?>" method="post">
    <?php

    if (isset($_POST['menu_rediger'])) {
        if (empty($_POST['sortering']) ||
            empty($_POST['nav_label'])) {
            alert('danger', 'Nogle nødvendige felter er ikke udfyldte!');

        } else {
            $nav_sortering = $db->real_escape_string($_POST['sortering']);
            $side_label      = $db->real_escape_string($_POST['nav_label']);

            $query = "UPDATE sider SET side_nav_sortering = '$nav_sortering', side_nav_label = '$side_label'
            WHERE side_id = " . $id;

            $result = $db->query($query);
            if (!$result) { query_error($query, __LINE__, __FILE__); }


        }
    }
    ?>
    <div class="form-group">
        <label for="sortering" class="control-label">Sortering: </label>
        <input hidden value="<?php echo $id; ?>">
        <input type="number" name="sortering" min="1" maxlength="99" class="form-control" value="<?php
        echo $nav_sortering; ?>" autofocus required>
    </div>

    <div class="form-group">
        <input hidden value="<?php echo $id; ?>">
        <label for="label" class="control-label">Label: </label>
        <input type="text" name="nav_label" class="form-control" value="<?php
        echo $side_label; ?>" required>
    </div>


    <button class="btn btn-success" type="submit" name="menu_rediger">
        <i class="fa fa-floppy-o"></i> Redigér menu</button>
</form>

<?php
}
?>