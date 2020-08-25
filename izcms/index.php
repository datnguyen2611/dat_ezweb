<?php include('includes/header.php'); ?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/functions.php'); ?>
<?php include('includes/sidebar-a.php'); ?>

<div id="content">
    <?php
    if (isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
        $cid = $_GET['cid'];
        $q = "SELECT p.page_name,p.id, LEFT(p.content, 400) AS content,
             DATE_FORMAT(p.post_on ,'%b %d %y') AS date,
             CONCAT_WS(' ', u.first_name,u.last_name) AS name,p.user_id
             FROM pages AS p
             INNER JOIN users AS u
             ON u.id = p.user_id  
             WHERE  p.id = {$cid}
             ORDER BY date  ASC LIMIT 0,10 ";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
        if (mysqli_num_rows($r) > 0) {
            while ($page = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                echo "
                <div class='post'>
                        
                    <h2><a href='single.php?pid={$page['id']}'>{$page['page_name']}</a></h2>
                    <p>" . the_excerpt($page['content']) . " .. .<a href='single.php?pid={$page['id']}'>Read more</a></p>
                   <p class='meta'><strong>Posted by :</strong><a href='author.php?aid={$page['id']}'>{$page['name']}</a>
                      <strong>On:</strong> {$page['date']}  </p>
                </div>
                ";
            }
        } else {
            echo " No page curent </br>";
            echo "<a href='index.php' class='success' type='submit'> back to home Page </a> ";
        }
    } elseif (isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
        $pid = $_GET['pid'];
        $q = "SELECT P.page_name,p.content , DATE_FORMAT(p.post_on , '%b %d %y') AS date,
        CONCAT_WS(' ' ,u.first_name,u.last_name) AS name,u.id, COUNT(c.id) AS count
        FROM users AS u INNER JOIN pages  AS p  ON u.id = p.user_id LEFT JOIN  comments AS c 
        ON p.id = c.page_id    
        WHERE  p.id = {$pid}  GROUP  BY p.page_name ORDER BY date ASC";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
        if (mysqli_num_rows($r) > 0) {
            while ($page = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                echo "
                <div class='post'>
                        
                    <h2><a href='single.php?pid={$pid}'>{$page['page_name']}</a></h2>
                    <p class='comments'><a href='single.php?pid={$pid}#disscuss'>{$page['count']}</a></p>
                    <p>" . the_excerpt($page['content']) . " .. .<a href='single.php?pid={$pid}'>Read more</a></p>
                    <p class='meta'><strong>Posted by :</strong><a href='author.php?aid={$page['id']}'>{$page['name']}</a>
                      <strong>On:</strong> {$page['date']}  </p>
                </div>
                ";
            }
        } else {
            echo " No page curent </br>";
            echo "<a href='index.php' class='success' type='submit'> back to home Page </a> ";
        }
    }
    else{
    ?>


    <h2>Welcome To izCMS</h2>
    <div>
        <p>
            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum
            tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas
            semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque
            egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan
            porttitor, facilisis luctus, metus
        </p>

        <p>
            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum
            tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas
            semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque
            egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan
            porttitor, facilisis luctus, metus
        </p>

        <p>
            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum
            tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas
            semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque
            egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan
            porttitor, facilisis luctus, metus
        </p>

        <p>
            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum
            tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas
            semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque
            egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan
            porttitor, facilisis luctus, metus
        </p>

        <p>
            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum
            tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas
            semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque
            egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan
            porttitor, facilisis luctus, metus
        </p>

        <p>
            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum
            tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas
            semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque
            egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan
            porttitor, facilisis luctus, metus
        </p>
    </div>
</div>
<?php } ?>
<?php include('includes/sidebar-b.php'); ?>
<?php include('includes/footer.php'); ?>
