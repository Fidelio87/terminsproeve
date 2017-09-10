<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 01/09/2017
 * Time: 11:23
 */

checkAccess();

?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider[$side]['ikon']; ?>"></i> <?php echo $sider[$side]['titel']; ?>
</h1>

<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th class="icon"><i class="fa fa-sort-numeric-asc"></i></th>
                <th width="5%" class="icon"></th> <!-- IKON TIL FLYT NED-->
                <th width="5%" class="icon"></th><!-- IKON TIL FLYT OP-->
                <th>Menunavn</th>
            </tr>
        </thead>
        <tbody>
        <?php

        $query  = 'SELECT side_id, side_nav_label, side_nav_sortering 
                    FROM sider 
                  WHERE side_status = 1 AND fk_kategori_id > 0
                  ORDER BY side_nav_sortering';
        $result = $db->query($query);
        if (!$result) {
            query_error($query, __LINE__, __FILE__);
        }

        $antal_sider = $result->num_rows;

        if ($antal_sider > 0) {

            $i = 1;
            
            while ($row = $result->fetch_object()) {
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
<!--                    FLYT NED IKON-->
                    <td>
                        
                        <?php 
                        if ($i != $antal_sider) {
                            ?>
                            <a href="index.php?page=<?php
                            echo $side; ?>&id=<?php echo $row->side_id; ?>&flyt=ned" title="Flyt ned">
                                <i class="fa fa-sort-down fa-lg fa-fw"></i>
                            </a>
                            <?php
                        } 
                        ?>
                    </td>
<!--                    FLYT OP IKON-->
                    <td>
                        <?php
                        if ($i != 1) {
                            ?>
                            <a href="index.php?page=<?php
                            echo $side; ?>&id=<?php echo $row->side_id; ?>&flyt=op" title="Flyt op">
                                <i class="fa fa-sort-up fa-lg fa-fw"></i>
                            </a>
                            <?php
                        }
                        ?>
                    </td>
                    <td><?php echo $row->side_nav_label; ?></td>
                </tr>
                <?php
                $i++;
            }

        } else {
            alert('danger', 'Ingen sider fundet!');
        }

        ?>

        </tbody>
    </table>
</div>
