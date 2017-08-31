<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 29/08/2017
 * Time: 12:56
 */

$query = "SELECT bruger_id,
                  bruger_fornavn,
                  bruger_efternavn,
                  bruger_beskrivelse,
                  bruger_tlf,
                  bruger_email,
                  bruger_img,
                  kat_navn
          FROM brugere
          INNER JOIN ansvar ON brugere.bruger_id = ansvar.fk_bruger_id
          INNER JOIN kategorier ON ansvar.fk_kategori_id = kategorier.kat_id
          WHERE bruger_status = 1 AND fk_rolle_id = 1
          ORDER BY kat_id, bruger_efternavn";

$result = $db->query($query);

if (!$result) {
    query_error($query, __LINE__, __FILE__);
}

while ($row = $result->fetch_object()) {
    ?>
    <div class="media">
        <div class="media-right pull-right">
            <img class="media-object" style="width: 80px" src="img/personer/<?php
            echo $row->bruger_img; ?>" alt="">
            <a href="mailto: <?php echo $row->bruger_email; ?>"><?php echo $row->bruger_email; ?></a>
        </div>
        <div class="media-body">
            <h2 class="media-heading"><?php echo $row->bruger_fornavn . ' ' . $row->bruger_efternavn; ?></h2>
            <p><?php echo $row->bruger_beskrivelse; ?>...</p>
            <br>
            <p>Ekspertise: <span class="label label-default"><?php echo $row->kat_navn; ?></span></p>
        </div>
    </div>

    <hr>
    <?php
}