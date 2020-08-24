<?php include('../includes/header.php'); ?>
<?php include('../includes/mysqli_connect.php'); ?>
<?php include('../includes/functions.php'); ?>
<?php include('../includes/sidebar-admin.php'); ?>

<div id="content">
    <h2>task manager Pages </h2>
    <table>
        <thead>
        <tr>
            <th>
                <a href="view_categories.php?sort=pg">Pages</a>
            </th>
            <th>
                <a href="view_categories.php?sort=on">Posted on</a>
            </th>
            <th>
                <a href="view_categories.php?sort=by"> Posted By</a>
            </th>
            <th>
                Content
            </th>
        </tr>
        </thead>

        <?php

        if (isset($_GET['sort'])) {
            switch ($_GET['sort']) {
                case 'pg':
                    $order_by = 'page_name';
                    break;
                case 'pos':
                    $order_by = 'post_on';
                    break;
                default:
                    $order_by = 'post_on';
                    break;
            }
//            end switch
        } else {
            $order_by = 'post_on';
        }

        //        sort by
        $q = "SELECT p.id,p.page_name ,DATE_FORMAT(p.post_on,'%b %d %y') AS date,p.content ,
                CONCAT_WS(' ',first_name,last_name) AS names
         FROM  pages AS p  JOIN users AS u  ON u.id = p.user_id ORDER BY {$order_by} ASC ";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
        if (mysqli_num_rows($r) >0){
            while ($pages = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                echo "<tr>       
        <td>{$pages['page_name']}</td>
        <td>{$pages['date']}</td>
        <td>{$pages['content']}</td>
        <td><a href=\"edit_page.php?pid={$pages['id']}\" class='edit'>Edit</a></td>
        <td><a href=\"delete_page.php?pid={$pages['id']}&pname={$pages['page_name']}\">Delete</a></td>
        </tr>";
            }
        }else{
            echo "<p class='warning'> something was wrong pls check your code</p>";
        }
         ?>
        <tbody>

        </tbody>
    </table>
</div>


<?php include('../includes/sidebar-b.php'); ?>
<?php include('../includes/footer.php'); ?>
