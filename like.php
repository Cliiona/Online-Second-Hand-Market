<?php
/**
 * Created by PhpStorm.
 * User: caolina
 * Date: 2015/6/1
 * Time: 22:13
 */
$db_server = "localhost";
$db_user = "root";
$db_passwd = "Wwm19940419";
$db_name = "nthustore";
$dsn = "mysql:host=$db_server;dbname=$db_name";
$dbh = new PDO($dsn, $db_user, $db_passwd);
$dbh->exec("SET NAMES utf8mb4");
session_start();
$gid=$_GET["gid"];
$uid=$_SESSION["id"];
$sql = "select * from collection where gid=?";
$sth = $dbh->prepare($sql);
$sth->execute(array($gid));
$temp=1;
while ($row = $sth->fetch(PDO::FETCH_ASSOC))
{
    if($row["uid"]==$uid)
    {
        $temp=0;
    }
}
if($temp==1) {
    $sql = "insert into collection (gid,uid,time) VALUES (?,?,now())";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($gid, $uid));
    $sql = "select * from goods where id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($gid));
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    $receive=$row["authorlocalid"];
    if($row["fbid"]==NULL) {
        $sql = "insert into message (send,receive,goods,type,time) VALUES (?,?,?,0,now())";
        $sth = $dbh->prepare($sql);
        $sth->execute(array($uid, $receive, $gid));
    }
}
//echo $temp;
echo "<meta http-equiv=REFRESH CONTENT=0;url=showItemDetail.php?id=$gid>";
?>