<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school"; // 請更換為你的資料庫名稱

// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 設定字元編碼
$conn->set_charset("utf8mb4");

// 設定分頁參數
$limit = 10; // 每頁顯示10筆
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// 取得總筆數
$total_sql = "SELECT COUNT(*) AS total FROM book";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// 處理刪除書籍
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM book WHERE id = $id");
    header("Location: book.php");
    exit;
}

// 處理新增書籍
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
    $bookname = $_POST['bookname'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $pubdate = $_POST['pubdate'];
    $price = $_POST['price'];
   
    $sql = "INSERT INTO book (bookname, author, publisher, pubdate, price) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $bookname, $author, $publisher, $pubdate, $price);
    $stmt->execute();
    $stmt->close();
    header("Location: book.php");
    exit;
}

// 查詢書籍資料
$sql = "SELECT id, bookname, author, publisher, pubdate, price FROM book LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>書籍管理</title>
    <style>
        table { width: 80%; margin: 20px auto; border-collapse: collapse; font-size: 18px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .pagination { text-align: center; margin-top: 20px; font-size: 20px; }
        .pagination a { margin: 0 10px; text-decoration: none; color: blue; }
        .back-link { display: block; text-align: center; margin-top: 20px; font-size: 18px; }
        form { width: 50%; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9; }
        label { display: block; margin: 10px 0 5px; font-weight: bold; }
        input { width: calc(100% - 22px); padding: 10px; margin: 5px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; }
        button { display: block; width: 100%; padding: 10px; background-color: #007BFF; color: white; border: none; border-radius: 5px; font-size: 18px; cursor: pointer; margin-top: 10px; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h2 style='text-align:center;'>書籍列表</h2>
    <table>
        <tr><th>ID</th><th>書名</th><th>作者</th><th>出版社</th><th>出版日期</th><th>定價</th><th>操作</th></tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row["id"] ?></td>
                <td><?= htmlspecialchars($row["bookname"]) ?></td>
                <td><?= htmlspecialchars($row["author"]) ?></td>
                <td><?= htmlspecialchars($row["publisher"]) ?></td>
                <td><?= $row["pubdate"] ?></td>
                <td><?= htmlspecialchars($row["price"]) ?></td>
                <td>
                    <a href="edit_book.php?id=<?= $row['id'] ?>">編輯</a> |
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('確定要刪除嗎？');">刪除</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div class='pagination'>
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <a href='?page=<?= $i ?>'>第 <?= $i ?> 頁</a>
        <?php } ?>
    </div>
   
    <h2 style='text-align:center;'>新增書籍</h2>
    <form method="POST">
        <label>書名：</label>
        <input type="text" name="bookname" required>
        <label>作者：</label>
        <input type="text" name="author" required>
        <label>出版社：</label>
        <input type="text" name="publisher" required>
        <label>出版日期：</label>
        <input type="date" name="pubdate" required>
        <label>定價：</label>
        <input type="text" name="price" required>
        <button type="submit" name="add_book">新增</button>
    </form>
</body>
</html>
<?php $conn->close(); ?>
