<?php include('includes/header.php'); ?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/functions.php'); ?>
<?php include('includes/sidebar-a.php'); ?>

<div id="content">
    <?php
    if ($aid = validate_id($_GET['aid'])) {
        $q = "SELECT p.id as page_id , p.page_name,p.content,DATE_FORMAT(p.post_on, '%b %d %y') AS date,
              CONCAT_WS(' ', u.first_name,u.last_name) AS name ,u.id
              FROM pages AS p  JOIN  users AS u ON u.id = p.user_id
              WHERE u.id  = {$aid} ORDER BY date ASC  LIMIT 0,4";
         $r = mysqli_query($dbc,$q);
         confirm_query($r,$q);
         if (mysqli_num_rows($r) > 0){
             while ($author = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                 echo "
                <div class='post'>
                        
                    <h2><a href='single.php?pid={$author['page_id']}'>{$author['page_name']}</a></h2>
                  
                    <p>" . the_excerpt($author['content']) . " .. .<a href='single.php?pid={$author['page_id']}'>Read more</a></p>
                    <p class='meta'><strong>Posted by :</strong><a href='author.php?aid={$author['page_id']}'>{$author['name']}</a>
                      <strong>On:</strong> {$author['date']}  </p>
                </div>
                ";
             }
         }

    } else {
        echo " No page curent </br>";
    }
    ?>
</div>

<?php include('includes/sidebar-b.php'); ?>
<?php include('includes/footer.php'); ?>
