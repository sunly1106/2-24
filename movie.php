<?php
// 資料庫連線
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "school"; // ← 修改為你的資料庫名稱

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("連線失敗：" . $conn->connect_error);
}

$action = $_GET['action'] ?? 'list';

if ($action === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $conn->query("DELETE FROM movie WHERE id=$id");
    header("Location: movie.php");
    exit;
}

if ($action === 'create_submit') {
    extract($_POST);
    $conn->query("INSERT INTO movie (title, year, director, mtype, mdate, content) VALUES 
        ('$title', '$year', '$director', '$mtype', '$mdate', '$content')");
    header("Location: movie.php");
    exit;
}

if ($action === 'edit_submit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    extract($_POST);
    $conn->query("UPDATE movie SET 
        title='$title', year='$year', director='$director',
        mtype='$mtype', mdate='$mdate', content='$content' WHERE id=$id");
    header("Location: movie.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>電影管理</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-6 text-center">🎬 電影管理系統</h1>

    <?php if ($action === 'view' && isset($_GET['id'])):
        $id = (int)$_GET['id'];
        $row = $conn->query("SELECT * FROM movie WHERE id=$id")->fetch_assoc(); ?>
        
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold mb-4"><?= $row['title'] ?></h2>
            <p><strong>年份：</strong><?= $row['year'] ?></p>
            <p><strong>導演：</strong><?= $row['director'] ?></p>
            <p><strong>類型：</strong><?= $row['mtype'] ?></p>
            <p><strong>上映日期：</strong><?= $row['mdate'] ?></p>
            <p><strong>內容：</strong><br><?= nl2br($row['content']) ?></p>
            <a href="movie.php" class="inline-block mt-4 text-blue-600 hover:underline">← 返回列表</a>
        </div>

    <?php elseif ($action === 'create' || ($action === 'edit' && isset($_GET['id']))):
        $isEdit = $action === 'edit';
        $row = ['title'=>'', 'year'=>'', 'director'=>'', 'mtype'=>'', 'mdate'=>'', 'content'=>''];
        $id = '';
        if ($isEdit) {
            $id = (int)$_GET['id'];
            $row = $conn->query("SELECT * FROM movie WHERE id=$id")->fetch_assoc();
        } ?>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold mb-4"><?= $isEdit ? '✏️ 編輯電影' : '➕ 新增電影' ?></h2>
            <form method="post" action="movie.php?action=<?= $isEdit ? 'edit_submit&id='.$id : 'create_submit' ?>">
                <label class="block mb-2">片名</label>
                <input name="title" class="border rounded w-full mb-4 p-2" required value="<?= $row['title'] ?>">

                <label class="block mb-2">年份</label>
                <input name="year" type="number" class="border rounded w-full mb-4 p-2" required value="<?= $row['year'] ?>">

                <label class="block mb-2">導演</label>
                <input name="director" class="border rounded w-full mb-4 p-2" required value="<?= $row['director'] ?>">

                <label class="block mb-2">類型</label>
                <input name="mtype" class="border rounded w-full mb-4 p-2" required value="<?= $row['mtype'] ?>">

                <label class="block mb-2">上映日期</label>
                <input name="mdate" type="date" class="border rounded w-full mb-4 p-2" required value="<?= $row['mdate'] ?>">

                <label class="block mb-2">內容說明</label>
                <textarea name="content" rows="4" class="border rounded w-full p-2"><?= $row['content'] ?></textarea>

                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"><?= $isEdit ? '儲存變更' : '新增電影' ?></button>
                <a href="movie.php" class="ml-4 text-blue-600 hover:underline">取消</a>
            </form>
        </div>

    <?php else:
        $page = max((int)($_GET['page'] ?? 1), 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $total = $conn->query("SELECT COUNT(*) AS total FROM movie")->fetch_assoc()['total'];
        $pages = ceil($total / $perPage);
        $result = $conn->query("SELECT * FROM movie ORDER BY id DESC LIMIT $offset, $perPage");
        ?>

        <div class="mb-4 text-right">
            <a href="movie.php?action=create" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">➕ 新增電影</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full bg-white rounded shadow">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="p-3">ID</th>
                        <th class="p-3">片名</th>
                        <th class="p-3">年份</th>
                        <th class="p-3">導演</th>
                        <th class="p-3">類型</th>
                        <th class="p-3">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="border-t">
                            <td class="p-3"><?= $row['id'] ?></td>
                            <td class="p-3"><?= htmlspecialchars($row['title']) ?></td>
                            <td class="p-3"><?= $row['year'] ?></td>
                            <td class="p-3"><?= $row['director'] ?></td>
                            <td class="p-3"><?= $row['mtype'] ?></td>
                            <td class="p-3">
                                <a class="text-blue-600 hover:underline" href="movie.php?action=view&id=<?= $row['id'] ?>">查看</a>
                                <a class="text-yellow-600 hover:underline ml-2" href="movie.php?action=edit&id=<?= $row['id'] ?>">編輯</a>
                                <a class="text-red-600 hover:underline ml-2" href="movie.php?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('確定要刪除這筆資料嗎？')">刪除</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-between items-center">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="text-blue-600 hover:underline">← 上一頁</a>
            <?php else: ?>
                <span></span>
            <?php endif; ?>
            <span>第 <?= $page ?> / <?= $pages ?> 頁</span>
            <?php if ($page < $pages): ?>
                <a href="?page=<?= $page + 1 ?>" class="text-blue-600 hover:underline">下一頁 →</a>
            <?php else: ?>
                <span></span>
            <?php endif; ?>
        </div>

    <?php endif; ?>
</div>

</body>
</html>
