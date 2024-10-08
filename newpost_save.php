<?php 
session_start();

$topic = $_POST['topic'];
$comment = $_POST['comment'];
$category = $_POST['category'];

$conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8","root","");

$id = $_SESSION['user_id'];

$sql = "INSERT INTO post (title,content,post_date,cat_id,user_id) VALUES ('$topic','$comment',Now(),'$category','$id')";

$conn->exec($sql);

$conn = null;
header("location:index.php");
?>