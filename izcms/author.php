<?php include('includes/header.php'); ?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/functions.php'); ?>
<?php include('includes/sidebar-a.php'); ?>

<div id="content">


    <?php
    if ($aid = validate_id($_GET['aid'])) {

        $display = 4;
        if (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min-range' => 1))) {
            $start = $_GET['s'];
        } else {
            $start = 0;
        }
        if (isset($_GET['p']) && filter_var($_GET['p'], FILTER_VALIDATE_INT, array('min-range' => 1))) {
            $page = $_GET['p'];
        } else {
            $q = "SELECT COUNT(id) FROM pages";
            $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);
            list($record) = mysqli_fetch_array($r, MYSQLI_NUM);
            if ($record > $display) {
                $page = ceil($record / $display);
            } else {
                $page = 1;
            }
        }

        //paginate
        $q = "SELECT p.id as page_id , p.page_name,p.content,DATE_FORMAT(p.post_on, '%b %d %y') AS date,
              CONCAT_WS(' ', u.first_name,u.last_name) AS name ,u.id
              FROM pages AS p  JOIN  users AS u ON u.id = p.user_id
              WHERE u.id  = {$aid} ORDER BY date ASC  LIMIT {$start},{$display}";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
        if (mysqli_num_rows($r) > 0) {
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
        redirect_to();
    }
    ?>
    <?php
    //            paginate page

    echo "<ul class='pagination'>";
    if ($page > 1) {
        $current_page = ($start / $display) + 1;
        if ($current_page != 1) {
            echo "<li><a href='author.php?aid={$aid}&s=".($start - $display)."&p={$page}'>Previous</a></li>";
        }
        for ($i = 1; $i <= $page; $i++) {
            if ($i != $current_page) {
                echo "<li><a href='author.php?aid={$aid}&s=".($display*($i - 1))."&p={$page}'>{$i}</a></li>";
            } else {
                echo "<li class='current'>{$i}</li>";
            }
        }

        if ($current_page != $page) {
            echo "<li><a href='author.php?aid={$aid}&s=".($start + $display)."&p={$page}'>Next</a></li>";
        }
    }
echo "</ul>";

    ?>
</div>

<?php include('includes/sidebar-b.php'); ?>
<?php include('includes/footer.php'); ?>
