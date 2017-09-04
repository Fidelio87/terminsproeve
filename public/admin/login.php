<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 16-12-2016
 * Time: 08:35
 */

require_once 'config.php';

if (isset($_SESSION['adgangsniveau']) && $_SESSION['adgangsniveau'] >= 200) {
    header('Location: index.php');
    exit;
}

?>
<!doctype html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,
                                    user-scalable=no,
                                    initial-scale=1.0,
                                    maximum-scale=1.0,
                                    minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
          crossorigin="anonymous">
    <!--    <link rel="stylesheet" href="../assets/font_awesome/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="../css/backend.css">
    <link rel="stylesheet" href="css/sb-admin-2.min.css">
</head>
<body">
    <div class="page-header">
        <h1>Login</h1>
    </div>
    <div class="container">
        <div class="row">
            <form action="" method="post" class="form-inline" role="form">
                <div class="form-group">
                    <label for="username" class="control-label">Brugernavn</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <?php
                if (isset($_POST['login'])) {
                    login($_POST['username'], $_POST['password']);

                    redirect_to('index.php');
                }
                ?>

                <button type="submit" class="btn btn-success btn-block" name="login">
                    <i class="fa fa-sign-in fa-fw"></i> Log på</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php $db->close(); ?>