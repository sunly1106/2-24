<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>書籍管理系統</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a.button {
            text-decoration: none;
            padding: 8px 16px;
            margin: 0 4px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }
        a.button:hover {
            background-color: #0056b3;
        }
        .center {
            text-align: center;
            margin: 20px 0;
        }
        form {
            background: white;
            padding: 20px;
            width: 400px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        form input, form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            background-color: #28a745;
            color: white;
            border: none;
        }
        form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>書籍管理系統 -</h2>
    <div class="center">
        <a href="book_list.php" class="button">書籍列表</a>
        <a href="add_book.php" class="button">新增書籍</a>
    </div>
    <!-- 在這裡插入你想呈現的內容 -->
</body>
</html>
<?php
// book_list.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("連線失敗: " . $conn->connect_error);
$conn->set_charset("utf8mb4");

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_result = $conn->query("SELECT COUNT(*) AS total FROM book");
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $limit);

$result = $conn->query("SELECT * FROM book LIMIT $limit OFFSET $offset");
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head><meta charset="UTF-8"><title>書籍列表</title></head>
<body>
<h2>書籍列表</h2>
<table border="1" cellpadding="10" cellspacing="0">
<tr><th>ID</th><th>書名</th><th>作者</th><th>操作</th></tr>
<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><?= htmlspecialchars($row['bookname']) ?></td>
  <td><?= htmlspecialchars($row['author']) ?></td>
  <td>
    <a href="book_detail.php?id=<?= $row['id'] ?>">詳細</a> |
    <a href="edit_book.php?id=<?= $row['id'] ?>">編輯</a> |
    <a href="delete_book.php?id=<?= $row['id'] ?>" onclick="return confirm('確定刪除？');">刪除</a>
  </td>
</tr>
<?php } ?>
</table>
<div style="text-align:center;">
  <?php for ($i = 1; $i <= $total_pages; $i++) echo "<a href='?page=$i'>第 $i 頁</a> "; ?>
</div>
<a href="add_book.php">新增書籍</a>
</body>
</html>
<?php $conn->close(); ?>
