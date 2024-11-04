<?php
session_start();
$id = $_POST['cat_id'];
$category = $_POST['category'];

$conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");
$sql = "SELECT name FROM category WHERE name = '$category'";
$count = $conn->query($sql)->fetchColumn();
if ($count == 0) {
    $sql = "UPDATE category Set name='$category' Where id='$id'";
    $conn->exec($sql);
    $_SESSION['cat_edit_save'] = 'done';
}else {
    $_SESSION['cat_edit_save'] = 'exists'; // กรณีมีหมวดหมู่นี้แล้ว
}
$conn = null;
header("location: category.php");
?>