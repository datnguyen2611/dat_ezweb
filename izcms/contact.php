<?php
$title = 'contact Us';
include('includes/header.php');
include('includes/mysqli_connect.php');
include('includes/functions.php');
include('includes/sidebar-a.php'); ?>

<div id="content">

	<?php
	ini_set("SMTP","ssl://smtp.gmail.com");
	ini_set("smtp_port","465");
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$errors = [];
		if (empty($_POST['name'])) {
			$errors[] = 'name';
		}
		if (!preg_match('/^[\w.-]+@[\w.-]+\.[a-zA-z]{2,6}$/', $_POST['email'])) {
			$errors[] = 'email';
		}
		if (empty($_POST['comment'])) {
			$errors[] = 'comment';
		}
		if (empty($errors)) {
			$body = "Name: {$_POST['name']}\n\n comment:\n";
			$body = wordwrap($body,70);
		}
		if (mail('datnguyen26111997@gmail.com', 'contract submit form', $body, 'FROM: localhost@localhost')) {
			echo 'success';
		} else {
			echo 'fail';
		}

	}
	?>

    <form id="contact" action="" method="post">
        <fieldset>
            <legend>Contact</legend>
            <div>
                <label for="Name">Your Name: <span class="required">*</span>
					<?php if (isset($errors) && in_array('name', $errors)) {
						echo "<span class='warning'>Please enter your name.</span>";
					} ?>
                </label>
                <input type="text" name="name" id="name" value="<?php if (isset($_POST['name'])) {
					echo htmlentities($_POST['name'], ENT_COMPAT, 'UTF-8');
				} ?>" size="20" maxlength="80" tabindex="1"/>
            </div>
            <div>
                <label for="email">Email: <span class="required">*</span>
					<?php if (isset($errors) && in_array('email', $errors)) {
						echo "<span class='warning'>Please enter your email.</span>";
					} ?>
                </label>
                <input type="text" name="email" id="email" value="<?php if (isset($_POST['email'])) {
					echo htmlentities($_POST['email'], ENT_COMPAT, 'UTF-8');
				} ?>" size="20" maxlength="80" tabindex="2"/>
            </div>
            <div>
                <label for="comment">Your Message: <span class="required">*</span>
					<?php if (isset($errors) && in_array('comment', $errors)) {
						echo "<span class='warning'>Please enter your message.</span>";
					} ?>
                </label>
                <div id="comment"><textarea name="comment" rows="10" cols="45"
                                            tabindex="3"><?php if (isset($_POST['comment'])) {
							echo htmlentities($_POST['comment'], ENT_COMPAT, 'UTF-8');
						} ?></textarea></div>
            </div>

            <div>
                <label for="captcha">Phiền bạn điền vào giá trị số cho câu hỏi sau: <?php echo captcha(); ?><span
                            class="required">*</span>
					<?php if (isset($errors) && in_array('wrong', $errors)) {
						echo "<span class='warning'>Please give a correct answer.</span>";
					} ?></label>
                <input type="text" name="captcha" id="captcha" value="" size="20" maxlength="5" tabindex="4"/>
            </div>

            <div class='website'>
                <label for="website"> Nếu bạn nhìn thấy trường này, thì ĐỪNG điền gì vào hết</label>
                <input type="text" name="url" id="url" value="" size="20" maxlength="20"/>
            </div>
        </fieldset>
        <div><input type="submit" name="submit" value="Send Email" tabindex="3"/></div>
    </form>

</div>

<?php include('includes/sidebar-b.php'); ?>
<?php include('includes/footer.php'); ?>
