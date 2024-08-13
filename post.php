<?php 
session_start();
if (isset($_SESSION['id'])){
    header("location:index.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Post</title>
        <?php 
                $id = $_GET['id'];
                
        ?>     
</head>
<body> 
        <h1 style="text-align: center;">Webboard KakKak</h1>
        <hr>
        <?php 
            if ($id %2 == 0){
                echo "<p style='text-align: center;'>ต้องการดูกระทู้หมายเลข $id <br>เป็นกระทู้หมายเลขคู่</p>";
            }
            else
            {
                echo "<p style='text-align: center;'>ต้องการดูกระทู้หมายเลข $id <br>เป็นกระทู้หมายเลขคี่</p>";
            }
        ?>
        <table style="border: 2px solid black; width: 40%;" align="center">
        <tr><td colspan="2" style="background-color: #6cd2fe;">แสดงความคิดเห็น</td></tr>
        <tr><td><textarea></textarea></td></tr>
        <tr><td colspan="2" align="center">
            <input type="submit" value="ส่งข้อความ">
        </td></tr>
        </table>
        <br>
        <div align='center'><a href='index.php'>กลับไปหน้าหลัก</a></div>
</body>
</html>