<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 14/09/2017
 * Time: 10:07
 */

checkAccess();

// Kode til sletning af kommentarer

if (isset($_GET['slet_id'])) {
    $id = intval($_GET['slet_id']);

    $query = "DELETE FROM rater WHERE rate_id = " . $id;
    $db->query($query);

    redirect_to('index.php?page='.$side);
}

?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider[$side]['ikon']; ?>"></i> <?php echo $sider[$side]['titel']; ?>
</h1>

<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Visninger</th>
            <th>Pris</th>
            <th class="icon"></th>
            <th class="icon"><a href="index.php?page=opret-rate"
                                class="btn btn-success btn-xs"
                                title="Opret ny rate"><i class="fa fa-plus-square fa-lg fa-fw"></i></a></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM rater";
        $result = $db->query($query);
        if (!$result) { query_error($query, __LINE__, __FILE__); }


        $antal_rater = $result->num_rows;
        if ($antal_rater > 0) {
            while ($row = $result->fetch_object()) {
                ?>
                <tr>
                    <td><?php echo $row->rate_visning; ?></td>
                    <td><?php echo $row->rate_pris; ?></td>

                    <td><a href="index.php?page=rediger-rate&id=<?php echo $row->rate_id; ?>"
                           class="btn btn-warning btn-xs" title="Redigér rate">
                            <i class="fa fa-edit fa-lg fa-fw"></i></a></td>
                    <td><a href="index.php?page=<?php echo $side; ?>&slet_id=<?php echo $row->rate_id; ?>"
                           class="btn btn-danger btn-xs"
                           onClick="return confirm('Er du sikker på du vil slette raten?')"
                           title="Slet rate"><i class="fa fa-trash-o fa-lg fa-fw"></i></a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="12">Der blev ikke fundet nogle rater</td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>