<?php

function alert($type, $msg)
{
    ?>
    <div class="alert alert-<?php echo $type ?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <?php echo $msg ?>
    </div>
    <?php
}

function connect_error($line_number, $file_name)
{
    global $db;

    // If developer status is set to true, show all information
    if (DEV_STATUS) {
        die('<p>Forbindelsesfejl (' . $db->connect_errno . '): ' . $db->connect_error . '</p><p>Linje: ' .
            $line_number . '</p><p>Fil: ' . $file_name . '</p>');
    } // If developer status is set to false, only show user friendly message
    else {
        die(CONNECTION_ABORTED);
    }
}


function query_error($query, $line_number, $file_name)
{
    global $db;

    // If developer status is set to true, show all information
    if (DEV_STATUS) {
        $message =
            '<strong>' . $db->error . '</strong><br>
			Line: <strong>' . $line_number . ' </strong><br>
			File: <strong>' . $file_name . '</strong>
			<pre class="prettyprint lang-sql linenums"><code>' . $query . '</code></pre>';

        alert('danger', $message);
        $db->close();
    } else {
        alert('danger', 'Teknisk fejl!');
        $db->close();
    }
}


/**
 * @param $data
 * @param string $prefix_string
 */
function prettyprint($data, $prefix_string = '')
{
    ?>
    <pre class="prettyprint lang-php"><code><?php echo $prefix_string;
            print_r($data) ?></code></pre>
    <?php
}


function show_dev_info()
{
    // If developer status is set to true, show all information from get/post/files/session/cookie
    if (DEV_STATUS)
    {
    echo '<br>';
    prettyprint($_GET, 'GET ');
    prettyprint($_POST, 'POST ');
    prettyprint($_FILES, 'FILES ');
    prettyprint($_SESSION, 'SESSION ');
    prettyprint($_COOKIE, 'COOKIE ');


    }
}

/**
 * Function to create links for pagination
 * @param string $page : The name of the file in view/ the links in the pagination should refer to
 * @param int $page_no : current page no
 * @param int $items_total : the counted total amount of items
 * @param int $page_length : the desired amount of items per page
 * @param int $page_around : The desired amount of pages to show before and after the current page
 * @param bool $show_disabled_arrows : Show disabled next or previous links, or hide them
 */
function pagination($page, $page_no, $items_total, $page_length, $page_around = 2, $show_disabled_arrows = true)
{
    // Only show pagination total items is greater than page length
    if ($items_total > $page_length) {
        $pages_total = ceil($items_total / $page_length);

        // Page to start the for-loop from, at least 2 below (or what's set in page_around) the current page
        $page_from = $page_no - $page_around;

        // If current page (page_no) is in the last half of visible pages, set page_from to the total pages minus page_around x2 (default 2x2) plus 2. Default page_from will be calculated to 6 below the total amount
        if ($page_no > $pages_total - $page_around * 2) {
            $page_from = $pages_total - ($page_around * 2 + 2);
        }

        // If page_from was calculated to be below 2, we start from the lowest number 2 (because we always have page one)
        if ($page_from < 2) {
            $page_from = 2;
        }

        // Page to end the for-loop with, at least 2 above (or what's set in page_around) the current page
        $page_to = $page_no + $page_around;

        // If current page (page_no) is in the first half of visible pages, set page_to, to page_around x2 (default 2x2), plus 3. Default page_to, will be calcaluted to 7
        if ($page_no <= $page_around * 2) {
            $page_to = $page_around * 2 + 3;
        }

        // If page_to was calculated to be above or equal to the total amount of pages, we end with the highest number possible. One below the total number, because we always have the last page.
        if ($page_to >= $pages_total) {
            $page_to = $pages_total - 1;
        }

        echo '<ul class="pagination">';

        // If current page is greater than 1, show previous button
        if ($page_no > 1) {
            echo '<li><a href="index.php?page=' . $page . '&page-no=' . ($page_no - 1) . '" data-page="' . $page . '" data-params="page-no=' . ($page_no - 1) . '"><i class="fa fa-angle-left fa-fw" aria-hidden="true"></i></a></li>';
        } // If current page is not greater than 1 and show_disabled_arrows is set to true, show disabled previous link
        else {
            if ($show_disabled_arrows) {
                echo '<li class="disabled"><span><i class="fa fa-angle-left fa-fw" aria-hidden="true"></i></span></li>';
            }
        }

        // Show first page
        echo '<li' . ($page_no == 1 ? ' class="active"' : '') . '><a href="index.php?page=' . $page . '&page-no=1" data-page="' . $page . '" data-params="page-no=1">1</a></li>';

        // If page_from is greater than 2, we have skipped some pages, and show 3 dots
        if ($page_from > 2) {
            echo '<li class="disabled"><span>&hellip;</span></li>';
        }

        // Do for-loop, start from number in page_from, and end with the number in page_to, increment with one each time the loop runs
        for ($i = $page_from; $i <= $page_to; $i++) {
            echo '<li' . ($page_no == $i ? ' class="active"' : '') . '><a href="index.php?page=' . $page . '&page-no=' . $i . '" data-page="' . $page . '" data-params="page-no=' . $i . '">' . $i . '</a></li>';
        }

        // If page_to is smaller than the second last page, we have skipped some pages in the end, so we show 3 dots
        if ($page_to < $pages_total - 1) {
            echo '<li class="disabled"><span>&hellip;</span></li>';
        }

        // Show last page
        echo '<li' . ($page_no == $pages_total ? ' class="active"' : '') . '><a href="index.php?page=' . $page . '&page-no=' . $pages_total . '" data-page="' . $page . '" data-params="page-no=' . $pages_total . '">' . $pages_total . '</a></li>';

        // If current page is smaller than pages total, show next link
        if ($page_no < $pages_total) {
            echo '<li><a href="index.php?page=' . $page . '&page-no=' . ($page_no + 1) . '" data-page="' . $page . '" data-params="page-no=' . ($page_no + 1) . '"><i class="fa fa-angle-right fa-fw" aria-hidden="true"></i></a></li>';
        } // If current page is not smaller than pages total and show_disabled_arrows is set to true, show disabled next link
        else {
            if ($show_disabled_arrows) {
                echo '<li class="disabled"><span><i class="fa fa-angle-right fa-fw" aria-hidden="true"></i></span></li>';
            }
        }

        echo '</ul>';
    }
}

