<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 29/08/2017
 * Time: 12:52
 */

$kontakt_navn = '';
$kontakt_emne = '';
$kontakt_email = '';
$kontakt_besked = '';


if (isset($_POST['submit'])) {
    $kontakt_navn   = $_POST['navn'];
    $kontakt_email  = $_POST['email'];
    $kontakt_emne   = $_POST['emne'];
    $kontakt_besked = $_POST['besked'];
    
    if (empty($kontakt_navn) || empty($kontakt_email) || empty($kontakt_emne) || empty($kontakt_besked)) {
        alert('danger', 'Fejl! Ikke alle felter er udfyldte');
    } else {
        $modtager = 'red@bbbmag.dk';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

        $headers .= 'From: ' . $kontakt_navn . ' <' . $kontakt_email . '>' . "\r\n";
        // sender mailen vha funktionen mail()
        mail($modtager, $kontakt_emne, $kontakt_besked, $headers);

        alert('success', 'Tak for din henvendelse!');

        $kontakt_navn = '';
        $kontakt_emne = '';
        $kontakt_email = '';
        $kontakt_besked = '';
    }
}

?>

<div class="row">
    <address class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <ul class="list-group">
            <?php
            
            $query  = 'SELECT * FROM adresser LIMIT 1';
            $result = $db->query($query);
            if (!$result) {
                query_error($query, __LINE__, __FILE__);
            }

            while ($row = $result->fetch_object()) {
                ?>
                <li class="list-group-item"><h2><?php echo $row->navn; ?></h2></li>
                <li class="list-group-item"><?php echo $row->gade . " " . $row->husnr; ?></li>
                <li class="list-group-item"><?php echo $row->postnr . " - " . $row->bynavn; ?></li>
                <li class="list-group-item">Tlf. <?php echo $row->tlf; ?> Fax <?php echo $row->fax; ?></li>
                <li class="list-group-item">
                    <a href="mailto:<?php echo $row->email ?>" target="_blank">
                        <?php echo $row->email; ?>
                    </a></li>
                <?php
            }
            ?>
        </ul>
    </address>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <form action="#" method="post" role="form" class="form-horizontal">
            <div class="form-group col-md-8">
                <label for="">Navn</label>
                <input type="text" class="form-control" name="navn" value="<?php echo $kontakt_navn; ?>"
                       placeholder="Navn">
            </div>
            <div class="form-group col-md-8">
                <label for="">Emne</label>
                <input type="text" class="form-control" name="emne" value="<?php echo $kontakt_emne; ?>"
                       placeholder="Emne">
            </div>
            <div class="form-group col-md-8">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo $kontakt_email; ?>"
                       placeholder="@">
            </div>
            <div class="form-group col-md-8">
                <label for="">Besked</label>
                <textarea class="form-control" cols="16" rows="3" name="besked"
                          placeholder="Skriv din besked her."><?php echo $kontakt_besked; ?></textarea>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="submit" value="" class="btn btn-primary">Send besked</button>
                </div>
            </div>
        </form>
    </div>
</div>
