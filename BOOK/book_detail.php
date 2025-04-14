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
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("連線失敗: " . $conn->connect_error);
$conn->set_charset("utf8mb4");

if (!isset($_GET['id'])) die("未指定 ID");

$id = (int)$_GET['id'];
$book = $conn->query("SELECT * FROM book WHERE id = $id")->fetch_assoc();
if (!$book) die("書籍未找到");
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head><meta charset="UTF-8"><title>書籍詳細資料</title></head>
<body>
<h2>書籍詳細資料</h2>
<p><strong>書名：</strong> <?= htmlspecialchars($book['bookname']) ?></p>
<p><strong>作者：</strong> <?= htmlspecialchars($book['author']) ?></p>
<p><strong>出版社：</strong> <?= htmlspecialchars($book['publisher']) ?></p>
<p><strong>出版日期：</strong> <?= $book['pubdate'] ?></p>
<p><strong>定價：</strong> <?= htmlspecialchars($book['price']) ?></p>
<a href="book_list.php">返回列表</a>
</body>
</html>