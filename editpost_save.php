<?php
session_start();

$topic = $_POST['topic'];
$comment = $_POST['comment'];
$category = $_POST['category'];

$conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");

$id = $_SESSION['user_id'];


$sql = "UPDATE post SET title='$topic',content='$comment',post_date=Now(),cat_id='$category' WHERE user_id = '$id')";

$conn->exec($sql);

$conn = null;
header("location:index.php");
