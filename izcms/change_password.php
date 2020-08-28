<?php $title = 'Change password';
include('includes/header.php'); ?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/functions.php'); ?>
<?php include('includes/sidebar-a.php'); ?>
<div id="content">
	<?php
	is_logged_in();

	if (isset($_SERVER['REQUEST_METHOD']) == 'POST') {
		$errors = [];
		if (isset($_POST['cur_password']) && preg_match('/^\w{2,20}$/', trim($_POST['cur_password']))) {
			$cur_password = mysqli_real_escape_string($dbc, trim($_POST['cur_password']));
			$q = "SELECT first_name FROM users WHERE password = SHA1('$cur_password') AND id = {$_SESSION['id']}";
			$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);
			if (mysqli_num_rows($r) == 1) {
				if (isset($_POST['password1']) && preg_match('/^\w{2,20}$/', trim($_POST['password1']))) {

					if ($_POST['password1'] == $_POST['password2']) {
						$np = mysqli_real_escape_string($dbc, $_POST['password1']);
						$q = "UPDATE users SET password = SHA1('$np') WHERE id = {$_SESSION['id']} LIMIT 1";
						$r = mysqli_query($dbc, $q);
						confirm_query($r, $q);
						if (mysqli_affected_rows($dbc) == 1) {
							$errors[] = "<p class='success'> Your password has been update</p>";
						} else {
							$errors[]
								= "<p class='error'>Your query are error please try again</p>";
						}
//								update password
					} else {
						$errors[]
							= "<p class='error'>Password and confirm password is not match ! Please try again</p>";
					}

//					check password 1 == password 2
				} else {
					$errors[]
						= "<p class='error'>your current password is too short or missing . Please  try again</p>";
				}
			} else {
				$errors[] = "<p class='error'>your current password is incorrect .please try again</p>";
			}
		}
	}
	?>
    <h2>Change Password</h2>
	<?php if (isset($message)) echo $message;
	if (isset($errors)) {
		report_error($errors);
	} ?>

    <form action="" method="post">
        <fieldset>
            <legend>Change Password</legend>
            <div>
                <label for="Current Password">Current Password</label>
                <input type="password" name="cur_password" value="" size="20" maxlength="40" tabindex='1'/>
            </div>

            <div>
                <label for="New Password">New Password</label>
                <input type="password" name="password1" value="" size="20" maxlength="40" tabindex='2'/>
            </div>

            <div>
                <label for="Confirm Password">Confirm Password</label>
                <input type="password" name="password2" value="" size="20" maxlength="40" tabindex='3'/>
            </div>
        </fieldset>
        <div><input type="submit" name="submit" value="Update Password" tabindex='4'/></div>
    </form>
</div><!--end content-->
<?php include('includes/sidebar-b.php'); ?>
<?php include('includes/footer.php'); ?>

