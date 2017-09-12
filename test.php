<?php
/**
 * Created by PhpStorm.
 * User: Wu
 * Date: 15/5/20
 * Time: 下午9:23
 */
//$mystring = '《物品名稱》zenfone2 (5.5寸)智慧皮套\nNT$200\n\n《使用次數、年分》僅打開檢查\n《所在地》清交\n《聯絡人》本人\n《補充說明》意者私訊';
//$findme   = '\n';
//$pos = strpos($mystring, $findme);
//echo substr($mystring,0,$pos);

$url='http://www.nthuhw.com/getItems.php?page=0';
$jsonstr = file_get_contents($url);
print_r($jsonstr);
$datas = json_decode($jsonstr,true);
print_r($datas);
$pos = strpos($datas[0]["content"], '\n');
print_r($pos);
echo substr($datas[0]["content"],0,$pos);