<?php $title = 'Retrieve Password';
include('includes/header.php'); ?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/functions.php'); ?>
<?php include('includes/sidebar-a.php'); ?>
<div id="content">
	<?php

	if (isset($_SERVER['REQUEST_METHOD']) == 'POST') {
		$errors = [];
		$uid = false;
		if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$e = mysqli_real_escape_string($dbc, $_POST['email']);
			$q = "SELECT id  FROM users WHERE  email = '{$e}'";
			$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);
			if (mysqli_num_rows($r) == 1) {
				list($uid) = mysqli_fetch_array($r, MYSQLI_NUM);
			}
		} else {
			$errors[] = "<p> please fill your email </p>";
		}
		if ($uid) {
			$temp_pass = substr(md5(uniqid(rand(), true)), 3, 10);
			$q = "UPDATE users SET password = SHA1('$temp_pass') WHERE id = {$uid} LIMIT 1";
			$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);
			if (mysqli_affected_rows($dbc) == 1) {
				$errors[] = "You change password successfully here is your password : {$temp_pass}
				</br>Now you can login then change your password <a href='" . BASE_URL . "login.php'>Go to login</a>";
			} else {
				$errors[] = "sorry! Something was wrong please try again later";
			}
		} else {
			$errors[] = " Sorry we can't find your email ";
		}
	}
	?>

    <form id="login" action="" method="post">
		<?php
		if (isset($errors)) {
			foreach ($errors as $error) {
				echo $error;
			}
		}
		?>
        <fieldset>
            <legend>Retrieve Password</legend>
            <div>
                <label for="email">Email: </label>

                <input type="text" name="email" id="email" value="<?php if (isset($_POST['email'])) {
					echo htmlentities($_POST['email']);
				} ?>" size="40" maxlength="80" tabindex="1"/>
            </div>
        </fieldset>
        <div><input type="submit" name="submit" value="Retrieve Password"/></div>
    </form>
</div><!--end content-->
<?php include('includes/sidebar-b.php'); ?>
<?php include('includes/footer.php'); ?>

