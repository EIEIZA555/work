<?php
session_start();
if($_SESSION['user_id']!= $_SESSION['id'])


if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");
    $sql = "SELECT t3.name, t1.title, t1.id, t2.login, t1.post_date, t1.user_id 
    FROM post AS t1 
    INNER JOIN user AS t2 ON (t1.user_id=t2.id) 
    INNER JOIN category AS t3 ON (t1.cat_id=t3.id)
    WHERE t1.cat_id = cat_id
    ORDER BY t1.post_date DESC";
    $stmt = $conn->query($sql);
    $stmt->execute();

    while ($row = $stmt->fetch()) {
        if ($_SESSION['user_id'] == $row[5]) {
            echo "You do not have permission to edit this post.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container-lg">
        <h1 style="text-align: center;">Webboard KakKak</h1>
        <?php
        include "nav.php"
        ?>
        <div class="card text-dark bg-white border-warning col-lg-5 mt-3 mx-auto">
            <div class="card-header bg-warning text-white">แก้ไขกระทู้</div>
            <div class="card-body">
                <form action="editpost_save.php" method="post">
                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">หมวดหมู่ :</label>
                        <div class="col-lg-9">
                            <select name="category" class="form-select">
                                <?php
                                $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");
                                $sql = "SELECT * FROM category";
                                foreach ($conn->query($sql) as $row) {
                                    echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                                }
                                $conn = null;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">หัวข้อ :</label>
                        <div class="col-lg-9">
                            <input type="text" name="topic" rows = "8"class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">เนื้อหา :</label>
                        <div class="col-lg-9">
                            <textarea type="text" name="comment" rows="8" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <center>
                                <button type="submit" class="btn btn-warning btn-sm text-white">
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