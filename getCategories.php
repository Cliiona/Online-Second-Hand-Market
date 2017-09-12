<?php
/**
 * Created by PhpStorm.
 * User: Wu
 * Date: 15/5/21
 * Time: 下午9:39
 */
class Item
{
    public $title;
    public $position;
}
    mysql_connect('localhost', 'root', 'Wwm19940419');
    mysql_select_db('nthustore');
    $sql='select * from category';
    $result = mysql_query($sql);
    $data =array();
//
    while ($row= mysql_fetch_array($result, MYSQL_ASSOC))
    {
//    print_r($row);
        $item =new Item();
        $item->position=$row["pos"];
        $item->title=$row["title"];
        $data[]=$item;
    }
    $json = json_encode($data);
    echo $json;
