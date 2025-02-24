<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>練習</title>
</head>
<body>
    <h1>我的練習 php & mysql</h1>
    <p>今天是: <?=data("Y/m/d")?></p>
    <p>我的身高是: <?= $h=155 ?></p>
    <p>我的體重是: <?= $w=31 ?></p>
    <p>我的BMI 是:<?=  $W($h/100*$h/100) ?></p>
</body>
</html>