<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 11/09/2017
 * Time: 11:51
 */

checkAccess();

if (isset($_GET['slet_id'])) {
    $id = intval($_GET['slet_id']);
    $query = 'SELECT * FROM reklamer WHERE reklame_id = ' . $id;
    $result = $db->query($query);
    $row = $result->fetch_object();
    if ( ! $result) {
        query_error($query, __LINE__, __FILE__);
    }
    if (isset($row->reklame_img)) {
        unlink('../img/ads/' . $row->reklame_img);
    }

    $query_del = "DELETE FROM reklamer WHERE reklame_id = $id";
    $result_del = $db->query($query_del);

    if (!$result_del) {
        query_error($query_del, __LINE__, __FILE__);
    } else {
        redirect_to('index.php?page=reklamer');
    }
}

?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider[$side]['ikon']; ?>"></i> <?php echo $sider[$side]['titel']; ?>
    <small>Oversigt over reklamer</small>
</h1>

<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Navn</th>
            <th>Billede</th>
            <th>Kategori</th>
            <th class="icon"></th>
            <th class="icon"><a href="index.php?page=opret-reklame"
                                        class="btn btn-success"><i class="fa fa-plus-square fa-lg fa-fw"></i></a></th>
        </tr>
        </thead>
        <tbody>
        <?php

        $query  = 'SELECT reklame_id, reklame_navn, reklame_img, kat_navn
                    FROM reklamer 
                    INNER JOIN kategorier ON reklamer.fk_kategori_id = kategorier.kat_id
                    ORDER BY fk_kategori_id';
        $result = $db->query($query);

        if ( ! $result) {
            query_error($query, __LINE__, __FILE__);
        }

        $antal_reklamer = $result->num_rows;

        if ($antal_reklamer > 0) {
            while ($row = $result->fetch_object()) {
                ?>
            <tr>
                <td><?php echo $row->reklame_navn; ?></td>
                <td><img src="../img/ads/<?php echo $row->reklame_img; ?>" alt="" width="100"></td>
                <td><?php echo $row->kat_navn; ?></td>
                <td><a href="index.php?page=<?php echo $side; ?>&id=<?php
                    echo $row->reklame_id; ?>" title="Redigér reklame"><i class="fa fa-edit fa-lg fa-fw"></i></a></td>
                <td><a href="index.php?page=<?php echo $side; ?>&slet_id=<?php
                    echo $row->reklame_id; ?>" onclick="return confirm('Er du sikker på at du vil slette reklamen')"
                       title="Slet reklame"><i class="fa fa-trash-o fa-lg fa-fw"></i></a></td>
            </tr>
        <?php
            }
        } else {
            alert('danger', 'ingen reklamer at vise!');
        }

        ?>
        </tbody>
    </table>
</div>
