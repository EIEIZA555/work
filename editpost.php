<?php
session_start();
$conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");

// Check if post ID is provided
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "SELECT * FROM post WHERE id = :post_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['post_id' => $post_id]);
    $post = $stmt->fetch();

    // Check if the user is authorized to edit the post
    if ($_SESSION['id'] != $post['user_id'] && $_SESSION['role'] != 'a') {
        die("You do not have permission to edit this post.");
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];

        // Update post
        $sql = "UPDATE post SET title = :title, content = :content WHERE id = :post_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['title' => $title, 'content' => $content, 'post_id' => $post_id]);

        // Redirect to the post page
        header("Location: post.php?id=$post_id");
        exit;
    }
} else {
    die("Invalid post ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-lg mt-5">
        <div class="row">
            <div class="col-sm-8 col-md-6 col-lg-6 mx-auto">
                <div class="card">
                    <h5 class="card-header">Edit Post</h5>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea name="content" class="form-control" rows="5" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                                <a href="post.php?id=<?php echo $post_id; ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
