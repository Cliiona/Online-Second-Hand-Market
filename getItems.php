<?php
/**
 * Created by PhpStorm.
 * User: Wu
 * Date: 15/5/20
 * Time: 下午4:09
 */
class Item
{
    public $title;
    public $content;
    public $fbid;
    public $author;
    public $createtime;
    public $updatetime;
    public $id;
    public $addtime;
    public $picture;
    public $price;
}
if(isset($_GET["page"])){
    $page=$_GET["page"];
}else{
    $page=0;
}
$index=intval($page)*12;
mysql_connect('localhost', 'root', 'Wwm19940419');
mysql_select_db('nthustore');
$sql="select * from items limit ".$index.",12" ;
$result = mysql_query($sql);
$data =array();
//
while ($row= mysql_fetch_array($result, MYSQL_ASSOC))
{
//    print_r($row);
    $item =new Item();
    $item->author=$row["name"];
    $item->title=$row["title"];
    $item->content=$row["content"];
    $item->fbid=$row["fbid"];
    $item->id=$row["id"];
    $item->createtime=$row["createtime"];
    $item->updatetime=$row["updatetime"];
    $item->addtime=$row["addtime"];
    $item->picture=$row["picture"];
    $item->author=$row["author"];
    $item->price=$row["price"];
    $data[]=$item;
}
$json = json_encode($data);
echo $json;