/**
 * Function to get links from related menu
 * @param int $menu_id :            id for the related menu, links should be pulled from
 * @param string $page_url_key :    URL key for current page
 * @param string $post_url_key : URL key for current post
 */
function get_menu_links($menu_id, $page_url_key = '', $post_url_key = '')
{
    global $db;

    // Get links to bookmarks and active pages/posts to the main menu from the database
    $query =
        "SELECT
				menu_link_name, menu_link_bookmark, menu_link_type_id, menu_link_type_prefix_url, page_url_key, post_url_key
			FROM
				menus_menu_links
			INNER JOIN
				menu_links ON menus_menu_links.fk_menu_link_id = menu_links.menu_link_id
			INNER JOIN
				menu_link_types ON menu_links.fk_link_type_id = menu_link_types.menu_link_type_id
			INNER JOIN
				pages ON menu_links.fk_page_id = pages.page_id
			LEFT JOIN
				posts ON menu_links.fk_post_id = posts.post_id
			WHERE
				fk_menu_id = $menu_id
			AND
				page_status = 1
			AND
				(post_status IS NULL
			OR
				post_status = 1)
			ORDER BY
				menu_link_order";
    $result = $db->query($query);

    // If result returns false, use the function query_error to show debugging info
    if (!$result) {
        query_error($query, __LINE__, __FILE__);
    }

    while ($row = $result->fetch_object()) {
        $url = empty($row->page_url_key) ? './' : 'index.php?page=' . $row->page_url_key;

        switch ($row->menu_link_type_id) {
            // If link type is 3 (bookmark) append this to the $url
            case 3:
                // If the bookmark is on the current page, only use the bookmark in url, so clear value in $url
                if ($row->page_url_key == $page_url_key) {
                    $url = '';
                }

                // If both prefix url and bookmark is defined, append the values to the variable $url
                $url .= isset($row->menu_link_type_prefix_url) && isset($row->menu_link_bookmark) ? $row->menu_link_type_prefix_url . $row->menu_link_bookmark : '';
                $active = '';
                break;
            // If link type is 2 (post) append this to the $url
            case 2:
                // If both prefix url and the url key for the post is defined, append the values to the variable $url
                $url .= isset($row->menu_link_type_prefix_url) && isset($row->post_url_key) ? $row->menu_link_type_prefix_url . $row->post_url_key : '';

                // If the current page and post mathes this link for the post, add the class active to the li that wraps the link
                $active = $row->page_url_key == $page_url_key && $row->post_url_key == $post_url_key ? ' class="active"' : '';
                break;
            default:
                // If the page_url_key matches the current page, add the class active to the li that wraps the link
                $active = $row->page_url_key == $page_url_key ? ' class="active"' : '';
            //$current_url = basename($_SERVER['REQUEST_URI']);
            //$active = $current_url == $url || ($page_url_key == '' && $row->page_url_key == '') ? ' class="active"' : '';
        }

        echo '<li' . $active . '><a href="' . $url . '">' . $row->menu_link_name . '</a></li>';
    }
}

