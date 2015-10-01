<?php require_once("../includes/session.php"); require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php 
$login = logged_in();
if($login) {
	redirect_to("blog.php?user=". $_SESSION["user_id"]);
}

if(isset($_POST['submit'])) {
	
	$required_fields = array("username", "password");
	validate_presences($required_fields);
	
	if(!empty($errors)) {
		$_SESSION["errors"] = $errors;
		redirect_to("login.php");
	}
	$username= $_POST["username"];
	$password= $_POST["password"];
	
	$found_user = attempt_login($username, $password);
	
	if($found_user) {
		//Mark user as logged in
		$_SESSION["user_id"] = $found_user["id"];
		$_SESSION["username"] = $found_user["username"];
		redirect_to(PROJECT."blog?user=". $found_user["id"]);
	} else {
		//failure
		$_SESSION["message"] = "Username/password not found";
		redirect_to(PROJECT."login");
	}
}

?>
<?php $layout_context = "user"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
	<div id="navigation">
	</div>
	<div id="page">
	<?php echo message();	?>
	<?php $errors = errors();
		echo form_errors($errors);	?>
		<h2>Login</h2>
		<form action="" method="post">
			<p>Username:
				<input type="text" name="username" value="" /><br>
			</p>
			<p>Password:
				<input type="password" name="password" value="" /><br>
			</p>
			<input type="submit" name="submit" value="Login" />
		</form>
	</div>
</div>


<?php include("../includes/layouts/footer.php"); ?>