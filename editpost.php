<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_GET['id'])) {
    echo "No post selected.";
    exit();
}


$post_id = $_GET['id'];
$conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");

// Retrieve post information to check ownership
$sql = "SELECT t1.title, t1.content, t1.cat_id, t1.user_id 
        FROM post AS t1 
        WHERE t1.id = :post_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['post_id' => $post_id]);
$post = $stmt->fetch();

// Check if the post exists and the user is allowed to edit it
if (!$post) {
    echo "Post not found.";
    exit();
} elseif ($post['user_id'] != $_SESSION['user_id'] ) {
    echo "You do not have permission to edit this post.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
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
                    <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">

                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">หัวข้อ :</label>
                        <div class="col-lg-9">
                            <input type="text" name="topic" class="form-control"
                                value="<?php echo htmlspecialchars($post['title']); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">เนื้อหา :</label>
                        <div class="col-lg-9">
                            <textarea name="comment" rows="8" class="form-control"
                                required><?php echo htmlspecialchars($post['content']); ?></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">หมวดหมู่ :</label>
                        <div class="col-lg-9">
                            <select name="category" class="form-select">
                                <?php
                                foreach ($conn->query("SELECT * FROM category") as $row) {
                                    $selected = ($post['cat_id'] == $row['id']) ? 'selected' : '';
                                    echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-warning btn-sm text-white">
                            <i class="bi bi-caret-right-square me-1"></i> บันทึกข้อความ
                        </button>
                    </div>
                </form>

            </div>


        </div>
    </div>
</body>

</html>