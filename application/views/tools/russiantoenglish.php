<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>
<body>
<h3>俄罗斯语转换成英语的工具</h3>
<form action="" method="POST">
    请输入俄语:<br><textarea name="str_ru" style="width:600px;height:100px;"><?php 
    if(!isset($_POST['str_ru'])) $_POST['str_ru']='Присяжные сочли недоказанным событие преступления. На скамье подсудимых пять человек: Александр и Вадим Ковтуны, Владимир Илютиков, Ма';
    echo $_POST['str_ru'];?></textarea>
    <br>
    <br>
    <input type="submit" value="点击将上面俄罗斯文转换成英文"/>
</form>
<hr>
<?php
header("content-type:text/html;charset=utf-8");
if(isset($_POST["str_ru"]))
{ 
       $str=$_POST['str_ru'];
       echo "<br><b>接收到的数据：</b>".$str;
       $res=ru2lat($str);  
       echo "<br><br><b>转化后的数据：</b>".$res;
}   
function ru2lat($str)
{
    $tr = array(
    "А"=>"a", "Б"=>"b", "В"=>"v", "Г"=>"g", "Д"=>"d",
    "Е"=>"e", "Ё"=>"yo", "Ж"=>"zh", "З"=>"z", "И"=>"i", 
    "Й"=>"j", "К"=>"k", "Л"=>"l", "М"=>"m", "Н"=>"n", 
    "О"=>"o", "П"=>"p", "Р"=>"r", "С"=>"s", "Т"=>"t", 
    "У"=>"u", "Ф"=>"f", "Х"=>"kh", "Ц"=>"ts", "Ч"=>"ch", 
    "Ш"=>"sh", "Щ"=>"sch", "Ъ"=>"", "Ы"=>"y", "Ь"=>"", 
    "Э"=>"e", "Ю"=>"yu", "Я"=>"ya", "а"=>"a", "б"=>"b", 
    "в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ё"=>"yo", 
    "ж"=>"zh", "з"=>"z", "и"=>"i", "й"=>"j", "к"=>"k", 
    "л"=>"l", "м"=>"m", "н"=>"n", "о"=>"o", "п"=>"p", 
    "р"=>"r", "с"=>"s", "т"=>"t", "у"=>"u", "ф"=>"f", 
    "х"=>"kh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", "щ"=>"sch", 
    "ъ"=>"", "ы"=>"y", "ь"=>"", "э"=>"e", "ю"=>"yu", 
    "я"=>"ya", " "=>"-", "."=>"", ","=>"", "/"=>"-",  
    ":"=>"", ";"=>"","—"=>"", "–"=>"-"
    );
return strtr($str,$tr);
}
?>                       
</body></html>