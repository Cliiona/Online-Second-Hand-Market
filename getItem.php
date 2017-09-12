<?php
/**
 * Created by PhpStorm.
 * User: Wu
 * Date: 15/5/21
 * Time: 下午9:07
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
}
if(isset($_GET["id"])){
    $id=$_GET["id"];
    mysql_connect('localhost', 'root', 'Wwm19940419');
    mysql_select_db('nthustore');
    $sql='select * from goods where id="'.$id.'"';
    $result = mysql_query($sql);
    $data =array();
//
    while ($row= mysql_fetch_array($result, MYSQL_ASSOC))
    {
//    print_r($row);
        $item =new Item();
        $item->goodsname=$row["goodsname"];
        $item->title=$row["title"];
        $item->content=$row["content"];
        $item->fbid=$row["fbid"];
        $item->id=$row["id"];
        $item->createtime=$row["createtime"];
        $item->updatetime=$row["updatetime"];
        $item->addtime=$row["addtime"];
        $item->picture=$row["picture"];
        $item->author=$row["author"];
        $data[]=$item;
    }
    $json = json_encode($data);
    echo $json;
}else{
    echo "未定義操作，請返回重試";
}
