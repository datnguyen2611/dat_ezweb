<?php
if (isset($_POST['submit'])){
    if ($_POST['gender'] ==0){
        echo " you are women";
    }
    else{
        echo "you are man";
    }
}
?>

<form action="" method="post">
    <select name="gender" id="">
        <option value="0">nu</option>
        <option value="1">nam</option>
    </select>
    <input type="submit" name="submit">
</form>

<!--stament-->


<?php
$img = "abcd.jpg";
$lenght = strlen($img);
$allows = ['jpg','png','gif'];
$split  = explode('.',$img);
$end  = end($split);
if (in_array($end,$allows)){
echo 'allow';
}
?>
<!--logic stament-->
