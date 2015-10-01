<?php

$project_path = dirname(dirname(__FILE__));
$name = array_pop(explode("/", $project_path));
define("PROJECT", "/{$name}/");

function redirect_to($new_location) {
	header("Location: " . $new_location);
	exit;
}

function mysql_prep($string) {
	global $connection;
	$escaped_string = mysqli_real_escape_string($connection, $string);
	return $escaped_string;
}

function confirm_query($result_set) {
	if(!$result_set) {
		die("Database query failed.");
	}
}

function form_errors ($errors = array()) {
$output = "";
if(!empty($errors)) {
	$output .= "<div class = \"error\">";
	$output .= "Please fix the following errors: ";
	$output .= "<ul>";
	foreach ($errors as $key => $error) {
		$output .= "<li>";
		$output .= htmlentities($error);
		$output .= "</li>";
	}
	$output .= "</ul>";
	$output .= "</div>";
}	
return $output;
}

function find_all_users() {
	global $connection;
	$query = "SELECT * ";       		
	$query .= "FROM users";		
	$user_set = mysqli_query($connection, $query); 	
	confirm_query($user_set);
	return $user_set;
	
}

function find_user_by_id($id) {
	global $connection;
	$safe_id = mysqli_real_escape_string($connection, $id);
	$query = "SELECT * ";       		
	$query .= "FROM users ";			
	$query .= "WHERE id = {$safe_id} ";
	$user_set = mysqli_query($connection, $query); 	
	confirm_query($user_set);
	$user = mysqli_fetch_assoc($user_set);
	return $user;
}

function find_all_posts() {
	global $connection;
	$query  = "SELECT * ";
	$query .= "FROM posts ";
	$post_set = mysqli_query($connection, $query);
	confirm_query($post_set);
	return $post_set;
}

function find_post_by_user_id($user_id) {
	global $connection;
	$safe_id = mysqli_real_escape_string($connection, $user_id);
	$query = "SELECT * ";       		
	$query .= "FROM posts ";			
	$query .= "WHERE user_id = {$safe_id} ";
	$post_set = mysqli_query($connection, $query); 	
	confirm_query($post_set);
	$post = mysqli_fetch_assoc($post_set);
	return $post;
}

function password_encrypt($password) {
	$hash_format = "$2y$10$";  //tells PHP to use Blowfish with a "cost" of 10
	$salt_length = 22; //Blowfish salts should be 22-characters or more
	$salt = generate_salt($salt_length);
	$format_and_salt = $hash_format. $salt;	
	$hash = crypt($password, $format_and_salt);
	return $hash;
}

function generate_salt($length) {
	//Not 100% unique, not 100% random, but good enought for a salt
	//MD5 returns 32 characters
	$unique_random_string = md5(uniqid(mt_rand(), true));
	
	//valid characters for a salt are [a-z A-Z 0-9 ./]
	$base64_string = base64_encode($unique_random_string);
	
	//but not '+' which is in base64 encoding
	$modified_base64_string = str_replace('+', '.', $base64_string);
	
	//Truncate string to the correct length
	$salt = substr($modified_base64_string, 0, $length);
	
	return $salt;
}

function password_check($password, $existing_hash) {
	//existing hash contains format and salt 
	$hash = crypt($password, $existing_hash);
	if($hash == $existing_hash) {
	  return true;
	} else {
	  return false;
	}
}

function find_user_by_username($username) {
	global $connection;
	$safe_username = mysqli_real_escape_string($connection, $username);
	$query  = "SELECT * ";       		
	$query .= "FROM users ";			
	$query .= "WHERE username = '{$safe_username}' ";
	$user_set = mysqli_query($connection, $query); 	
	confirm_query($user_set);
	$user = mysqli_fetch_assoc($user_set);
	return $user;
}

function find_user_by_email($email_id) {
	global $connection;
	$safe_email_id = mysqli_real_escape_string($connection, $email_id);
	$query  = "SELECT * ";       		
	$query .= "FROM users ";			
	$query .= "WHERE email_id = '{$safe_email_id}' ";
	$user_set = mysqli_query($connection, $query); 	
	confirm_query($user_set);
	$user = mysqli_fetch_assoc($user_set);
	return $user;
}

function attempt_login($username, $password) {
	$user = find_user_by_username($username);
	if($user) {
	  if(password_check($password, $user["password"])) {
	  return $user;
	  } else {   return false; 	}
	} else {
	  return false;
	 }
}

function logged_in() {
 return isset($_SESSION["user_id"]);
}

function confirm_logged_in() {
	if(!logged_in()) {
		redirect_to(PROJECT."login");
	}
}
?>
