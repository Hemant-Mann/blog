<?php
define("DB_SERVER", "localhost");
define("DB_USER", "blogger"); // your username
define("DB_PASS", "blogger"); // your password
define("DB_NAME", "blog");	// database name
//creates database connection
 
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
//Test if connection occured
if(mysqli_connect_errno()) {
die("Database connection failed: ".
    mysqli_connect_error(). " (". mysqli_connect_errno(). ")" );
	}

?>