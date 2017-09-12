<?php

checkAccess();

// Kode til sletning af kommentarer

if (isset($_GET['slet_id'])) {
    $id = intval($_GET['slet_id']);

    $query = "DELETE FROM kommentarer WHERE kommentar_id = " . $id;
    $db->query($query);

    redirect_to('index.php?page='.$side);
}

?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider[$side]['ikon']; ?>"></i> <?php echo $sider[$side]['titel']; ?>
<!--    <small> Oversigt over kommentarer --><?php //if (isset($bruger)) {
//        echo '<em>' . $bruger['bruger_fornavn'] . ' ' . $bruger['bruger_efternavn'] .  '</em>'; } ?><!--</small>-->
</h1>

<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th align="right"><i class="fa fa-sort-numeric-desc fa-fw"></i> Oprettet</th>
                <th>#</th>
                <th>Brugernavn</th>
                <th>Email</th>
                <th>Tekst</th>
                <th>Artikel</th>
                <th></th>
                <th class="icon"></th>
                <th class="icon"></th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT kommentar_id,
                          DATE_FORMAT(kommentar_oprettet, '%e. %b %Y [%H:%i]') as tid,
                          kommentar_brugernavn,
                          kommentar_email,
                          SUBSTR(kommentar_tekst, 1, 25) as kort_tekst,
                          artikel_id,
                          SUBSTR(artikel_overskrift, 1, 25) as kort_overskrift
                  FROM kommentarer
                  INNER JOIN artikler ON kommentarer.fk_artikel_id = artikler.artikel_id
                  ORDER BY fk_artikel_id";
        $result = $db->query($query);
        if (!$result) { query_error($query, __LINE__, __FILE__); }


        $antal_kommentar = $result->num_rows;
        if ($antal_kommentar > 0) {
            while ($kommentar = $result->fetch_object()) {
                ?>
                <tr>
                    <td align="right"><?php echo $kommentar->tid; ?></td>
                    <td><?php echo $kommentar->kommentar_id; ?></td>
                    <td><?php echo $kommentar->kommentar_brugernavn; ?></td>
                    <td><?php echo $kommentar->kommentar_email; ?></td>
                    <td><?php echo $kommentar->kort_tekst; ?></td>
                    <td><a href="index.php?page=artikler#<?php echo $kommentar->artikel_id; ?>"><?php
                            echo $kommentar->kort_overskrift; ?>...</a></td>

                    <td><a href="index.php?page=rediger-kommentar&id=<?php echo $kommentar->kommentar_id; ?>"
                           class="btn btn-warning btn-xs" title="Redigér kommentar">
                            <i class="fa fa-edit fa-lg fa-fw"></i></a></td>
                    <td><a href="index.php?page=<?php echo $side; ?>&slet_id=<?php echo $kommentar->kommentar_id; ?>"
                           class="btn btn-danger btn-xs"
                           onClick="return confirm('Er du sikker på du vil slette kommentaren?')"
                           title="Slet kommentar"><i class="fa fa-trash-o fa-lg fa-fw"></i></a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="12">Der blev ikke fundet nogle kommentarer</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>
