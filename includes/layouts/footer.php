	<div id="footer">
		Copyright <?php echo date("Y"); ?>, SwiftIntern
	</div>
  </body>
</html>
<?php
if(isset($connection)) {
mysqli_close($connection);
}
?>