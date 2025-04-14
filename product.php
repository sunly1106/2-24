<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product"; // ← 你的資料庫名稱

// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 處理新增、更新、刪除
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $pname = $_POST['pname'];
    $pspec = $_POST['pspec'];
    $price = $_POST['price'];
    $pdate = $_POST['pdate'];
    $content = $_POST['content'];

    if ($id) {
        // 修改
        $sql = "UPDATE product SET pname=?, pspec=?, price=?, pdate=?, content=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssissi", $pname, $pspec, $price, $pdate, $content, $id);
    } else {
        // 新增
        $sql = "INSERT INTO product (pname, pspec, price, pdate, content) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiss", $pname, $pspec, $price, $pdate, $content);
    }
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
} elseif (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM product WHERE id=$id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// 分頁
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$result = $conn->query("SELECT * FROM product ORDER BY id DESC LIMIT $offset, $limit");
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM product");
$totalRow = $totalResult->fetch_assoc();
$totalPages = ceil($totalRow['total'] / $limit);

// 單筆資料
$edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = $conn->query("SELECT * FROM product WHERE id=$id");
    $edit = $res->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>產品管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">產品列表</h2>
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th>ID</th><th>名稱</th><th>規格</th><th>價格</th><th>日期</th><th>動作</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['pname']) ?></td>
                <td><?= htmlspecialchars($row['pspec']) ?></td>
                <td><?= $row['price'] ?></td>
                <td><?= $row['pdate'] ?></td>
                <td>
                    <a class="btn btn-sm btn-info text-white" href="?edit=<?= $row['id'] ?>">編輯</a>
                    <a class="btn btn-sm btn-danger" href="?delete=<?= $row['id'] ?>" onclick="return confirm('確定要刪除嗎？')">刪除</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- 分頁 -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>">第 <?= $i ?> 頁</a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <h2 class="mt-5 mb-3"><?= $edit ? '編輯產品' : '新增產品' ?></h2>
    <form method="post" class="bg-white p-4 border rounded shadow-sm">
        <?php if ($edit): ?><input type="hidden" name="id" value="<?= $edit['id'] ?>"><?php endif; ?>
        <div class="mb-3">
            <label class="form-label">產品名稱</label>
            <input type="text" class="form-control" name="pname" value="<?= $edit['pname'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">產品規格</label>
            <input type="text" class="form-control" name="pspec" value="<?= $edit['pspec'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">產品定價</label>
            <input type="number" class="form-control" name="price" value="<?= $edit['price'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">製作日期</label>
            <input type="date" class="form-control" name="pdate" value="<?= $edit['pdate'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">內容說明</label>
            <textarea class="form-control" name="content" rows="4" required><?= $edit['content'] ?? '' ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><?= $edit ? '更新資料' : '新增資料' ?></button>
        <?php if ($edit): ?>
            <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-secondary">取消編輯</a>
        <?php endif; ?>
    </form>
</div>
</body>
</html>
