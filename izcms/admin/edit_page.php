<?php include('../includes/header.php'); ?>
<?php include('../includes/mysqli_connect.php'); ?>
<?php include('../includes/functions.php'); ?>
<?php include('../includes/sidebar-admin.php'); ?>
<?php
admin_access();
if (isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, ['min_range' => 1])) {
	$pid = $_GET['pid'];
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$errors = [];

		if (empty($_POST['page_name'])) {
			$errors[] = 'potision';
		} else {
			$page_name = mysqli_real_escape_string($dbc, strip_tags($_POST['page_name']));
		}
		if (isset($_POST['category']) && filter_var($_POST['category'], FILTER_VALIDATE_INT, ['min_range' => 1])) {
			$cat_id = $_POST['category'];
		} else {
			$errors[] = "category";
		}
		if (isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, ['min_range' => 1])) {
			$position_id = $_POST['position'];
		} else {
			$errors[] = "position";
		}

		if (empty($_POST['content'])) {
			$errors[] = 'content';
		} else {
			$content = mysqli_real_escape_string($dbc, strip_tags($_POST['content']));
		}

//    check condition submit

		if (empty($errors)) {
			$q = "UPDATE pages SET page_name = '{$page_name}',
                    category_id = {$cat_id},
                    position  = {$position_id},
                    content = '{$content}',
                    user_id = 1,
                    post_on = NOW()
                    WHERE id = {$pid} LIMIT 1";
			$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);

			if (mysqli_affected_rows($dbc) == 1) {
				$message = "<p class='success'> The category was successfully";
			} else {
				$message = "<p class = 'warning'> Cound not edit in to database</p>";
			}
		} else {
			$message = "<p class = 'warning'>fill all request</p>";
		}
	}
} else {
	redirect_to('admin/view_pages.php');
}
?>
    <div id="content">

		<?php
		$q = "SELECT * FROM pages WHERE id = {$pid}";
		$r = mysqli_query($dbc, $q);
		confirm_query($r, $q);
		if (mysqli_num_rows($r) == 1) {
			$page = mysqli_fetch_array($r, MYSQLI_ASSOC);
		} else {
			$message = "your page is not exist";
		}
		?>
		<?php if (!empty($message)) {
			echo $message;
		} ?>
        <legend> Edit a Page : <?php if (isset($page['page_name'])) echo $page['page_name'] ?></legend>
        <form action="" method="post">
            <div>
                <label for="">Page name </label>
                <input type="text" name="page_name" value="
<?php if (isset($page['page_name'])) echo $page['page_name'] ?>">
				<?php if (isset($errors) && in_array('page_name', $errors)) {
					echo "<p class='warning'>fill the page name";
				} ?>
            </div>
            <div>
                <label for=""> All category</label>
                <select name="category" id="">
                    <option value=""> select category</option>

					<?php if (isset($errors) && in_array('category', $errors)) {
						echo "<p class='warning'>fill the category";
					} ?>

					<?php
					$q = "SELECT  id, name FROM categories ORDER BY position ASC ";
					$r = mysqli_query($dbc, $q);
					if (mysqli_num_rows($r) > 0) {
						while ($cats = mysqli_fetch_array($r, MYSQLI_NUM)) {
							echo "<option value='{$cats[0]}'";
							if (isset($page['id']) && $page['id'] == $cats[0]) {
								echo "selected = 'selected'";
							}
							echo ">" . $cats[1] . "</option>";
						}
					}
					?>
                </select>
            </div>
            <div>
                <label for=""> All position</label>
                <select name="position" id="">
                    <option value=""> select position</option>

					<?php if (isset($errors) && in_array('position', $errors)) {
						echo "<p class='warning'>fill the position";
					} ?>

					<?php
					$q = " SELECT count(id) AS count FROM pages";
					$r = mysqli_query($dbc, $q) or die(query($q));

					if (mysqli_num_rows($r) == 1) {
						list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
					}

					for ($i = 1; $i <= $num; $i++) {
						echo "<option value='{$i}'";
						if (isset($page['position']) && $page['position'] == $i) echo "selected = 'selected'";
						echo ">" . $i . " </option>";
					}
					?>
                </select>
            </div>

            <div>
                <label for="">Page Content:</label>
                <textarea name="content" id="" cols="50" rows="20">
                     <?php if (isset($page['content'])) echo htmlentities($page['content'], ENT_COMPAT, 'UTF-8') ?>
                </textarea>
				<?php if (isset($errors) && in_array('content', $errors)) {
					echo "<p class='warning'>fill the content";
				} ?>
            </div>

            <div>
                <input type="submit" name="submit" value="Update ">
            </div>
        </form>
    </div>
<?php include('../includes/sidebar-b.php'); ?>
<?php include('../includes/footer.php'); ?>