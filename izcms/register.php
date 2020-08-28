<?php
$title = 'Register';
include('includes/header.php');
include('includes/mysqli_connect.php');
include('includes/functions.php');
include('includes/sidebar-a.php'); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$errors = [];


	//xd cac du lieuj laf ja
	$fn = $ln = $e = $p = false;
	if (preg_match('/^[\w\'.-]{2,20}$/i', trim($_POST['first_name']))) {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
	} else {
		$errors[] = 'first name';
	}
	if (preg_match('/^[\w\'.-]{2,20}$/i', trim($_POST['last_name']))) {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	} else {
		$errors[] = 'last name';
	}
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$e = mysqli_real_escape_string($dbc, $_POST['email']);
	} else {
		$errors[] = 'email';
	}
	if (preg_match('/^[\w\'.-]{6,20}$/', $_POST['password1'])) {
		if ($_POST['password1'] == $_POST['password2']) {
			$p = mysqli_real_escape_string($dbc, trim($_POST['password1']));
		} else {
			$errors[] = 'password not match';
		}
	} else {
		$errors[] = 'password';
	}
	if ($fn && $ln && $e && $p) {


		$q = "SELECT id FROM users WHERE  email = '{$e}'";
		$r = mysqli_query($dbc, $q);
		confirm_query($r, $q);

		if (mysqli_num_rows($r) == 0) {
			$a = md5(uniqid(rand(), true));
			// insert

			$q = "INSERT INTO users (first_name,last_name,email,password, active , register_date) VALUES ('{$fn}','{$ln}','{$e}',SHA1('$p'),'{$a}',NOW())";
			$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);
			if (mysqli_affected_rows($dbc)) {
				$body = BASE_URL."admin/active.php?x=".urlencode($e)."&y={$a}";
				echo "<br>Thanks for register here is your account click here to active :</br><a class='success' href='{$body}'> {$body}</a></p>";
			} else {
					$message = "<p class='warning'> The email  was already used</p>";
			}
			//check email xem co hay khong , k thi cho phep dang ki
		} else {
				$message =  "<p class='warning'>please fill all required </p>";
		}
	} else {

	}
}
?>
<div id="content">
    <h2>Register</h2>
	<?php if (!empty($message)) echo $message; ?>
    <form action="register.php" method="POST">
        <fieldset>
            <legend>Register</legend>
            <div>
                <label for="First Name">First Name <span class="required">*</span>
					<?php if (isset($errors) && in_array('first name',
							$errors)) echo "<span class='warning'>Please enter your first name</span>"; ?>
                </label>
                <input type="text" name="first_name" size="20" maxlength="20"
                       value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" tabindex='1'/>
            </div>

            <div>
                <label for="Last Name">Last Name <span class="required">*</span>
					<?php if (isset($errors) && in_array('last name',
							$errors)) echo "<span class='warning'>Please enter your last name</span>"; ?>
                </label>
                <input type="text" name="last_name" size="20" maxlength="40"
                       value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" tabindex='2'/>
            </div>

            <div>
                <label for="email">Email <span class="required">*</span>
					<?php if (isset($errors) && in_array('email',
							$errors)) echo "<span class='warning'>Please enter your valid email</span>"; ?>
                </label>
                <input type="text" name="email" id="email" size="20" maxlength="80"
                       value="<?php if (isset($_POST['email'])) echo htmlentities($_POST['email'], ENT_COMPAT,
					       'UTF-8'); ?>" tabindex='3'/>
                <span id="available"></span>
            </div>

            <div>
                <label for="password">Password <span class="required">*</span>
					<?php if (isset($errors) && in_array('password',
							$errors)) echo "<span class='warning'>Please enter your password</span>"; ?>
                </label>
                <input type="password" name="password1" size="20" maxlength="20"
                       value="<?php if (isset($_POST['password1'])) echo $_POST['password1']; ?>" tabindex='4'/>
            </div>

            <div>
                <label for="email">Confirm Password <span class="required">*</span>
					<?php if (isset($errors) && in_array('password not match',
							$errors)) echo "<span class='warning'>Your confirmed password does not match.</span>"; ?>
                </label>
                <input type="password" name="password2" size="20" maxlength="20"
                       value="<?php if (isset($_POST['password12'])) echo $_POST['password2']; ?>" tabindex='5'/>
            </div>
        </fieldset>
        <p><input type="submit" name="submit" value="Register"/></p>
    </form>

</div>

<?php include('includes/sidebar-b.php'); ?>
<?php include('includes/footer.php'); ?>