/**
 * Take the user agent info from the browser, add a salt and hash the information with the algo sha256
 * @return string
 */
function fingerprint()
{
    return hash('sha256', $_SERVER['HTTP_USER_AGENT'] . '!Å%bpxP-ghQæØ#_(');
}


/**
 * @param $brugernavn
 * @param $password
 *
 * @return bool
 */
function login($brugernavn, $password)
{
    if (empty($brugernavn) || empty($password)) {
        alert('warning', 'Alle input-felter skal være udfyldte!');
    } else {
        global $db;

        $brugernavn = $db->escape_string($brugernavn);

        // Select active user that matches the typed e-mail address
        $query =
            "SELECT 
				bruger_id, bruger_brugernavn, bruger_password, rolle_niveau
			FROM 
				brugere
            INNER JOIN
                roller ON brugere.fk_rolle_id = roller.rolle_id
			WHERE 
				bruger_brugernavn = '$brugernavn' 
			AND 
				bruger_status = 1";
        $result = $db->query($query);

        // If result returns false, use the function query_error to show debugging info
        if (!$result) {
            query_error($query, __LINE__, __FILE__);
        }

        if ($result->num_rows == 1) {
            $row = $result->fetch_object();

            if (password_verify($password, $row->bruger_password)) {
                session_regenerate_id();

                $_SESSION['bruger']['id']           = $row->bruger_id;
                $_SESSION['bruger']['brugernavn']   = $row->bruger_brugernavn;
                $_SESSION['bruger']['niveau']       = $row->rolle_niveau;
                $_SESSION['fingerprint']            = fingerprint();

                return true;
            } else {
                alert('warning', 'Password not correct');
            }
        } else {
            alert('warning', 'Email or password not correct');
        }
    }
    return false;
}

/**
 * Delete the sessions from login and give the session a new id
 */
function logout()
{
    unset($_SESSION['bruger']);
    unset($_SESSION['fingerprint']);
    unset($_SESSION['last_activity']);
    // Give the current session a new id before saving user information into it
    session_regenerate_id();
}

/**
 * Function to check if the current users access level is over 100, which is equal to Admin
 * @return bool
 */
function is_admin()
{
    return $_SESSION['user']['niveau'] < 1000 ? true : false;
}

/**
 * Function to check if the fingerprint stored in session, matches to current fingerprint returned from the function fingerprint()
 */
function check_fingerprint()
{
    // If the current fingerprint returned from the function doesn't match the fingerprint stored in session, logout!
    if ($_SESSION['fingerprint'] != fingerprint()) {
        logout();
        header('Location: index.php');
        exit;
    }
}

/**
 * Function to check if the user has been active within the last 30 mins
 */
function check_last_activity()
{
    // If developer status is false, use on session
    if (!DEV_STATUS) {
        // If session last activity is set and the current timestamp + 30 mins is less than current timestamp,
        // log the user out
        if (isset($_SESSION['last_activity']) && $_SESSION['last_activity'] + 1800 < time()) {
            logout();
            header('Location: index.php');
            exit;
        } // Or update the session with current timestamp
        else {
            $_SESSION['last_activity'] = time();
        }
    }
}

/**
 * @param string $string :    The text to shorten
 * @param int $chars :        The amount of characters to display of the text
 * @return string
 */
function shorten_string($string, $chars)
{
    $string = strip_tags($string);

    if (mb_strlen($string, 'utf8mb4') > $chars) {
        $last_space = strrpos(substr($string, 0, $chars + 1), ' ');
        $string = substr($string, 0, $last_space) . '&hellip;';
    }
    return $string;
}

/**
 * Function to send emails with correct header information.
 * @param string $to :        The e-mail address of the reciever of the e-mail
 * @param string $subject :    The subject of the e-mail
 * @param string $message :    The text in the e-mail
 * @param string $from :        The email address of the sender of the e-mail
 * @param string $from_name :The name of the sender of the e-mail
 * @return bool
 */
function send_mail($to, $subject, $message, $from, $from_name)
{
    // To send HTML mail, the Content-type header must be set
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Additional headers
    $headers .= "From: " . $from_name . " <" . $from . ">\r\n";

    // Mail it
    return mail($to, $subject, $message, $headers);
}

function fetch_array($result)
{
    return mysqli_fetch_array($result);
}

function num_rows($result)
{
    return mysqli_num_rows($result);
}

function insert_id()
{
    global $db;
    return mysqli_insert_id($db);
}

function affected_rows()
{
    global $db;
    return mysqli_affected_rows($db);
}

