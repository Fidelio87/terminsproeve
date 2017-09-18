<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 16/09/2017
 * Time: 23:13
 */


checkAccess();

$query  = 'SELECT * FROM adresser';
$result = $db->query($query);
$row    = $result->fetch_object();
if (!$result) {
    query_error($query, __LINE__, __FILE__);
}

$navn   = '';
$gade   = '';
$husnr  = '';
$postnr = '';
$by     = '';
$tlf    = '';
$fax    = '';
$email  = '';



?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider[$side]['ikon']; ?>"></i> <?php echo $sider[$side]['titel']; ?>
</h1>

<form action="" method="post">
    <?php

    $navn   = $row->navn;
    $gade   = $row->gade;
    $husnr  = $row->husnr;
    $postnr = $row->postnr;
    $by     = $row->bynavn;
    $tlf    = $row->tlf;
    $fax    = $row->fax;
    $email  = $row->email;

    if (isset($_POST['submit_info'])) {
//        TODO add more reqs
        if (empty($_POST['navn']) || empty($_POST['gade']) || empty($_POST['by'])) {
            alert('danger', 'nogle nødvendige felter er ikke udfyldte');
        } else {
            $navn   = $db->real_escape_string($_POST['navn']);
            $gade   = $db->real_escape_string($_POST['gade']);
            $husnr  = $db->real_escape_string($_POST['husnr']);
            $postnr = $db->real_escape_string($_POST['postnr']);
            $by     = $db->real_escape_string($_POST['by']);
            $tlf    = $db->real_escape_string($_POST['tlf']);
            $fax    = $db->real_escape_string($_POST['fax']);
            $email  = $db->real_escape_string($_POST['email']);

            $query = "UPDATE adresser 
                        SET navn    = '$navn', 
                            gade    = '$gade',
                            husnr   = '$husnr',
                            postnr  = $postnr,
                            bynavn  = '$by',
                            tlf     = $tlf,
                            fax     = $fax,
                            email   = '$email'";
            $result = $db->query($query);
            if (!$result) { query_error($query, __LINE__, __FILE__); }

            alert('success', 'Info er blevet opdateret');
        }
    }

    ?>
    <div class="form-group">
        <label for="navn" class="control-label">Navn</label>
        <input type="text" class="form-control" name="navn" value="<?php echo $navn; ?>" autofocus required>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="gade" class="control-label">Gade</label>
                <input type="text" class="form-control" name="gade" value="<?php echo $gade; ?>" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="husnr" class="control-label">Husnr</label>
                <input type="text" class="form-control" name="husnr" value="<?php echo $husnr; ?>">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="postnr" class="control-label">Postnummer</label>
                <input type="number" min="0000" max="9999" class="form-control" name="postnr" value="<?php echo $postnr; ?>">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="by" class="control-label">Bynavn</label>
        <input type="text" class="form-control" name="by" value="<?php echo $by; ?>" required>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label for="tlf" class="control-label">Telefonnummer</label>
            <input type="number" min="00000000" max="99999999" class="form-control" name="tlf" value="<?php echo $tlf; ?>">
        </div>
        <div class="col-md-4">
            <label for="postnr" class="control-label">Fax</label>
            <input type="number" min="00000000" max="99999999" class="form-control" name="fax" value="<?php echo $fax; ?>">
        </div>
        <div class="col-md-4">
            <label for="postnr" class="control-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
        </div>
    </div>
    <div class="col-sm-12 form-group">
        <button class="btn btn-primary" name="submit_info" type="submit">
            <i class="fa fa-floppy-o fa-fw"></i> Gem ændringer</button>
    </div>
</form>


