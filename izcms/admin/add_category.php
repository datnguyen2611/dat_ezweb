<?php include('../includes/header.php'); ?>
<?php include('../includes/mysqli_connect.php'); ?>
<?php include('../includes/functions.php'); ?>
<?php include('../includes/sidebar-admin.php'); ?>

    <div id="content">
		<?php
		admin_access();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$errors = [];
			if (empty($_POST['category'])) {
				$errors[] = "category";
			} else {
				$ca_name = mysqli_real_escape_string($dbc, strip_tags($_POST['category']));
			}
			if (isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, ['min_range' => 1])) {
				$position = $_POST['position'];
			} else {
				$errors[] = "position";
			}
			if (empty($errors)) {
				$q = "INSERT INTO categories (user_id,name,position ) 
            value (1,'{$ca_name}',$position)";

				$r = mysqli_query($dbc, $q) or die(query($q));
				if (mysqli_affected_rows($dbc) == 1) {
					$message = "<p class='success'> The category was successfully";
				} else {
					$message = "<p class = 'warning'> Cound not add in to database</p>";
				}
			} else {
				echo ' fill it';
			}
		}
		?>
		<?php if (!empty($message)) {
			echo $message;
		} ?>
        <form id="add_cat" action="" method="post">
            <fieldset> Add category</fieldset>

            <div>
                <label for=""> category name:</label>
				<?php if (isset($errors) && in_array('category', $errors)) {
					echo "<p class='warning'>fill the category name";
				} ?>
                <input type="text" name="category" id="category" value="<?php
				if (isset($_POST['category'])) echo strip_tags($_POST['category']);
				?>">
            </div>
            <div>
                <label for=""> category position:</label>
				<?php if (isset($errors) && in_array('position', $errors)) {
					echo "<p class='warning'>fill the position";
				} ?>
                <select name="position" id="">
					<?php
					$q = " SELECT count(id) FROM categories";
					$r = mysqli_query($dbc, $q) or die(query($q));

					if (mysqli_num_rows($r) == 1) {
						list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
					}

					for ($i = 1; $i <= $num; $i++) {
						echo "<option value='{$i}'";
						if (isset($_POST['position']) && $_POST['position'] == $i) echo "selected = 'selected'";
						echo ">" . $i . " </option>";
					}
					?>
                </select>
            </div>
            <div>

                <input type="submit" name="submit" value="Add category">
            </div>
        </form>

    </div>
<?php include('../includes/sidebar-b.php'); ?>
<?php include('../includes/footer.php'); ?>