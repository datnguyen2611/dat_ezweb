<?php
include('includes/mysqli_connect.php');
include('includes/functions.php');


if (isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
    $pid = $_GET['pid'];
    $q = "SELECT p.page_name,p.id, p.content AS content,
             DATE_FORMAT(p.post_on ,'%b %d %y') AS date,
             CONCAT_WS(' ', u.first_name,u.last_name) AS name,p.user_id
             FROM pages AS p
             INNER JOIN users AS u
             ON u.id = p.user_id  
             WHERE  p.id = {$pid}
             ORDER BY date  ASC LIMIT 1 ";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    $posts = [];
    if (mysqli_num_rows($r) > 0) {
        $page = mysqli_fetch_array($r, MYSQLI_ASSOC);
        $title = "{$page['page_name']}";
        $posts[] = [
            'name' => $page['page_name'],
            'content' => $page['content'],
            'author' => $page['name'],
            'post_on' => $page['date'],
            'user_id' => $page['user_id']
        ];
    } else {
        echo " No page curent";
    }
} else {
    redirect_to();
}
include('includes/header.php');
include('includes/sidebar-a.php');
 ?>
<div id="content">
    <?php
    foreach ($posts as $post) {
        echo "
                <div class='post'>
                        
                    <h2>{$post['name']}</h2>
                    <p>".the_content($post['content'])."</p>
                    <p class='meta'><strong>Posted by :</strong>
                     <a href='author.php?aid={$post['user_id']}'>{$post['author']}</a>
                      <strong>On:</strong> 
                      {$post['post_on'] } 
                      </p>
                </div>
                ";
    } //end foreach
    ?>
    <?php include ('includes/comment_form.php')?>
</div>

<?php include('includes/sidebar-b.php'); ?>
<?php include('includes/footer.php'); ?>
