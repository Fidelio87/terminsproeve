<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 01/09/2017
 * Time: 09:12
 */

if ($_SESSION['bruger']['niveau'] < $sider[$side]['niveau']) {
    redirect_to('index.php');
}

if (isset($_GET['id'])) {
    $kommentar_id = $_GET['id'];
}

$query  = 'SELECT * FROM kommentarer WHERE kommentar_id = ' . $kommentar_id;
$result = $db->query($query);
$row = $result->fetch_object();

$brugernavn     = '';
$email        = '';
$tekst        = '';

?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider['kommentarer']['ikon']; ?>"></i><?php echo $sider['kommentarer']['titel']; ?>
    <small>Rediger kommentar</small>
</h1>

<form action="" method="post">
    <?php
    $brugernavn     = $row->kommentar_brugernavn;
    $email        = $row->kommentar_email;
    $tekst        = $row->kommentar_tekst;

    if (isset($_POST['submit_rediger'])) {
        if (empty($_POST['brugernavn']) ||
            empty($_POST['email']) ||
            empty($_POST['tekst'])) {
            alert('danger', 'Nogle nødvendige felter er ikke udfyldte!');

        } else {
            $brugernavn = $db->real_escape_string($_POST['brugernavn']);
            $email      = $db->real_escape_string($_POST['email']);
            $tekst      = $db->real_escape_string($_POST['tekst']);
            
            $query = "UPDATE kommentarer SET kommentar_brugernavn = '$brugernavn',
                                              kommentar_email = '$email',
                                              kommentar_tekst = '$tekst'
                                      WHERE kommentar_id = " . $kommentar_id;

            $result = $db->query($query);
            if (!$result) { query_error($query, __LINE__, __FILE__); }

            alert('success', 'Kommentar rettet');

        }
    }
    ?>
    <div class="form-group">
        <label for="brugernavn" class="control-label">Brugernavn: </label>
        <input type="text" name="brugernavn" class="form-control" value="<?php
        echo $brugernavn; ?>" autofocus required>
    </div>

    <div class="form-group">
        <label for="email" class="control-label">Email: </label>
        <input type="email" name="email" class="form-control" value="<?php
        echo $email; ?>" autofocus required>
    </div>

    <div class="form-group">
        <label for="tekst" class="control-label">Kommentar: </label>
        <!--        TODO CK-editor-->
        <textarea class="form-control" name="tekst" required><?php
            echo $tekst; ?></textarea>
    </div>

    <button class="btn btn-success" type="submit" name="submit_rediger">
        <i class="fa fa-floppy-o"></i> Redigér kommentar</button>
</form>

