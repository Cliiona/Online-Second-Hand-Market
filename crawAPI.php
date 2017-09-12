<?php
/**
 * Created by PhpStorm.
 * User: Wu
 * Date: 15/5/20
 * Time: 下午1:42
 */
mysql_connect('localhost', 'root', '131426');
mysql_select_db('nthustore');
$content=$_POST["content"];
$pos = strpos($content, '\n');
$title=substr($content,0,$pos);
$fbid=$_POST["fbid"];
$author=$_POST["author"];
$picture=$_POST["picture"];
$price=$_POST["price"];
print_r($content);
$createtime=date("Y-m-d H:i:s" ,strtotime( $_POST["createtime"] ));
$updatetime=date("Y-m-d H:i:s" ,strtotime( $_POST["updatetime"] ));
$addtime=time();
mysql_query('replace into items (title, content, addtime, fbid, createtime, updatetime, author, picture, price)
VALUES ("' . $title . '", "' . $content . '", "' . $addtime .'","' . $fbid . '","' . $createtime .'","' . $updatetime .'","' . $author .'","' .$picture .'","'.$price.'")');