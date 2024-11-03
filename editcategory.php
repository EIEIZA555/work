<?php
    session_start();
    $id = $_POST['cat_id'];
    $category = $_POST['category'];

    $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8","root","");

    $sql = "UPDATE category Set name='$category' Where id='$id'";

    $conn->exec($sql);
    $conn = null;
    $_SESSION['cat_edit_save'] = 'done';
    header("location: category.php");
?>