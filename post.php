<?php
session_start();
if (!isset($_SESSION['id'])) {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <h1 style="text-align: center;">Webboard YaiMakMak</h1>
    <div class="container-lg">
            <?php 
                $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8","root","");
                $sql = "SELECT post.title,post.content,user.login,post.post_date from post inner join user on (post.user_id=user.id) where post.id=$_GET[id]";
                $result = $conn->query($sql);
                while($row = $result->fetch()){
                    echo "<div class='card border-primary mt-3'> ";
                    echo "<div class='card-header bg-primary text-white'>$row[0]</div>";
                    echo "<div class='card-body'>$row[1]";
                    echo "<div class='mt-2'>$row[2]- $row[3]</div></div></div>";
            }
            $conn=null;            
            ?>
            <?php 
                $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8","root","");
                $sql = "SELECT comment.content,user.login,comment.post_date from comment inner join user on (comment.user_id=user.id) where comment.post_id=$_GET[id] order by comment.post_date ASC";
                $result = $conn->query($sql);
                $i=1;
                while($row = $result->fetch()){
                    echo "<div class='card border-info mt-3'> ";
                    echo "<div class='card-header bg-info text-white'>ความคิดเห็นที่ $i</div>";
                    echo "<div class='card-body'>$row[0]";
                    echo "<div class='mt-2'>$row[1]- $row[2]</div></div></div>";
                    $i+=1;
            }
            $conn=null;            
            ?>
        <div class="card text-dark bg-white border-success mt-3">
            <div class="card-header bg-success text-white">แสดงความคิดเห็น</div>
            <div class="card-body">
                <form action="post_save.php" method="post">
                    <input type="hidden" name="post_id" value="<?= $_GET['id']; ?>">
                    <div class="row mb-3 justify-content-center">
                        <div class="col-lg-10">
                            <textarea name="comment" class="form-control" rows="8"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <center>
                                <button type="submit" class="btn btn-success btn-sm text-white">
                                    <i class="bi bi-box-arrow-up-right me-1"></i>ส่งข้อความ</button>
                                </button>
                            </center>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <div align='center'><a href='index.php'>กลับไปหน้าหลัก</a></div>
</body>

</html>