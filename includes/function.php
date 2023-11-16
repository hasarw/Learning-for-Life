<?php
include_once 'config.php';
session_start();

function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    /*Sets the session name.
     *This must come before session_set_cookie_params due to an undocumented bug/feature in PHP.
     */
    session_name($session_name);

    $secure = true;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"],
        $cookieParams["domain"],
        $secure,
        $httponly);

    session_start();            // Start the PHP session
    session_regenerate_id(true);    // regenerated the session, delete the old one.
}





function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}




function login($username, $password) {

  $user = $username;
  $pass = $password;

  $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
  $stmt = $conn->prepare("SELECT member_id, member_name ,member_username, member_password, member_type FROM tbl_members where member_username= ? AND member_password= ? Limit 1");

  $stmt->bind_param('ss', $user, $pass);
  $stmt->execute();

  $stmt->store_result();


  $stmt->bind_result($id, $first_name, $last_name, $username, $member_type);
    if ($stmt->num_rows == 1) {
     while ($stmt->fetch()) {
       $_SESSION['member_id'] = $id;
       $_SESSION['member_username'] = $last_name;
       $_SESSION['member_name'] = $first_name;
       $_SESSION['member_type'] = $member_type;
     }
     return true;
   }
  $stmt->free_result();
  $stmt->close();
}



function check_login(){

if(!isset($_SESSION['member_username'])){

  header ("location: login.php");

}

}
