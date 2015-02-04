<?php 
require_once("../includes/session.php"); 
require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php 
	$current_user_id = $_SESSION["user_id"];

  if(isset($_POST["submit"])) {
	$content = mysql_prep($_POST["content"]);
	$required_fields = array("content");
	validate_presences($required_fields);
	
	if(!empty($errors)) {
	$_SESSION["errors"] = $errors;
	redirect_to("blog.php?user=". urlencode($current_user_id));
	}
	
	$query  = "INSERT INTO posts (";
	$query .= "  user_id, content";
	$query .= ") VALUES (";
	$query .= " {$current_user_id}, '{$content}'";
	$query .= ")";
	$result = mysqli_query($connection, $query); 	
	
	if($result) {
		$_SESSION["message"] = "Entry Posted";
		redirect_to("blog.php?user=". urlencode($current_user_id));
	} else {
		$_SESSION["message"] = "Failed to post your entry!";
	}

}
?>
<?php include("../includes/layouts/header.php"); ?>
<div id = "main">
	<div id="page">
		<?php 
		$errors = errors();
		echo form_errors($errors);
		echo message(); ?>
		<h2>Welcome: <?php echo htmlentities($_SESSION["username"]); ?></h2>
		<form action="blog.php?user=<?php echo $current_user_id; ?>" method="post">
			Content:<br><br>
			<textarea name="content" rows="20" cols="150"></textarea><br><br>
			<input type="submit" name="submit" value="Post" />
		</form>
		<hr>
		  <div class = "entries">
			<?php 
			$posts = find_all_posts();
			while($post = mysqli_fetch_assoc($posts)) { ?>
			BY: 
			<b><?php 
			    $user = find_user_by_id($post["user_id"]);
				echo $user["username"]; 
			?></b>
			
			<div class="view-content">
			   <?php echo htmlentities($post["content"]); ?><br>
			</div>
			<?php } ?>
		   </div>
		<a href = "logout.php">Logout</a>
	</div>
</div>
<?php include("../includes/layouts/footer.php"); ?>