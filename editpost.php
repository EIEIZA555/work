<?php
    session_start();
    $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8","root","");
    $id = $_GET['id'];
    $sql = "SELECT id,title,content,cat_id,user_id FROM post where id =$id";
    $result = $conn->query($sql);
    $data=$result->fetch(PDO::FETCH_ASSOC);
    $conn=null;
    if (!isset($_SESSION['id']) || $data['user_id'] != $_SESSION['user_id'])
    {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="container-fluid mt-3">
<center>
        <h1>Stardew Valley Webboard</h1>
    </center>
    <?php
        include "nav.php"
    ?>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 mt-3">
            <?php
                if (isset($_SESSION['edit_success'])){
                    if ($_SESSION['edit_success'] == 'done'){
                        echo "<div class='alert alert-success'>แก้ไขข้อมูลเรียบร้อยแล้ว</div>";
                    }
                    unset($_SESSION['edit_success']);
                }
            ?>
        </div>
    </div>
    <div class=" card text-dark bg-white border-warning mt-4 m-auto" style="max-width: 40rem;">
        <div class=" card-header bg-warning text-white">ตั้งกระทู้ใหม่</div>
        <div class=" card-body">
            <form action="editpost_save.php" method="post">
                <div class="row mb-3">
                    <input type="hidden" name="post_id" value=<?php echo $id ?>>
                    <label class="col-lg-3 col-form-label">หมวดหมู่ :</label>
                    <div class="col-lg-9">
                        <select name="category" class="form-select">
                        <?php
                            $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8","root","");
                            $sql = "SELECT id,name FROM category";
                            foreach($conn->query($sql) as $row){
                                if ($row[0] == $data['cat_id'])
                                {
                                    echo "<option value=".$row[0]." selected>".$row[1]."</option>";
                                }
                                else 
                                {
                                    echo "<option value=".$row[0].">".$row[1]."</option>";
                                }
                            }
                            $conn=null;
                        ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class=" col-lg-3 col-form-label">หัวข้อ :</label>
                    <div class=" col-lg-9">
                        <input type="text" name="topic" class=" form-control" value=<?php echo $data['title'] ?> required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class=" col-lg-3 col-form-label">เนื้อหา :</label>
                    <div class=" col-lg-9">
                        <textarea name="content" class=" form-control" rows="8" required><?php echo $data['content'] ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class=" col-lg-12">
                        <center>
                            <button type="submit" class=" btn btn-warning btn-sm text-white">
                                <i class="bi bi-caret-right-square me-1"></i>บันทึกข้อความ
                            </button>
                        </center>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</body>
</html>