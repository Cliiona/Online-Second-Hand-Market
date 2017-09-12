<?php
/**
 * Created by PhpStorm.
 * User: Wu
 * Date: 15/5/22
 * Time: 下午3:00
 */
session_start();
mysql_connect('localhost', 'root','131426');
mysql_select_db('nthustore');
if(isset($_SESSION["id"])) {
    if (isset($_POST["title"])) {
        $title=$_POST["title"];
        $content=$_POST["content"];
        $authorid=$_SESSION["id"];
        $item_id=$_POST["item_id"];
        $sql = "INSERT INTO topic (title, content ,author_id, item_id) VALUES ('$title','$content','$authorid','$item_id')";
        mysql_query($sql);
        echo '<meta http-equiv=REFRESH CONTENT=0;url=./index.php>';
    }
}