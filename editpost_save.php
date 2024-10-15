<?php
session_start();

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ตรวจสอบว่ามีข้อมูลส่งมา
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ดึงข้อมูลจากฟอร์ม
    $topic = $_POST['topic'];
    $comment = $_POST['comment'];
    $category = $_POST['category'];
    $post_id = $_POST['post_id'];  // ID ของโพสต์ที่ต้องการแก้ไข

    // เชื่อมต่อฐานข้อมูล
    $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");

    // เปิดใช้งาน error mode เพื่อให้แสดงข้อผิดพลาด
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // สร้าง SQL แบบ prepared statement
    $sql = "UPDATE post 
            SET title = :title, content = :content, post_date = NOW(), cat_id = :category 
            WHERE id = :post_id AND user_id = :user_id";

    $stmt = $conn->prepare($sql);

    // ผูกค่าเข้ากับ placeholders
    $stmt->bindParam(':title', $topic);
    $stmt->bindParam(':content', $comment);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);

    // ดำเนินการคำสั่ง SQL
    if ($stmt->execute()) {
        header("Location: index.php"); // ถ้าอัปเดตสำเร็จให้ไปหน้า index.php
        exit();
    } else {
        echo "เกิดข้อผิดพลาด ไม่สามารถแก้ไขโพสต์ได้";
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn = null;
} else {
    header("Location: index.php"); // ถ้าไม่ใช่ POST method ให้กลับไปหน้า index.php
    exit();
}
?>
