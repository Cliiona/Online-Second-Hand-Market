<?php
/**
 * Created by PhpStorm.
 * User: caolina
 * Date: 2015/5/24
 * Time: 15:24
 */
$db_server = "localhost";
$db_user = "root";
$db_passwd = "";
$db_name = "nthustore";
$dsn = "mysql:host=$db_server;dbname=$db_name";
$dbh = new PDO($dsn, $db_user, $db_passwd);
$dbh->exec("SET NAMES utf8mb4");
session_start();
$id=$_GET['id'];
$a=$_GET["a"];
$sql0 = "select * from collection where id=?";
$sth0 = $dbh->prepare($sql0);
$sth0->execute(array($id));
$row= $sth0->fetch(PDO::FETCH_ASSOC);
$gid=$row["gid"];
if($row["uid"]==$_SESSION["id"]) {
    $sql = "delete from collection where id=$id";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($id));
    $sql = "select * from goods where id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($gid));
    $row1 = $sth->fetch(PDO::FETCH_ASSOC);
    $receive=$row1["authorlocalid"];
    $sql = "delete from message where goods=? and send=? and receive=? and type=0";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($gid,$_SESSION["id"],$receive));
  }
if($a==1)
{
    echo "<meta http-equiv=REFRESH CONTENT=0;url=showItemDetail.php?id=$gid>";
}
else
{echo '<meta http-equiv=REFRESH CONTENT=0;url=user-clc.php>';}
?>