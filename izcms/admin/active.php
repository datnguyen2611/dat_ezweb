<?php
$title = 'active';
include('../includes/header.php');
include('../includes/mysqli_connect.php');
include('../includes/functions.php');
include('../includes/sidebar-a.php'); ?>

<div id="content">
	<?php

	if (isset($_GET['x'],$_GET['y']) && filter_var($_GET['x'],FILTER_VALIDATE_EMAIL) && strlen($_GET['y']) == 32){
			$e = mysqli_real_escape_string($dbc, $_GET['x']);
			$a = mysqli_real_escape_string($dbc, $_GET['y']);
			$q = "UPDATE users SET active = NULL WHERE  email = '{$e}' AND active = '{$a}' LIMIT 1";
			$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);
			if (mysqli_affected_rows($dbc) == 1){
				echo "<p class='success'>your account has been actived <a href='".BASE_URL."login.php'>click here</a> to login</p>";
			}else{
				echo "<p class='warning'> We got some errors here please try again";
			}
	}else{
		redirect_to();
	}
	?>
</div>

<?php include('../includes/sidebar-b.php'); ?>
<?php include('../includes/footer.php'); ?>
