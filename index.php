<?php
// 設定資料庫連線資訊
$servername = "localhost";
$username = "root"; // 你的 MySQL 使用者名稱
$password = ""; // 你的 MySQL 密碼
$dbname = "school"; // 請替換為你的資料庫名稱

// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線是否成功
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 設定每頁顯示的記錄數
$records_per_page = 10;

// 取得當前頁數（如果沒有設定，預設為第 1 頁）
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // 確保頁數不小於 1

// 計算 SQL LIMIT 起始點
$offset = ($page - 1) * $records_per_page;

// 查詢總記錄數
$total_sql = "SELECT COUNT(*) AS total FROM book";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];

// 計算總頁數
$total_pages = ceil($total_records / $records_per_page);

// 查詢當前頁數的記錄
$sql = "SELECT id, bookname, author, publisher, pubdate, price, content FROM book LIMIT $offset, $records_per_page";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>書籍列表（分頁）</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 5px 10px;
            border: 1px solid #007BFF;
            color: #007BFF;
            text-decoration: none;
        }
        .pagination a:hover {
            background-color: #007BFF;
            color: white;
        }
        .pagination .disabled {
            color: grey;
            border-color: grey;
            pointer-events: none;
        }
    </style>
</head>
<body>

<h2>書籍列表</h2>

<table>
    <tr>
        <th>ID</th>
        <th>書名</th>
        <th>作者</th>
        <th>出版社</th>
        <th>出版日期</th>
        <th>定價</th>
        <th>內容說明</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        // 輸出資料
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['bookname']}</td>
                    <td>{$row['author']}</td>
                    <td>{$row['publisher']}</td>
                    <td>{$row['pubdate']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['content']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>沒有找到書籍資料</td></tr>";
    }
    ?>

</table>

<!-- 分頁導航 -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>">上一頁</a>
    <?php else: ?>
        <span class="disabled">上一頁</span>
    <?php endif; ?>

    <span>第 <?= $page ?> 頁 / 共 <?= $total_pages ?> 頁</span>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?= $page + 1 ?>">下一頁</a>
    <?php else: ?>
        <span class="disabled">下一頁</span>
    <?php endif; ?>
</div>

</body>
</html>

<?php
// 關閉連線
$conn->close();
?>
