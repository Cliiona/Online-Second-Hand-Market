<?php
/**
 * Created by PhpStorm.
 * User: Wu
 * Date: 15/5/22
 * Time: 上午1:51
 */
session_start();
mysql_connect('localhost', 'root', '131426');
mysql_select_db('nthustore');
if(isset($_POST['username'])&&isset($_POST['password'])){
    $username = $_POST['username'];
    $pwd = $_POST['password'];
    $username = preg_replace("/[^A-Za-z0-9]/","",$username);
    $pwd = preg_replace("/[^A-Za-z0-9]/","",$pwd);
    if($username!=NULL && $pwd!=NULL){
        $sql = "SELECT id, password, username FROM users where username = '$username'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        // 比對密碼
        if($row['password']==$pwd){
            $_SESSION['id'] = $row['id'];
            $_SESSION['pwd'] = $row['password'];
            $_SESSION['username'] = $row['username'];
            echo '<meta http-equiv=REFRESH CONTENT=0;url=./index.php>';
        }
    }
}