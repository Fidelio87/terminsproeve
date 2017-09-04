<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 29/08/2017
 * Time: 13:21
 */

//seperator
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

//DB konstanter
defined('DB_SERVER') ? null : define('DB_SERVER', 'localhost');
defined('DB_USER') ? null : define('DB_USER', 'root');
defined('DB_PASS') ? null : define('DB_PASS', '');
defined('DB_NAME') ? null : define('DB_NAME', 'bbb_magasin');

defined('DEV_STATUS') ? null : define('DEV_STATUS', false);

defined('CONN_ERROR') ? null : define('CONN_ERROR', 'FEJL I FORBINDELSE TIL DATABASE!');

$root = '';
$include_path = 'public' . DS . 'includes' . DS;

if (DEV_STATUS) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

require '../includes/functions.php';

if (isset($_SESSION['user']['id'])) {
    check_fingerprint();
    check_last_activity();
}

// Connect to database
$db = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Check for connection error
if ($db->connect_error) {
    connect_error(__LINE__, __FILE__);
}

// Set charset from Db text to utf8
$db->set_charset('utf8');

// Set the database server to danish names for date and times
$result = $db->query("SET lc_time_names = 'da_DK';");

// If result returns false, use the function query_error to show debugging info
if (!$result) {
    query_error($query, __LINE__, __FILE__);
}


session_start();
ob_start();
