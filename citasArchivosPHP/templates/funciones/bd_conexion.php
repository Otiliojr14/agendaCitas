<?php

    define('DB_USER', 'cc2k17damrios');
    define('DB_PASSWORD', 'ujat$2017$ccdamrios');
    define('DB_DATABASE', 'ujat21damrios20');
    define('DB_SERVER', 'mysql.damrios.com');
    
    $mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
	mysqli_set_charset($mysqli, "utf8");

    if($mysqli -> connect_error) {
        echo $error = $mysqli->connect_error;
    }
    
?>