/**
 * Short helper function for URL redirecting
 * @param null|string $location
 */
function redirect_to(string $location = null)
{
    if ($location != null) {
        header('Location: ' . $location);
        exit;
    }
}


function opret_bruger(
    $brugernavn,
    $fornavn,
    $efternavn,
    $beskrivelse,
    $password,
    $conf_password,
    $tlf,
    $email,
    $rolle
)
{

    global $db;
//    global $manager;

    if ($password != $conf_password) {
        ?>
        <p class="text-danger">Kodeordene skal være ens!</p>
        <?php
    } else {
        //condition tlf tomt
        if (empty($tlf)) {
            $tlf = '12345678';
        } else {
            $tlf = $db->real_escape_string($tlf);
        }
        //condition beskrivelse tomt
        if (empty($beskrivelse)) {
            $beskrivelse = '';
        } else {
            $beskrivelse = $db->real_escape_string($beskrivelse);
        }

//        if (empty($img)) {
//            $filnavn = 'placeholder.jpg';
//        } else {
//            $filnavn = time() . $img['name'];
//        }
//        COUNT QUERY
        $query_count = "SELECT COUNT(bruger_email) AS antal
                        FROM brugere
                        WHERE bruger_email = '$email'";

        $result_count = $db->query($query_count);
        if (!$result_count) { query_error($query, __LINE__, __FILE__); }
        $row_count    = $result_count->fetch_object();

        //hvis bruger m identisk email
        if ($row_count->antal > 0) {
            ?>
            <p class="text-warning">Email-adressen <?php echo $email; ?> er desværre optaget. Prøv en ny.</p>
            <?php
        } else {
            //hvis rolle er valgt
//            if (isset($rolle)) {
//                $rolle_id = $rolle;
//            } else {
//                //ellers er id standard - journalist er 1
//                $rolle_id = 1;
//            } //.slut - rollevalg

            //make password-hash
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            //opret insert-query
            $query = "INSERT INTO brugere (bruger_brugernavn,
                                            bruger_fornavn,
                                            bruger_efternavn,
                                            bruger_beskrivelse,
                                            bruger_password,
                                            bruger_tlf,
                                            bruger_email,
                                            fk_rolle_id) 
                      VALUES ('$brugernavn',
                              '$fornavn',
                              '$efternavn',
                              '$beskrivelse',
                              '$password_hashed',
                              $tlf,
                              '$email',
                              1)";
            $result = $db->query($query);

            if (!$result) { query_error($query, __LINE__, __FILE__); }

            ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                Bruger blev oprettet med succes.<?php if (isset($rolle)) { ?> <a href="index.php?page=brugere">
                    Klik her for at returnere til oversigten
                </a>
                    <?php
                }
                ?>
            </div>
            <?php

        } //.slut email validering
    } //.slut password-validering
} //.slut - function

function rediger_bruger(
    $id,
    $brugernavn,
    $fornavn,
    $efternavn,
    $beskrivelse,
    $password,
    $conf_password,
    $tlf,
    $email
)
{
    global $db;

    if ($password != $conf_password) {
        ?>
        <p class="text-warning">Password matcher ikke</p>
        <?php
    } else {
        if (empty($tlf)) {
            $tlf = 'NULL';
        } else {
            $tlf = $db->real_escape_string($tlf);
        }

        $query = "SELECT COUNT(bruger_email) AS antal
                    FROM brugere
                    WHERE bruger_email = '$email'
                    AND bruger_id != $id";
        $result = $db->query($query);
        if (!$result) { query_error($query, __LINE__, __FILE__); }

        $row = $result->fetch_object();
        if ($row->antal > 0) {
            ?>
            <p class="text-warning">Email er ikke ledig!</p>
            <?php
        } else {
            if (!empty($password)) {
                $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                //sekvens til sql-statement
                $password_sql = ", bruger_password = '$password_hashed'";
            } else {
                $password_sql = '';
            }

            if (empty($beskrivelse)) {
                $beskrivelse_sql = ", bruger_beskrivelse = '$beskrivelse'";
            } else {
                $beskrivelse_sql = '';
            }

            $query = "UPDATE brugere
                        SET bruger_brugernavn = '$brugernavn',
                            bruger_fornavn = '$fornavn',
                            bruger_efternavn = '$efternavn'
                            $beskrivelse_sql
                            $password_sql,
                            bruger_tlf = $tlf,
                            bruger_email = '$email'
                        WHERE bruger_id = $id
                        ";
            $db->query($query);
            ?>
            <div class="row">
                <p class="text-success">Brugeren er nu redigeret!</p>
            </div>
            <?php
        } //.slut email-check
    } //.slut password-check
} //.slut funktion
