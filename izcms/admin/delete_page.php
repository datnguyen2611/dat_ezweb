<?php include('../includes/header.php'); ?>
<?php include('../includes/mysqli_connect.php'); ?>
<?php include('../includes/functions.php'); ?>
<?php include('../includes/sidebar-admin.php'); ?>

<div id="content">

    <?php


    if (isset($_GET['pid'], $_GET['pname']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
        $pid = $_GET['pid'];
        $name = $_GET['pname'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['delete']) == 'POST' && $_POST['delete'] == 'yes') {
                $q = "DELETE FROM pages WHERE id  = {$pid} LIMIT 1";
                $r = mysqli_query($dbc, $q);
                confirm_query($r, $q);
                if (mysqli_affected_rows($dbc) == 1) {
                    $message = "<p class='success'> I hope you do the right think</p>";
                } else {
                    $message = "<p class='warning'>system error</p>";
                }
            } else {
                $message = "<p class='warning'>alright</p>";
            }

        }
    } else {
        redirect_to('admin/view_pages.php');
    }
    ?>
    <h2>Delete page </h2>
    <form action="" method="post">
        <fieldset>
            <legend>Delete
                page <?php if (isset($_GET['pname'])) echo htmlentities($name, ENT_COMPAT, 'UTF-8') ?></legend>
            <?php if (!empty($message))echo $message; ?>
        </fieldset>
        <label for="delete"> Are you sure?</label>
        <div>
            <input type="radio" name="delete" value="no" checked="checked">No
            <input type="radio" name="delete" value="yes">Yes
        </div>
        <div><input type="submit" name="submit" value="Delete" onclick="return confirm('Are you sure???')"></div>
    </form>
</div>


<?php include('../includes/sidebar-b.php'); ?>
<?php include('../includes/footer.php'); ?>
