<?php
    session_start();
    $category = $_POST['category'];

    $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8","root","");

    $sql = "INSERT into category (name) values ('$category')";

    $conn->exec($sql);
    $conn = null;
    $_SESSION['cat_add_save'] = 'done';
    header("location: category.php");
?>