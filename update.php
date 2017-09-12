<?php
/**
 * Created by PhpStorm.
 * User: caolina
 * Date: 2015/5/22
 * Time: 21:31
 */
$db_server = "localhost";
$db_user = "root";
$db_passwd = "Wwm19940419";
$db_name = "nthustore";
$dsn = "mysql:host=$db_server;dbname=$db_name";
$dbh = new PDO($dsn, $db_user, $db_passwd);
$dbh->exec("SET NAMES utf8mb4");
session_start();
if(isset($_POST['username'])&&isset($_POST['password'])){
    $username = $_POST['username'];
    $pwd = $_POST['password'];
    $pwd1 = $_POST['password1'];
    $username = preg_replace("/[^A-Za-z0-9]/","",$username);
    $pwd = preg_replace("/[^A-Za-z0-9]/","",$pwd);
    $pwd1 = preg_replace("/[^A-Za-z0-9]/","",$pwd1);
    $phone = $_POST['phone'];
    if($username!=NULL && $pwd!=NULL&&$pwd==$pwd1){
        $id=$_SESSION['id'];
        $pwd=sha1($pwd);
        $sql = "update users set username='$username',password='$pwd',phone='$phone'where id=?";
        $sth = $dbh->prepare($sql);
        $sth->execute(array($id));
        $row = $sth->fetch(PDO::FETCH_ASSOC);
            $sql = "SELECT id, password, username FROM users where id = ?";
        $sth = $dbh->prepare($sql);
        $sth->execute(array($id));
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        $_SESSION['id'] = $row['id'];
        $_SESSION['pwd'] = $row['password'];
        $_SESSION['username'] = $row['username'];
        $_SESSION["permission"]=$row["permission"];
            echo '<meta http-equiv=REFRESH CONTENT=0;url=user-info.php>';

    }
}
?>
