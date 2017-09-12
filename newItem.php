<?php
/**
 * Created by PhpStorm.
 * User: Wu
 * Date: 15/5/22
 * Time: 下午1:43
 */
session_start();
mysql_connect('localhost', 'root', 'Wwm19940419');
mysql_select_db('nthustore');
if(isset($_SESSION['id'])){
    if(isset($_POST["title"])){
        $title=$_POST["title"];
        $content=$_POST["content"];
        $id=$_SESSION["id"];
        $sql="INSERT INTO items (title, content, author_id) VALUES ('$title','$content','$id')";
        mysql_query($sql);
        echo '<meta http-equiv=REFRESH CONTENT=0;url=./index.php>';
    }else{
        die("未定义操作，请返回重试");
    }
}else{
    echo "请先登录";
}
