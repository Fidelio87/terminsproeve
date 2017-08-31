<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 30/08/2017
 * Time: 10:36
 */



$query = "SELECT artikel_id,
                artikel_skrevet,
                artikel_overskrift,
                artikel_manchet,
                SUBSTR(artikel_indhold, 1, 200) as kort_indhold,
                bruger_fornavn,
                bruger_efternavn,
                kat_id,
                kat_navn,
                kat_img
          FROM artikler
          INNER JOIN brugere ON artikler.fk_bruger_id = brugere.bruger_id
          INNER JOIN kategorier ON artikler.fk_kategori_id = kategorier.kat_id
          WHERE artikel_status = 1
          ORDER BY artikel_skrevet 
          DESC LIMIT 5";

$result = $db->query($query);

if (!$result) {
    query_error($query, __LINE__, __FILE__);
}

while ($row = $result->fetch_object()) {
?>
    <div class="media">
        <div class="media-right pull-right">
            <a href="index.php?page=artikler&kategori=<?php echo $row->kat_id; ?>">
                <img class="media-object" src="img/<?php echo $row->kat_img; ?>" alt="se alle artikler vedr. <?php
                echo $row->kat_navn; ?>">
            </a>
        </div>
        <div class="media-body">
            <h2 class="media-heading"><?php echo $row->artikel_overskrift; ?></h2>
            <h6 class="text-muted"><?php echo $row->artikel_skrevet; ?> af:
                <a href="index.php?page=redaktion"><?php
                    echo $row->bruger_fornavn . ' ' . $row->bruger_efternavn; ?></a>
            </h6>
            <i><?php echo $row->artikel_manchet; ?></i>
            <p><?php echo $row->kort_indhold; ?>...</p>
            <a class="alert-link" href="index.php?page=artikel&id=<?php
            echo $row->artikel_id; ?>">&dbkarow; Læs mere...</a>
        </div>
    </div>

    <hr>
<?php
}







