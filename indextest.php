<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script>
        function myFunction() {
            let r = confirm("ต้องการจะลบจริงหรือไม่");
            return r;
        }
    </script>
</head>

<body>
    <div class="container-lg">
        <h1 style="text-align: center;" class="mt-3">Stardew Valley Webboard</h1>
        <?php include "nav.php"; ?>
        
        <div class="mt-3 mb-3">
            <label>หมวดหมู่:</label>
            <span class="dropdown">
                <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    --ทั้งหมด--
                </button>
                <ul class="dropdown-menu" aria-labelledby="Button2">
                    <li><a class="dropdown-item" href="indextest.php">ทั้งหมด</a></li>
                    <?php
                    // Connect to the database
                    $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");
                    $sql = "SELECT * FROM category";
                    foreach ($conn->query($sql) as $row) {
                        // Create a link that passes the category ID via URL
                        echo "<li><a class='dropdown-item' href='indextest.php?cat_id=$row[id]'>$row[name]</a></li>";
                    }
                    $conn = null;
                    ?>
                </ul>
            </span>

            <?php
            if (isset($_SESSION['id'])) {
                echo "<a class='btn btn-success btn-sm' style='float:right' href='newpost.php'>
                <i class='bi bi-plus'></i> สร้างกระทู้ใหม่
                </a>";
            }
            ?>
        </div>

        <table class="table table-striped">
            <?php
            // Connect to the database
            $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");

            // Check if a category is selected
            if (isset($_GET['cat_id'])) {
                // Fetch posts for the selected category
                $cat_id = $_GET['cat_id'];
                $sql = "SELECT t3.name, t1.title, t1.id, t2.login, t1.post_date 
                        FROM post AS t1 
                        INNER JOIN user AS t2 ON (t1.user_id=t2.id) 
                        INNER JOIN category AS t3 ON (t1.cat_id=t3.id)
                        WHERE t1.cat_id = :cat_id
                        ORDER BY t1.post_date DESC";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['cat_id' => $cat_id]);
            } else {
                // Fetch all posts if no category is selected
                $sql = "SELECT t3.name, t1.title, t1.id, t2.login, t1.post_date 
                        FROM post AS t1 
                        INNER JOIN user AS t2 ON (t1.user_id=t2.id) 
                        INNER JOIN category AS t3 ON (t1.cat_id=t3.id) 
                        ORDER BY t1.post_date DESC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
            }

            // Display the posts
            while ($row = $stmt->fetch()) {
                echo "<tr><td class='d-flex justify-content-between'> 
                <div>[ $row[0] ] <a href='post.php?id=$row[2]' style='text-decoration:none'>$row[1]</a><br>$row[3] - $row[4]</div>";
                
                // Show the delete button for admins
                if (isset($_SESSION['id']) && $_SESSION['role'] == 'a') {
                    echo "<div class='me-2 align-self-center'>
                    <a href='delete.php?id=$row[2]' class='btn btn-danger btn-sm' onclick='return myFunction()'>
                    <i class='bi bi-trash'></i></a></div>";
                }

                echo "</td></tr>";
            }

            $conn = null;
            ?>
        </table>
    </div>
</body>

</html>
