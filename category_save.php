<?php
session_start();
$category = $_POST['category'];

$conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");

// ตรวจสอบว่าหมวดหมู่มีอยู่ในตารางหรือไม่
$sql = "SELECT name FROM category WHERE name = '$category'";
$count = $conn->query($sql)->fetchColumn();

if ($count == 0) { // ถ้าหมวดหมู่ยังไม่มีในฐานข้อมูล
    $sql = "INSERT INTO category (name) VALUES ('$category')";
    $conn->exec($sql);
    $_SESSION['cat_add_save'] = 'done';
} else {
    $_SESSION['cat_add_save'] = 'exists'; // กรณีมีหมวดหมู่นี้แล้ว
}

$conn = null;
header("Location: category.php");
?>
