<?php
    session_start();
    $category = $_GET['cat_name'];

    $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8","root","");

    $sql = "DELETE From category Where name='$category'";

    $conn->exec($sql);
    $conn = null;
    $_SESSION['cat_delete_save'] = 'done';
    header("location: category.php");
?>