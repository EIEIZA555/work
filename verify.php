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
        <title>Verify</title>
        <?php 
                $l = $_POST['login'];
                $p = $_POST['pwd'];
        ?>     
</head>
<body> 
        <h1 style="text-align: center;">Webboard KakKak</h1>
        <hr>
        <?php 
                if($l == "admin" && $p == "ad1234")
                {
                        $_SESSION['username']= "admin";
                        $_SESSION['role']="a";
                        $_SESSION['id']=session_id();
                        echo "<p style='text-align: center;'>ยินดีต้อนรับคุณ ADMIN</p>";
                }
                else if($l == "member" && $p == "mem1234")
                {
                        $_SESSION['username']= "member";
                        $_SESSION['role']="m";
                        $_SESSION['id']=session_id();
                        echo "<p style='text-align: center;'>ยินดีต้อนรับคุณ MEMBER</p>";
                }
                else
                {
                        echo "<p style='text-align: center;'>ชื่อบัญชีหรือรหัสไม่ถูกต้อง</p>";
                }
        ?>
        <div align='center'><a href='index.php'>กลับไปหน้าหลัก</a></div>
        
        
</body>
</html>