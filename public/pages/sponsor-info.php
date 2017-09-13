<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 13/09/2017
 * Time: 13:47
 */

?>

<h2><?php echo $side_titel; ?></h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam asperiores at ea enim, esse eum eveniet nobis
    obcaecati pariatur perspiciatis quas quod repudiandae rerum suscipit velit veniam voluptatem!
    Magnam, praesentium.</p>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam asperiores at ea enim,
    esse eum eveniet nobis obcaecati pariatur perspiciatis quas quod repudiandae rerum suscipit velit veniam
    voluptatem! Magnam, praesentium.</p>
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Visninger</th>
            <th>Pris pr/visn.</th>
        </tr>
        </thead>
        <tbody>
        <?php

        $query  = 'SELECT rate_visning, rate_pris FROM rater ORDER BY rate_visning ASC';
        $result = $db->query($query);

        if (!$result) {
            query_error($query, __LINE__, __FILE__);
        }

        while ($row = $result->fetch_object()) {
            ?>
            <tr>
                <td><?php echo number_format($row->rate_visning, 0, ',', '.'); ?></td>
                <td><?php echo number_format($row->rate_pris, 2, ',', '.'); ?></td>
            </tr>
        <?php
        }
        
        ?>
        </tbody>
    </table>
</div>
