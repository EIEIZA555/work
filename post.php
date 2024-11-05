<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div align = "center">
        <?php
            $num = $_GET['id'];
            $conn=new PDO("mysql:host=localhost;dbname=webboard;charset=utf8","root", "");
            $sql = "SELECT t1.title,t1.id,t2.login,t1.post_date,t1.content From post as t1 
                Inner Join user as t2 ON (t1.user_id=t2.id) where t1.id=$num";
            $result=$conn->query($sql);
            while($row = $result->fetch()){
                $head = $row[0];
                $content = "$row[4]<br>$row[2] - $row[3]";
            }
            $conn=null;
        ?>
        </div>
        <div class="container-fluid mt-3 ">
            
        <center>
    <h1>Stardew Valley Webboard</h1>
    </center>
    <?php
            include "nav.php"
    ?>
        <div class="card text-dark bg-white border-primary mx-auto mt-4" style="width: 60%;">
            <div class="card-header bg-primary text-white"><?php echo $head; ?></div>
            <div class="card-body">
                <?php echo $content; ?>
            </div>
        </div>
        <br>
            <?php
                $conn=new PDO("mysql:host=localhost;dbname=webboard;charset=utf8","root", "");
                $sql="SELECT t1.content,t2.login,t1.post_date,t2.role From comment as t1
                Inner Join user as t2 ON (t1.user_id=t2.id) where t1.post_id=$num ORDER BY t1.post_date ASC";
                $result=$conn->query($sql);
                $i = 0;
                while($row = $result->fetch()){
                    if ($row[3] != 'b'){
                        $i++;
                        echo "<div class='card text-dark bg-white border-info mx-auto' style='width: 60%;'>
                        <div class='card-header bg-info text-white'>ความคิดเห็นที่ $i</div>
                        <div class='card-body'>
                        $row[0] <br>$row[1]- $row[2]
                        </div>
                        </div><br>";
                    }
                }
                $conn=null;
                if (isset($_SESSION['id']) && $_SESSION['role'] != 'b'){
                    echo "<div class='card text-dark bg-white border-success mx-auto' style='width: 60%;'>
                            <div class='card-header bg-success text-white'>แสดงความคิดเห็น</div>
                            <div class='card-body'>
                                <form action='post_save.php' method='post'>
                                    <input type='hidden' name='post_id' value=$num>
                                    <div class='row mb-3 justify-content-center'>
                                        <div class='col-lg-10'>
                                            <textarea name='comment' class='form-control' rows='8'></textarea>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-lg-12'>
                                            <center>
                                                <button type='submit' class='btn btn-success btn-sm text-white'><i class='bi bi-box-arrow-up-right me-1'>ส่งข้อความ</i></button>
                                            </center>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>";
                }
        ?>
    </div>
</body>
</html>