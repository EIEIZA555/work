<?php 
session_start();
if (!isset($_SESSION['id'])){
    header("location:index.php");
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1 style="text-align: center;">Webboard KakKak</h1>
    <hr>
    <table>
        <tr><td >ผู้ใช้ : <?php echo $_SESSION['username'] ?></td></tr>
        <tr><td>หมวดหมู่ :</td><td><select name="category">
            <option value="all">--ทั้งหมด--</option>
            <option value="general">เรื่องทั่วไป</option>
            <option value="study">เรื่องเรียน</option>
        </select></td></td></tr>
        <tr><td>หัวข้อ :&nbsp;<td><input type "text"></td></td></tr>
        <tr><td>เนื้อหา :&nbsp;<td><textarea></textarea></td></td></tr>
        <tr><td colspan="2" align="center">
            <input type="submit" value="บันทึกข้อความ">
        </td></tr>
    </table>
    
    
</body>
</html>