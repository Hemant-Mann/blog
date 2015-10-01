<?php 
require_once("../includes/session.php");
require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php

if(isset($_POST['submit'])) {
	
	global $connection;
	//Data submitted by the user in the form
	$first_name = mysql_prep($_POST["first_name"]);
	$last_name = mysql_prep($_POST["last_name"]);
	$email_id = mysql_prep($_POST["email_id"]);
	$gender = $_POST["gender"];
	$age = (int) $_POST["age"];
	$username = mysql_prep($_POST["username"]);
	$password = password_encrypt($_POST["password"]);

	//validations
	$required_fields = array("first_name", "last_name", "email_id", "gender", "age", "username", "password");
	validate_presences($required_fields);	
	$fields_with_max_lengths = array("first_name" => 30, "last_name" => 30);
	validate_max_lengths($fields_with_max_lengths);
	validate_email($email_id);
	validate_username($username);
	
	if(!empty($errors)) {
	$_SESSION["errors"] = $errors;
	redirect_to(PROJECT."signup");
	}
	
	$query  = "INSERT INTO users (";
	$query .= " first_name, last_name, email_id, gender, age, username, password";
	$query .= ") VALUES (";
	$query .= " '{$first_name}', '{$last_name}', '{$email_id}', '{$gender}', {$age}, '{$username}', '{$password}'";
	$query .= ")";
	$result = mysqli_query($connection, $query); 	
	
	if($result && mysqli_affected_rows($connection) >= 1) {
		$_SESSION["message"] = "You have been registered successfully!";
		redirect_to(PROJECT."home");
	} else {
		$_SESSION["message"] = "Something went wrong, Please try again";
	}
}

?>
<div id = "main">
	<div id="page">
	<?php echo message();	?>
	<?php $errors = errors();
		echo form_errors($errors);
	?>
		<h2>New Member</h2>
		<form action="" method="post">
			<p>First Name:
				<input type="text" name="first_name" value="" />
			</p>
			<p>Last Name:
				<input type="text" name="last_name" value="" />
			</p>
			<p>Email Id:
				<input type="text" name="email_id" value="" />
			</p>
			<p>Gender:<br>
				<input type="radio" name="gender" value="male" /> Male
				&nbsp;
				<input type ="radio" name="gender" value="female" /> Female
			</p>
			<p>Age:   
				<input type="text" name="age" value="" /> 
			</p>
			<p>Username:
				<input type="text" name="username" value="" />
				(Please select any Username of your choice)
			</p>
			<p>Password:
				<input type="password" name="password" value="" />
			</p>
			<input type="submit" name="submit" value="Sign Up" />
		</form>
	 <a href="<?php echo PROJECT; ?>home">Cancel</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>