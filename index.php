<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>練習</title>
</head>
<body>
    <h1>我的練習 php & mysql</h1>
    <p>我的名字:<?=  $_GET["name"]   ?></p>
    <p>我的年齡:<?=  $_GET["age"]   ?></p>
    <p>今天是: <?=date("Y/m/d")?></p>
    <p>我的身高是: <?= $h=$_GET["height"] ?></p>
    <p>我的體重是: <?= $w=$_GET["weight"] ?></p>
    <p>我的BMI 是:<?= $w/($h/100*$h/100) ?></p>
    
</body>
</html>