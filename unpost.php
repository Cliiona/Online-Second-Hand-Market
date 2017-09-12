<?php
/**
 * Created by PhpStorm.
 * User: caolina
 * Date: 2015/5/24
 * Time: 14:16
 */
$db_server = "localhost";
$db_user = "root";
$db_passwd = "Wwm19940419";
$db_name = "nthustore";
$dsn = "mysql:host=$db_server;dbname=$db_name";
$dbh = new PDO($dsn, $db_user, $db_passwd);
$dbh->exec("SET NAMES utf8mb4");
session_start();
$gid=trim($_GET['id']);
$sql = "select * from goods where id=? ";
$sth = $dbh->prepare($sql);
$sth->execute(array($gid));
$row = $sth->fetch(PDO::FETCH_ASSOC);
if($_SESSION['id']==$row['authorlocalid'])
{
    $temp=$row['valid'];
    $v=abs($temp-1);
    $sql = "update goods set valid=$v,time=NOW() where id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($gid));
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    $time =date("Y-m-d");
    $sql = "select * from system where time=?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($time));

    if ( $row=$sth->fetch(PDO::FETCH_ASSOC)) {
        if(v==1)
        {$goodsno = $row["goodsno"]+1;}
        else
        {
            $goodsno = $row["goodsno"]-1;
        }
        $sql = "update system set goodsno=$goodsno where time=?";
        $sth = $dbh->prepare($sql);
        $sth->execute(array($time));
    } else {
        $sql = "select count(*) from users";
        $sth = $dbh->prepare($sql);
        $sth->execute(array());
        $userno = $sth->fetch(PDO::FETCH_ASSOC);
        $sql = "select count(*) from goods where valid=1";
        $sth = $dbh->prepare($sql);
        $sth->execute(array());
        $goodsno = $sth->fetch(PDO::FETCH_ASSOC);
        $user=$userno['count(*)'];
        $goods=$goodsno['count(*)'];
        $sql = "insert into system (time,userno,goodsno,soldno) VALUES (?,?,?,0)";
        $sth = $dbh->prepare($sql);
        $sth->execute(array($time,$user,$goods));

    }
    echo '<meta http-equiv=REFRESH CONTENT=0;url=user-items.php>';
}
else
{
    echo $gid;
}
?>