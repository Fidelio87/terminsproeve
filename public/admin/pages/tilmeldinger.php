<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 15/09/2017
 * Time: 09:19
 */

checkAccess();

if (isset($_GET['slet_id'])) {
    $id = intval($_GET['slet_id']);

    $query = "DELETE FROM tilmeldinger WHERE tilmelding_id = " . $id;
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
            <th>#</th>
            <th>Email</th>
            <th class="icon"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM tilmeldinger";
        $result = $db->query($query);
        if (!$result) { query_error($query, __LINE__, __FILE__); }


        $antal_tilmeldinger = $result->num_rows;
        if ($antal_tilmeldinger > 0) {
            while ($row = $result->fetch_object()) {
                ?>
                <tr>
                    <td><?php echo $row->tilmelding_id; ?></td>
                    <td><?php echo $row->tilmelding_email; ?></td>
                    <td><a href="index.php?page=<?php echo $side; ?>&slet_id=<?php echo $row->tilmelding_id; ?>"
                           class="btn btn-danger btn-xs"
                           onClick="return confirm('Er du sikker på du vil slette tilmeldingen?')"
                           title="Slet tilmelding"><i class="fa fa-trash-o fa-lg fa-fw"></i></a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="12">Der blev ikke fundet nogle tilmeldinger</td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>