<?php $title = '';
include('includes/header.php');
include('includes/mysqli_connect.php');
include('includes/functions.php');
include('includes/sidebar-a.php');
is_logged_in();
?>
<?php
// truy xuat du lieu
$user = fetch_user($_SESSION['id']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    // Trim all incoming data
    $trimmed = array_map('trim', $_POST);

    if (preg_match('/^[\w]{2,10}$/i', $trimmed['first_name'])) {
        $fn = $trimmed['first_name'];
    } else {
        $errors[] = "first_name";
    }

    if (preg_match('/^[\w]{2,10}$/i', $trimmed['last_name'])) {
        $ln = $trimmed['last_name'];
    } else {
        $errors[] = "last name";
    }

    if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
        $e = $trimmed['email'];
    } else {
        $errors[] = "email";
    }
    // Check for website (not required)
    $web = (!empty($trimmed['website'])) ? $trimmed['website'] : NULL;

    // Check for yahoo (not required)
    $yahoo = (!empty($trimmed['yahoo'])) ? $trimmed['yahoo'] : NULL;

    // Check for website (not required)
    $bio = (!empty($trimmed['bio'])) ? $trimmed['bio'] : NULL;

    if (empty($errors)) {
        $q = "UPDATE users SET 
                first_name = ?, last_name = ?, email = ?, website = ?, yahoo = ?, bio = ?
                WHERE id = ?
                LIMIT 1";
        $stmt =mysqli_prepare($dbc,$q);
        mysqli_stmt_bind_param($stmt,'ssssssi',$fn,$ln,$e,$web,$yahoo,$bio,$_SESSION['id']);
        mysqli_stmt_execute($stmt) or die("MySQL : $q" . mysqli_stmt_error());
        if (mysqli_stmt_affected_rows($dbc) > 0){
            $message = "<p class='success'> update successfullyy</p>";
        }else{
            $message = "<p class='warning'>Your update has error please try <again></again></p>";
        }
    }
}
?>
<div id="content">
   <?php if (!empty($message))echo $message;?>

    <form enctype="multipart/form-data" action="processor/avatar.php" method="post">
        <fieldset>
            <legend>Avatar</legend>
            <div>
                <img class="avatar"
                     src="uploads/images/<?php echo(is_null($user['avatar']) ? "no_avatar.jpg" : $user['avatar']); ?>"
                     alt="avatar"/>
                <p>Please select a JPEG or PNG image of 512Kb or smaller to use as avatar</p>
                </label>
                <input type="hidden" name="MAX_FILE_SIZE" value="524288"/>
                <input type="file" name="image"/>
                <p><input class="change" type="submit" name="upload" value="Save changes"/></p>
            </div>
        </fieldset>
    </form>

    <form action="" method="post">
        <fieldset>
            <legend>User Info</legend>
            <div>
                <label for="first-name">First Name
                    <?php if (isset($errors) && in_array('first_name', $errors)) echo "<p class='warning'>Please enter your first name.</p>"; ?>
                </label>
                <input type="text" name="first_name"
                       value="<?php if (isset($user['first_name'])) echo strip_tags($user['first_name']); ?>" size="20"
                       maxlength="40" tabindex='1'/>
            </div>

            <div>
                <label for="last-name">Last Name
                    <?php if (isset($errors) && in_array('last name', $errors)) echo "<p class='warning'>Please enter your last name.</p>"; ?>
                </label>
                <input type="text" name="last_name"
                       value="<?php if (isset($user['last_name'])) echo strip_tags($user['last_name']); ?>" size="20"
                       maxlength="40" tabindex='1'/>
            </div>
        </fieldset>
        <fieldset>
            <legend>Contact Info</legend>
            <div>
                <label for="email">Email
                    <?php if (isset($errors) && in_array('email', $errors)) echo "<p class='warning'>Please enter a valid email.</p>"; ?>
                </label>
                <input type="text" name="email" value="<?php if (isset($user['email'])) echo $user['email']; ?>"
                       size="20" maxlength="40" tabindex='3'/>
            </div>

            <div>
                <label for="website">Website</label>
                <input type="text" name="website"
                       value="<?php echo (is_null($user['website'])) ? '' : strip_tags($user['website']); ?>" size="20"
                       maxlength="40" tabindex='4'/>
            </div>

            <div>
                <label for="yahoo">Yahoo Messenger</label>
                <input type="text" name="yahoo"
                       value="<?php echo (is_null($user['yahoo'])) ? '' : strip_tags($user['yahoo']); ?>" size="20"
                       maxlength="40" tabindex='5'/>
            </div>
        </fieldset>
        <fieldset>
            <legend>About Yourself</legend>
            <div>
                <textarea cols="50" rows="20"
                          name="bio"><?php echo (is_null($user['bio'])) ? '' : htmlentities($user['bio'], ENT_COMPAT, 'UTF-8'); ?></textarea>
            </div>
        </fieldset>
        <div><input type="submit" name="submit" value="Save Changes"/></div>
    </form>
</div><!--end content-->
<?php include('includes/sidebar-b.php'); ?>
<?php include('includes/footer.php'); ?>

