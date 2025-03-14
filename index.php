<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>報名表</title>
</head>
<body>
    <h1>報名表</h1>
 <form action=""> 

    <fieldset>
    <legend>基本資料</legend>
    <P>
        <label for="name">姓名 </label>
        <input type="text" name="name" id="name" value="" placeholder="請用中文" required>
    </P>
    <p>

        <label for="">性別</label>
        <input type="radio" name="gender" id="gender1" value="1">
        <label for="gender1">男生</label>
        <input type="radio" name="gender" id="gender2" value="2">
        <label for="gender2">女生</label>
    </p>
    <p>

        <label for="">生日</label>
        <input type="date" name="bday" id="bday" value="<?= date("Y-m-d") ?>">
    </p>
    <p>

        <label for="phone">電話</label>
        <input type="text" name="phone" id="phone">

    </p>
    <p>

        <label for="area">居住地</label>
        <select name="area" id="area">
            <option value="0">請選擇...</option>
            <option value="1">北部</option>
            <option value="2">中部</option>
            <option value="3">南部</option>
            <option value="4">東部</option>
            <option value="5">離島</option>
        </select>
    </p>
    </fieldset>
    <fieldset>
        <legend>使用行為</legend>
        <p>
            <input type="checkbox" name="behavior[]" id="behavior1">
            <label for="behavior1">聊天</label>
            <input type="checkbox" name="behavior[]" id="behavior2">
            <label for="behavior2">直播</label>
            <input type="checkbox" name="behavior[]" id="behavior3">
            <label for="behavior3">書信</label>
            <input type="checkbox" name="behavior[]" id="behavior4">
         <label for="behavior4">社群</label>
            <input type="checkbox" name="behavior[]" id="behavior5">
            <label for="behavior5">購物</label>
            <input type="checkbox" name="behavior[]" id="behavior6">
            <label for="behavior6">金融</label>
        </p>
    </fieldset>
    <fieldset>
        <legend>滿意度</legend>
       <P>
            <label for="">場地</label>
            <input type="radio" name="place" id="place1" value="5">
            <label for="place1">非常滿意</label>
            <input type="radio" name="place" id="place2" value="4">
            <label for="place2">滿意</label>
            <input type="radio" name="place" id="place3" value="3">
            <label for="place3">普通</label>
            <input type="radio" name="place" id="place4" value="2">
            <label for="place4">不滿意</label>
            <input type="radio" name="place" id="place5" value="1">
            <label for="place5">非常不滿意</label>
        </P>
    </fieldset>
    <fieldset>
        <legend>資料上傳</legend>
        <P>
            <label for="">同意書</label>
            <input type="file" name="agreement" id="agreement" accept=".doc,.doex">
        </P>
        <P>

            <label for="">個人照片</label>
            <input type="file" name="image" accept="image/*" onchange="preview_image(event)">
            <div><img id="output_image" width="300"></div>

        </P>


    </fieldset>
   


    <input type="submit" value="送出">




    </form>  
    <script type='text/javascript'>
    function preview_image(event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('output_image');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
</body>
</html>