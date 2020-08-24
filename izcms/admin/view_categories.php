<?php include('../includes/header.php'); ?>
<?php include('../includes/mysqli_connect.php'); ?>
<?php include('../includes/functions.php'); ?>
<?php include('../includes/sidebar-admin.php'); ?>

<div id="content">
    <h2>task manager category </h2>
    <table>
        <thead>
        <tr>
            <th>
                <a href="view_categories.php?sort=cat">Categories</a>
            </th>
            <th>
                <a href="view_categories.php?sort=pos">Position</a>
            </th>
            <th>
                <a href="view_categories.php?sort=by"> Posted By</a>
            </th>
        </tr>
        </thead>

        <?php

        if (isset($_GET['sort'])){
            switch ($_GET['sort']){
                case 'cat':
                    $order_by ='name';
                    break;
                case 'pos':
                    $order_by = 'position';
                    break;
                case 'by':
                    $order_by = 'names';
                    break;
                default:
                    $order_by = 'position';
                    break;
            }
//            end switch
        }else{
            $order_by = 'position';
        }

//        sort by
        $q = "SELECT c.id,c.name, c.position , c.user_id ,CONCAT_WS(' ',first_name,last_name) AS names
         FROM  categories AS c  JOIN users AS u  ON u.id = c.user_id ORDER BY {$order_by} ASC ";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
        while ($cats = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
//            print_r($cats);
//            die();
            echo "<tr>       
        <td>{$cats['name']}</td>
        <td>{$cats['position']}</td>
        <td>{$cats['names']}</td>
        <td><a href=\"edit_category.php?cid={$cats['id']}\" class='edit'>Edit</a></td>
        <td><a href=\"delete_category.php?cid={$cats['id']}&name={$cats['name']}\">Delete</a></td>
        </tr>";
        } ?>
        <tbody>

        </tbody>
    </table>
</div>


<?php include('../includes/sidebar-b.php'); ?>
<?php include('../includes/footer.php'); ?>
