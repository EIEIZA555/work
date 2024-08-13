<?php 
session_start();
$i = $_GET['id'];
if(isset($_SESSION['id']) && $_SESSION['role']=='a')
    {
        echo "<p>ลบกระทู้หมายเลข $i</p>";
    }
else 
    {
        header("location:index.php");
        die();
    }
?>
