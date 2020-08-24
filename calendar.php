<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
if (isset($_POST['submit'])) {

}

?>

<?php

$month = [
    '0' => 'thang 1',
    '1' => 'thang 2',
    '2' => 'thang 3',
    '3' => 'thang 4',
    '4' => 'thang 5',
    '5' => 'thang 6',
    '6' => 'thang 7',
    '7' => 'thang 8',
    '8' => 'thang 9',
    '9' => 'thang 10',
    '10' => 'thang 11',
    '11' => 'thang 12'
];

$day = range(1, 31);
$years = range(2012, 2020);
?>
<?php
function buildForm($val)
{
    foreach ($val as $key => $value) {
        echo "<option value='{$key}'>{$value}</option>";
    }
}

?>
<form action="" method="post">
    <select name="day" id="">
        <option value=""> chon ngay</option>

        <?php
        buildForm($day);
        ?>
    </select>
    <select name="month" id="">
        <option value=""> chon thang</option>

        <?php buildForm($month)
        ?>
    </select>
    <select name="year" id="">
        <option value=""> chon nam</option>

        <?php buildForm($years);
        ?>
    </select>
    <select name="gender" id="">
        <option value="0">nu</option>
        <option value="1">nam</option>
    </select>
    <input type="submit" name="submit">
</form>
</body>
</html>

