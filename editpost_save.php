<?php
    session_start();
    $category = $_POST['category'];
    $topic = $_POST['topic'];
    $content = $_POST['content'];
    $post_id = $_POST['post_id'];

    $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8","root","");

    $sql = "UPDATE post Set cat_id='$category',title='$topic',content='$content' Where id='$post_id'";

    $conn->exec($sql);
    $conn = null;
    $_SESSION['edit_success'] = 'done';
    header("location: editpost.php?id=$post_id");
?>