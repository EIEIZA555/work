<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];

    // อัปเดตข้อมูลหมวดหมู่ในฐานข้อมูล
    $sql = "UPDATE category SET name = :name WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':id', $id);
    
    if ($stmt->execute()) {
        // กำหนดข้อความแจ้งเตือนและส่งกลับไปที่หน้าเดิม
        $_SESSION['message'] = "แก้ไขหมวดหมู่เรียบร้อย";
    } else {
        $_SESSION['message'] = "เกิดข้อผิดพลาดในการแก้ไขหมวดหมู่";
    }
    
    // ส่งผู้ใช้กลับไปยังหน้า Categories
    header("Location: category.php");
    exit();
}
?>
