<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 11/09/2017
 * Time: 13:07
 */


checkAccess();

?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider['reklamer']['ikon']; ?>"></i> <?php echo $sider['reklamer']['titel']; ?>
    <small> Opret ny reklame</small>
</h1>

<form method="post" action="" enctype="multipart/form-data">
    <?php
    $navn               = '';
    $fk_kategori_id     = '';

    if (isset($_POST['opret_reklame'])) {

        $navn               = $db->real_escape_string($_POST['navn']);
        $fk_kategori_id     = $db->real_escape_string($_POST['kategori']);
        $fil                = $_FILES['img'];

        if (!empty($navn) || !empty($fk_kategori_id) || !empty($fil)) {

            $filnavn = time() . '_' . $fil['name'];
            $img_dir = '../img/ads/';

            if (is_animated($fil['tmp_name'])) {
                move_uploaded_file($fil['tmp_name'], $img_dir . $filnavn);
            } else {
                $img = $manager->make($fil['tmp_name']);
                //gemmer alm billede
                $img->resize(160, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $img->save($img_dir . $filnavn);
            }

            $query = "INSERT INTO reklamer 
                              (reklame_navn, reklame_img, fk_kategori_id) 
                      VALUES ('$navn', '$filnavn', $fk_kategori_id)";
            $result = $db->query($query);
            if (!$result) { query_error($query, __LINE__, __FILE__); }

            alert('success', 'Reklamen blev uploadet med success');
        } else {
            alert('danger', 'Nogle nødvendige felter er ikke udfyldt!');
        }

//        var_dump(is_animated($fil['tmp_name']));
    }

    ?>

    <div class="form-group">
        <label for="inputName" class="control-label">Navn</label>
        <input name="navn" class="form-control" value="<?php echo $navn; ?>" autofocus required>
    </div>

    <div class="form-group">
        <label for="kategori" class="control-label">Kategori</label>
        <select name="kategori" id="" class="form-control">
            <option hidden value="">Vælg her</option>
            <?php

            $query = "SELECT * FROM kategorier ORDER BY kat_navn";

            $result = $db->query($query);

            while($row = $result->fetch_object()) {
                ?>
                <option <?php if ($row->kat_aktiv == 0) { echo 'disabled'; } ?> value="<?php echo $row->kat_id; ?>"><?php
                    echo $row->kat_navn; ?></option>
            <?php
            }

            ?>

        </select>
    </div>

    <!--    IMAGE-->
    <div class="form-group">
        <label for="img" class="control-label">Upload billede</label>
        <input type="file" name="img" class="form-control" accept="image/*">
    </div>

    <button name="opret_reklame" class="btn btn-primary">
        <i class="fa fa-check-circle fa-fw"></i> Opret reklame</button>
</form>