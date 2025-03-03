<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>練習</title>
</head>
<body>
    <h1>我的練習 php & mysql</h1>

    <form action="">
    姓名:
    <input type="text" name="name">
    年齡:
    <input type="text" name="age">
    <br>
    身高:
    <input type="text" name="height">
    體重:
    <input type="text" name="weight">
    <br>
    <input type="submit" value"送出" name="submit" >
    </form>
    <hr>

    <?php if ( isset($_GET["submit"])) { ?>
        <p>我的名字:<?=  $_GET["name"]   ?></p>
        <p>我的年齡:<?=  $_GET["age"]   ?></p>
        <p>今天是: <?=date("Y/m/d")?></p>
        <p>我的身高是: <?= $h=$_GET["height"] ?></p>
        <p>我的體重是: <?= $w=$_GET["weight"] ?></p>
        <p>我的BMI 是:<?=$bmi= $w/($h/100*$h/100) ?></p>
    
    
    
    
    <?php
        if ($bmi>25){
            echo "胖";
        } elseif ($bmi<18){
            echo "瘦";
        } else {
            echo "好好保持!";
        }
   ?> 
    <?php } ?>

</body>
</html>