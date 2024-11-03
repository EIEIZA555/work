<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new PDO("mysql:host=localhost;dbname=webboard;charset=utf8", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ดึงข้อมูลจากตาราง category เรียงลำดับตาม id
$sql = "SELECT * FROM category ORDER BY id ASC";
$stmt = $conn->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ตรวจสอบว่ามีการดึงข้อมูลมาหรือไม่
if (!$categories) {
    $categories = []; // กำหนดให้เป็น array เปล่าเพื่อป้องกันข้อผิดพลาดใน foreach
}
?>

<body>
    <div class="container-lg">
        <h1 class="text-center">Stardew Valley Webboard</h1>
        <?php include "nav.php"; 
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-success col-lg-6 mt-3 mx-auto">' . htmlspecialchars($_SESSION['message']) . '</div>';
            unset($_SESSION['message']); // Clear the message after displaying it
        }?>
        <div class="row justify-content-center">
            <div class="col-lg-6">
        <table class="table table-striped mt-4 mb-0 ">
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อหมวดหมู่</th>
                <th>จัดการ</th>
            </tr>
            <?php foreach ($categories as $key => $category): ?>
                <tr>
                    <td><?php echo htmlspecialchars($key + 1); ?></td>
                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                    <td class="justify-content-end ">
                        <!-- ปุ่มเปิด Modal -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
                                data-id="<?php echo $category['id']; ?>" data-name="<?php echo htmlspecialchars($category['name']); ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <a href="deletecategory.php?id=<?php echo $category['id']; ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('ต้องการจะลบจริงหรือไม่');">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        </div>
        </div>

        <center><a href="category_save.php" class="btn btn-success mt-3">
            <i class="bi bi-bookmark-plus"></i> เพิ่มหมวดหมู่ใหม่
        </a></center>
    </div>

    <!-- Modal สำหรับแก้ไขชื่อหมวดหมู่ -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">แก้ไขชื่อหมวดหมู่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm" action="editcategory.php" method="POST">
                        <input type="hidden" name="id" id="categoryId">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">ชื่อหมวดหมู่</label>
                            <input type="text" class="form-control" name="name" id="categoryName" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // เมื่อเปิด Modal ให้กรอกข้อมูลที่จำเป็น
        const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget; // ปุ่มที่เปิด Modal
            const id = button.getAttribute('data-id'); // ดึง id
            const name = button.getAttribute('data-name'); // ดึงชื่อหมวดหมู่

            // กรอกข้อมูลลงในฟอร์ม
            const categoryIdInput = document.getElementById('categoryId');
            const categoryNameInput = document.getElementById('categoryName');

            categoryIdInput.value = id;
            categoryNameInput.value = name;
        });
    </script>
</body>

</html>
