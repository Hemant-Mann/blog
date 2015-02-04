<?php
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "fhemzrant");
define("DB_NAME", "blog");
//creates database connection
 
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
//Test if connection occured
if(mysqli_connect_errno()) {
die("Database connection failed: ".
    mysqli_connect_error(). " (". mysqli_connect_errno(). ")" );
	}

?>