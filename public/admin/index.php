<?php

require_once 'config.php';

//IMPORTS
require '../../resources/vendor/autoload.php';

use Intervention\Image\ImageManager;

$manager = new ImageManager(array('driver' => 'gd'));

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['bruger']['niveau']) || (isset($_SESSION['bruger']['niveau']) &&
                                              $_SESSION['bruger']['niveau'] < 200)) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['page'])) {
    // …henter vi pagens filnavn herfra
    $side     = $_GET['page'];
    $side_sti = 'pages/' . $side . '.php';
} else {
    $side     = '';
    $side_sti = 'pages/dashboard.php';
}

$sider = [
            '' => ['ikon'                       => 'dashboard',
                   'titel'                      => 'Dashboard',
                   'vis'                        => 1,
                   'niveau'              => 200,
                   'aktiv_paa'                  => ['']
            ],
            'menu' => ['ikon'                  => 'reorder',
                        'titel'                 => 'Menu',
                        'vis'                   => 1,
                        'niveau'         => 1000,
                        'aktiv_paa'             => ['menu', 'rediger-menu']
            ],
            'rediger-menu' => ['ikon'           => 'reorder',
                               'titel'          => 'Rediger menu',
                               'vis'            => 0,
                               'niveau'  => 1000
            ],
            'brugere'		=> ['ikon'          => 'users',
                                 'titel'        => 'Brugere',
                                 'vis'          => 1,
                                 'niveau' => 1000, 'aktiv_paa' => ['brugere', 'opret-bruger', 'rediger-bruger']
            ],
            'opret-bruger'	=> ['ikon'          => 'users',
                                'titel'         => 'Opret bruger',
                                'vis'           => 0,
                                'niveau' => 1000
            ],
            'rediger-bruger'=> ['ikon'          => 'users',
                                'titel'         => 'Rediger bruger',
                                'vis'           => 0,
                                'niveau' => 1000
            ],
            'artikler'			=> ['ikon'          => 'file-text-o',
                                'titel'         => 'Artikler',
                                'vis'           => 1,
                                'niveau' => 200,
                                'aktiv_paa'     => ['artikel', 'opret-artikel', 'rediger-artikel']
            ],
            'opret-artikel'	=> ['ikon'          => 'plus',
                                'titel'         => 'Opret artikel',
                                'vis'           => 0,
                                'niveau' => 200
            ],
            'rediger-artikel'	=> ['ikon'      => 'file-text-o',
                                'titel'         => 'Rediger artikel',
                                'vis'           => 0,
                                'niveau' => 200
            ],
            'ansvar'	=> ['ikon'          => 'list-ol',
                                'titel'         => 'Ansvar',
                                'vis'           => 1,
                                'niveau' => 1000,
                                'aktiv_paa'     => ['ansvar']
            ],
            'kommentarer'		=> ['ikon'          => 'pencil',
                                'titel'         => 'Kommentarer',
                                'vis'           => 1,
                                'niveau' => 1000,
                                'aktiv_paa'     => ['kommentarer', 'rediger-kommentar']
            ],
            'rediger-kommentar'=> ['ikon'         => 'pencil',
                                 'titel'        => 'Rediger kommentar',
                                 'vis'          => 0,
                                 'niveau' => 1000
            ],
            'Reklammer'		=> ['ikon'          => 'dollar',
                                'titel'         => 'Reklamer',
                                'vis'           => 1,
                                'niveau' => 1000,
                                'aktiv_paa'     => ['reklamer', 'opret-reklame', 'rediger-reklame']
            ],
            'opret-reklame'  => ['ikon'          => 'dollar',
                                'titel'         => 'Opret reklame',
                                'vis'           => 0,
                                'niveau' => 1000],
            'rediger-reklame'=> ['ikon'          => 'dollar',
                                'titel'         => 'Rediger reklame',
                                'vis'           => 0,
                                'niveau' => 1000
            ]
];

if (isset($sider[$side]['titel'])) {
    $side_titel = $sider[$side]['titel'];
} else {
    $side_titel = 'HTTP 404';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - BBB Magasin - <?php echo $side_titel; ?></title>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
          crossorigin="anonymous">
    <!--    <link rel="stylesheet" href="../assets/font_awesome/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="../css/backend.css">
    <link rel="stylesheet" href="css/sb-admin-2.min.css">
</head>
<body>

    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><i class="fa fa-cogs fa-fw"></i> BBB Magasin Admin</a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['bruger']['brugernavn']; ?>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="index.php?page=rediger-bruger"><i class="fa fa-pencil fa-fw"></i> Rediger profil</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="index.php?logout"><i class="fa fa-sign-out fa-fw"></i> Log af</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <?php
//                        udskriver alle links i $sider-array
                        foreach ($sider as $key => $value) {
                            if ($_SESSION['bruger']['niveau'] >= $value['niveau'] && $value['vis'] == 1) {
                                ?>
                                <li>
                                    <a <?php
                                    if (in_array($sider, $value['aktiv_paa'])) {
                                        echo 'class="active"';
                                    } ?> href="index.php<?php if (!empty($key)) {
                                                                echo '?page=' . $key;
                                                                } ?>">
                                        <i class="fa fa-<?php echo $value['ikon']; ?> fa-fw"></i>
                                    <?php echo $value['titel']; ?></a>
                                </li>
                        <?php
                            }
                        }
                        ?>
                        <li>
                            <a href="../index.php" target="_blank"><i class="fa fa-external-link fa-fw">

                                </i> Gå til frontend</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
<!--        Page content-->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        if (file_exists($side_sti)) {
                            include($side_sti);
                        } else {
                            ?>
                            <h1><i class="fa fa-exclamation-triangle"></i> Websiden blev ikke fundet (HTTP 404)</h1>
                            <hr>
                            <p>Ups!.. Noget gik galt. Siden du efterspurgte kunne ikke findes. Prøv evt. senere.</p>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <?php show_dev_info(); ?>
                </div>
            </div>
<!--            .page-wrapper-->
        </div>
<!--        .wrapper-->
    </div>

<!--SCRIPTS-->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Googles prettyprint -->
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
<script src="js/sb-admin-2.js"></script>

</body>
</html>
<?php $db->close(); ?>