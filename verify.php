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
                        header("Location: index.php");
                        die();

                        
                }
                else if($l == "member" && $p == "mem1234")
                {
                        $_SESSION['username']= "member";
                        $_SESSION['role']="m";
                        $_SESSION['id']=session_id();
                        header("Location: index.php");
                        die();

                }
                else {
                        $_SESSION['error']="error";
                        header("Location: login.php");
                        die();
                    }
        ?>
        
        
</body>
</html>