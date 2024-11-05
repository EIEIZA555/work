<?php
session_start();
if (!isset($_COOKIE['category'])) {
    $_COOKIE['category'] = "ทั้งหมด";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
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
            <div class="mt-3 mb-2">
                <span class="dropdown">
                    หมวดหมู่ 
                    <button id="categorySelect" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <?php
                        echo $_COOKIE['category'];
                        ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="Button2">
                        <li><a onclick="selectCategory('ทั้งหมด')" class="dropdown-item">--ทั้งหมด--</a></li>
                        <?php
                        $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");
                        $sql = "SELECT name From category";
                        foreach ($conn->query($sql) as $row) {
                            echo "<li><a onclick='selectCategory(\"$row[0]\")' class='dropdown-item'>$row[0]</a></li>";
                        }
                        $conn = null;
                        ?>
                    </ul>
                </span>
                <?php
                if (isset($_SESSION['id']) && $_SESSION['role'] != 'b') {
                    echo "<a class='btn btn-success btn-sm' style ='float: right' role='button' href='newpost.php'><i class='bi bi-plus'></i> สร้างกระทู้ใหม่</a>";
                }
                ?>
                <br>
                <br>
                <table class="table table-striped">
                    <?php
                    $conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");
                    $sql = "SELECT t3.name,t1.title,t1.id,t2.login,t1.post_date,t2.role From post as t1 
                    Inner Join user as t2 ON (t1.user_id=t2.id) 
                    Inner Join category as t3 ON (t1.cat_id=t3.id) ORDER BY t1.post_date DESC";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch()) {
                        if ($_COOKIE['category'] != "ทั้งหมด" && $row[0] != $_COOKIE['category'] || $row[5] == 'b' ) {
                            continue;
                        }
                        echo "<tr>
                                <td class='d-flex justify-content-between align-items-center'> 
                                <div>
                                    [ $row[0] ] <a href='post.php?id=$row[2]' style='text-decoration:none'>$row[1]</a><br>
                                    $row[3] - $row[4]
                                </div>
                            <div>";
                        if (isset($_SESSION['id']) && $_SESSION['username'] == $row[3]) {
                            echo "<a onclick='editpost($row[2])' class='btn btn-warning' role='button'><i class='bi bi-pencil-fill'></i></a> ";
                        }
                        if (isset($_SESSION['id']) && $_SESSION['role'] == 'm' && $_SESSION['username'] == $row[3]) {
                            echo "<a onclick='confirmdel($row[2])' class='btn btn-danger' role='button'><i class='bi bi-trash'></i></a>";
                        } else if (isset($_SESSION['id']) && $_SESSION['role'] == 'a') {
                            echo "<a onclick='confirmdel($row[2])' class='btn btn-danger' role='button'><i class='bi bi-trash'></i></a>";
                        }
                        echo "</div></td></tr>";
                    }
                    $conn = null;
                    ?>
                </table>
                <script>
                    function confirmdel(a) {
                        if (confirm("ต้องการจะลบจริงหรือไม่") == true) {
                            location.href = `delete.php?id=${a}`;
                        } else {
                            text = "You canceled!";
                        }
                    };

                    function editpost(a) {
                        location.href = `editpost.php?id=${a}`;
                    };

                    function selectCategory(a) {
                        let categoryselect = document.getElementById("categorySelect");
                        document.cookie = "category=" + a + ";path=/"
                        categoryselect.textContent = a;
                        location.reload();
                    };
                </script>
            </div>
        </div>
    </div>
</body>

</html>