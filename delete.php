<?php 
session_start();
$i = $_GET['id'];
if(isset($_SESSION['id']) && $_SESSION['role']=='a')
    {
        $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");
        $sql="DELETE FROM post where id=$_GET[id]";
        $result= $conn->query($sql);
        $sql="DELETE FROM comment where post_id=$_GET[id]";
        $result= $conn->query($sql);
        $conn = null;
        header("location:index.php");
    }
else 
    {
        header("location:index.php");
        die();
    }
?>
