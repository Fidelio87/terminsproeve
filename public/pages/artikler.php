<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 30/08/2017
 * Time: 17:57
 */

// checker om der er angivet en kategori-id
if (isset($_GET['kategori'])) {
    $kat_id = $_GET['kategori'];
} else {
    $kat_id = 1;
}

$query = "SELECT artikel_id,
                        artikel_skrevet,
                        artikel_overskrift,
                        artikel_manchet,
                        SUBSTR(artikel_indhold, 1, 200) as kort_indhold,
                        bruger_fornavn,
                        bruger_efternavn
                FROM artikler
                INNER JOIN brugere ON artikler.fk_bruger_id = brugere.bruger_id
                WHERE artikel_status = 1 AND fk_kategori_id = '$kat_id'
                ORDER BY artikel_skrevet";

$result = $db->query($query);

if (!$result) {
    query_error($query, __LINE__, __FILE__);
}

while ($row = $result->fetch_object()) {
    ?>
    <div class="media">
        <div class="media-body">
            <h2 class="media-heading"><?php echo $row->artikel_overskrift; ?></h2>
            <h6 class="text-muted"><?php echo $row->artikel_skrevet; ?> af:
                <a href="index.php?page=redaktion"><?php
                    echo $row->bruger_fornavn . ' ' . $row->bruger_efternavn; ?></a>
            </h6>
            <i><?php echo $row->artikel_manchet; ?></i>
            <p><?php echo $row->kort_indhold; ?>...</p>
            <div class="well">
                <a class="alert-link" href="index.php?page=artikel&id=<?php
                echo $row->artikel_id; ?>">&dbkarow; Læs mere...</a> -
<!--                TODO tæl antal kommentar mm.-->
                <span class="text-info">Læst XX gange</span> - <span class="text-info"> XX kommentarer</span>
            </div>
        </div>
    </div>
    <hr>
    <?php
}




