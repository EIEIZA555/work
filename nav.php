<nav class="navbar navbar-expand-lg " style="background-color: #d3d3d3;">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><i class="bi bi-house-door-fill"></i> Home</a>

        <ul class="navbar-nav">
            <?php
            if (!isset($_SESSION['id'])) {
                echo "<li class='nav-item'>
                            <a class='nav-link' href='login.php'><i class='bi bi-pencil-square'></i> เข้าสู่ระบบ</a>
                        </li>";
            } else {
                if ($_SESSION['role'] == 'a') {
                    echo "<li class='nav-item dropdown'>
                            <a class='btn btn-outline-secondary btn-sm dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown'  aria-expanded='false'>
                            <i class='bi bi-person-lines-fill'></i> $_SESSION[username]
                            </a>
                            <ul class='dropdown-menu dropdown-menu-end'>
                                <li><a class='dropdown-item' href='category.php'><i class='bi bi-bookmarks'></i> จัดการหมวดหมู่</a></li>
                                <li><a class='dropdown-item' href='user.php'><i class='bi bi-person-check'></i> จัดการผู้ใช้งาน</a></li>
                                <li><a class='dropdown-item' href='logout.php'><i class='bi bi-power'></i> ออกจากระบบ</a></li>
                            </ul>
                        </li>";
                } else {
                    echo "<li class='nav-item dropdown'>
                            <a class='btn btn-outline-secondary btn-sm dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown'  aria-expanded='false'>
                            <i class='bi bi-person-lines-fill'></i> $_SESSION[username]
                            </a>
                            <ul class='dropdown-menu dropdown-menu-end'>
                                <li><a class='dropdown-item' href='logout.php'><i class='bi bi-power'></i> ออกจากระบบ</a></li>
                            </ul>
                        </li>";
                }
            }
            ?>

    </div>
</nav>