<?php include('includes/header.php'); ?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/functions.php'); ?>
<?php include('includes/sidebar-a.php'); ?>

<div id="content">
    <?php
    if (isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
        $pid = $_GET['pid'];
        $q = "SELECT p.page_name,p.id, LEFT(p.content, 400) AS content,
             DATE_FORMAT(p.post_on ,'%b %d %y') AS date,
             CONCAT_WS(' ', u.first_name,u.last_name) AS name,p.user_id
             FROM pages AS p
             INNER JOIN users AS u
             ON u.id = p.user_id  
             WHERE  p.id = {$pid}
             ORDER BY date  ASC LIMIT 0,10 ";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
        if (mysqli_num_rows($r) > 0) {
            while ($page = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                echo "
                <div class='post'>
                        
                    <h2><a href='single.php?pid={$page['id']}'>{$page['page_name']}</a></h2>
                    <p>".the_excerpt($page['content'])." .. .<a href='single.php?pid={$page['id']}'>Read more</a></p>
                    <p class='meta'><strong>Posted by :</strong> {$page['name']} <strong>On:</strong> {$page['date']}  </p>
                </div>
                ";
            }
        }else{{
            echo " No page curent </br>";
            echo "<a href='index.php' class='success' type='submit'> back to home Page </a> ";
        }}
    }
    ?>
</div>

<?php include('includes/sidebar-b.php'); ?>
<?php include('includes/footer.php'); ?>
