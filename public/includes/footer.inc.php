<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 29/08/2017
 * Time: 12:23
 */

$query  = 'SELECT * FROM adresser LIMIT 1';
$result = $db->query($query);
$row    = $result->fetch_object();
if (!$result) {
    query_error($query, __LINE__, __FILE__);
}

?>

<footer class="container bg-primary">
    <address class="col-lg-12 text-center">
        <h4 class="lead"><?php echo $row->navn; ?></h4>
        <h5><?php   echo $row->gade; ?> <?php
                    echo $row->husnr; ?>, <?php
                    echo $row->postnr; ?> <?php
                    echo $row->bynavn; ?> - TEL: +45 <?php
                    echo $row->tlf; ?> - Fax: <?php
                    echo $row->fax; ?> - Email: <span><a href="mailto: <?php
                    echo $row->email; ?>"><?php
                    echo $row->email; ?></a></span></h5>
    </address>
</footer>
