<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 29/08/2017
 * Time: 14:22
 */

require_once '../config/config.php';

$query  = 'SELECT navn FROM adresser LIMIT 1';
$result = $db->query($query);
$row    = $result->fetch_object();
if (!$result) {
    query_error($query, __LINE__, __FILE__);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0,
    maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $row->navn; ?>>- Side ikke fundet</title>
</head>
<body>

<div class="jumbotron">
    <div class="container">
        <h1>Ups!</h1>
        <p>Side ikke fundet...</p>
        <p>
            <a href="index.php" class="btn btn-info btn-lg">Kom tilbage til forsiden</a>
        </p>
    </div>
</div>

</body>
</html>
