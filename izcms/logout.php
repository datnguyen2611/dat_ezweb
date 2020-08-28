<?php $title = 'Logout'; include('includes/header.php');?>
<?php include('includes/mysqli_connect.php');?>
<?php include('includes/functions.php');?>
<?php include('includes/sidebar-a.php'); ?>
<div id="content">
	<?php
		if (!isset($_SESSION['first_name'])){
			redirect_to();
		}else{
			$_SESSION = [];
			session_destroy();
			setcookie(session_name(),'',time() - 3600);
		}
		echo "<h2>	You are now logout</h2>";
	?>
</div><!--end content-->
<?php include('includes/sidebar-b.php');?>
<?php include('includes/footer.php'); ?>

