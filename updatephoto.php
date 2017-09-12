<?php
/**
 * Created by PhpStorm.
 * User: caolina
 * Date: 2015/5/25
 * Time: 21:23
 */
session_start();
$whiteList = array('jpg', 'png');
$newDir = "./userimgs/";

if($_FILES["testFile"]["name"]!=NULL){ // 程式從檔案上傳
    // explode: 切割字串, end: 取最後一個結果
    $extension = strtolower(end(explode(".", $_FILES["testFile"]["name"])));
    if( in_array($extension, $whiteList) &&
        $_FILES["testFile"]["size"]<=1024*1024){
        move_uploaded_file($_FILES["testFile"]["tmp_name"], $newDir.$_SESSION['id']."."."png");
        $v=$_SESSION['id'];
        //$_SESSION['photo']="./userimgs/$v.png";
        $db_server = "localhost";
        $db_user = "root";
        $db_passwd = "Wwm19940419";
        $db_name = "nthustore";
        if(!@mysql_connect($db_server, $db_user, $db_passwd)){
            die("無法對資料庫連線");
            //   echo '<meta http-equiv=REFRESH CONTENT=0;url=froum.html>';
        }

        mysql_query("SET NAMES utf8");

        if(!@mysql_select_db($db_name)) {
            die("無法使用資料庫");
        }
        $sql1 = "update users set  userimg='./userimgs/$v.png' where id='$v'";
        $result1= mysql_query($sql1);
        if($result1)
        {
            echo '<meta http-equiv=REFRESH CONTENT=0;url=user-info.php>';
        }
    }
    else {
         $resultStr = "Submit file GG!!";
    }
}
?>