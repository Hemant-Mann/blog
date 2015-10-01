<?php 
require_once("../includes/session.php");
require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php include("../includes/layouts/header.php"); ?>
<div id = "main">
   <div id ="page">
   <?php echo message();  ?>
	<br><h2>Welcome to the SwiftIntern Blog!</h2><br>	
	
	New Member:
	<a href="<?php echo PROJECT; ?>signup">Sign Up</a><br><br>
	
	Already a Member:
	<a href="<?php echo PROJECT; ?>login">Login</a>
   </div>
</div>


<?php include("../includes/layouts/footer.php"); ?>