<?php
/**
 * Created by PhpStorm.
 * User: caolina
 * Date: 2015/6/5
 * Time: 16:38
 */
require_once("./pdo_initializer.php");
$gid=$_GET['id'];
//echo "0000";
$sql = "select * from goods where id=?";
$sth = $dbh->prepare($sql);
$sth->execute(array($gid));
$row= $sth->fetch(PDO::FETCH_ASSOC);
//echo $row["authorlocalid"];
if($_SESSION["id"]==$row["authorlocalid"])
{
    $sql = "DELETE FROM goods WHERE id = ?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($_GET['id']));
    $sql = "DELETE FROM collection WHERE gid = ?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($_GET['id']));
    $sql = "DELETE FROM message WHERE goods=?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($_GET['id']));
    $sql = "DELETE FROM comment WHERE gid=?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($_GET['id']));
    //echo "022";
    $time =date("Y-m-d");
    $sql = "select * from system where time=?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($time));

    if ( $row=$sth->fetch(PDO::FETCH_ASSOC)) {

        $soldno = $row["soldno"]+1;
        $goodsno = $row["goodsno"]-1;
        $sql = "update system set soldno=$soldno,goodsno=$goodsno where time=?";
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
        $sql = "insert into system (time,userno,goodsno,soldno) VALUES (?,?,?,1)";
        $sth = $dbh->prepare($sql);
        $sth->execute(array($time,$user,$goods));

    }
}
?>
<script>document.location = document.referrer;</script>
