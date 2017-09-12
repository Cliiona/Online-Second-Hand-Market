<?php
/**
 * Created by PhpStorm.
 * User: caolina
 * Date: 2015/6/2
 * Time: 15:54
 */
$db_server = "localhost";
$db_user = "root";
$db_passwd = "Wwm19940419";
$db_name = "nthustore";
$dsn = "mysql:host=$db_server;dbname=$db_name";
$dbh = new PDO($dsn, $db_user, $db_passwd);
$dbh->exec("SET NAMES utf8");
session_start();
$id=$_GET["id"];
$msg =trim( $_POST['cont']);
$msg = stripslashes($msg);
$msg=mysql_real_escape_string($msg);
$msg= htmlspecialchars($msg);
if(isset($_SESSION["id"]))
{
    echo $msg;
    $uid=$_SESSION["id"];
    $sql = "insert into comment (send,gid,content,time) VALUES (?,?,?,now())";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($uid,$gid,$msg));
    $sql = "select * from goods where id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($id));
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    $receive=$row["authorlocalid"];
    $sql = "insert into message (send,receive,goods,type,time) VALUES (?,?,?,0,now())";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($uid,$receive,$gid));
}

//echo $temp;
//echo "<meta http-equiv=REFRESH CONTENT=0;url=showItemDetail.php?id=$id>";
?>