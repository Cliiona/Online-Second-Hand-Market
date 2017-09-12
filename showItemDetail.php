<?php
/**
 * Created by PhpStorm.
 * User: caolina
 * Date: 15/5/21
 * Time: 下午9:16
 */
session_start();
mysql_connect('localhost', 'root', 'Wwm19940419');
mysql_select_db('nthustore');
mysql_query("SET NAMES utf8");
if(isset($_GET["id"])){
    $id=$_GET["id"];
    $url='http://127.0.0.1/getItem.php?id='.$id;
    $jsonstr = file_get_contents($url);
    $datas = json_decode($jsonstr,true);
    $data=$datas[0];
    $goodsname=$data["goodsname"];
    $goodscon=$data["goodscon"];
    $price=$data['price'];
    $picture=$data["picture"];
    $author=$data["author"];
    $fbid=$data["fbid"];
    $line=$data["line"];
    $location=$data["location"];
    $time=$data["time"];
    if ($data["picture"] == "") {
        $picture = "./goodpictures/no.jpg";
    }
    $sql="SELECT * FROM comment WHERE gid='$id'";
    $result=mysql_query($sql);
    $db_server = "localhost";
    $db_user = "root";
    $db_passwd = "Wwm19940419";
    $db_name = "nthustore";
    $dsn = "mysql:host=$db_server;dbname=$db_name";
    $dbh = new PDO($dsn, $db_user, $db_passwd);
    $dbh->exec("SET NAMES utf8mb4");
}else{
    die("未定义操作，请返回重试");
}

if(isset($_POST['cont']))
{
    $msg =trim( $_POST['cont']);
    $msg = stripslashes($msg);
    $msg=mysql_real_escape_string($msg);
    $msg= htmlspecialchars($msg);
    $uid=$_SESSION["id"];
    $sql4 = "insert into comment (send,gid,content,time) VALUES (?,?,?,now())";
    $sth4 = $dbh->prepare($sql4);
    $sth4->execute(array($uid,$id,$msg));
    $sql4 = "select * from goods where id=?";
    $sth4 = $dbh->prepare($sql4);
    $sth4->execute(array($id));
    $row4 = $sth4->fetch(PDO::FETCH_ASSOC);
    $receive=$row4["authorlocalid"];
    $sql4= "insert into message (send,receive,goods,type,time) VALUES (?,?,?,1,now())";
    $sth4 = $dbh->prepare($sql4);
    $sth4->execute(array($uid,$receive,$gid));
    echo "<meta http-equiv=REFRESH CONTENT=0;url=showItemDetail.php?id=$id>";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<!--    <script src="./js/bootstrap-suggest.min.js"></script>-->
<script src="./js/bootstrap-select.js"></script>
<link href="css/wwm.css" rel="stylesheet" type="text/css" />

<title>NTHUStore</title>
</head>
<body style="background-color:#d9eaf8">

<div class="container" >

    <div class="row clearfix" style="position:relative;top:0px;left:-105px;width:1379px">

        <div class="col-md-12 column">
            <nav class="navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1"><span class="sr-only">Toggle navigation</span><span
                            class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                    <a class="navbar-brand" href="./index.php"><img src="./images/logo_1.png" style="position:relative;top:-20px;left:-20px"></a>
                </div>


                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form navbar-left" role="search" action="./searchItem.php" method="get">
                        <div class="form-group">
                            <input type="text" class="form-control" id="searchtext" name="keyword" style="width:450px" autocomplete="off"/>
                        </div>
                        <button type="submit" class="btn btn-default">搜尋</button>
                    </form>
                    <div class="search_suggest" id="searchsuggest">
                        <ul>

                        </ul>
                    </div>
                    <?php
                    if (isset($_SESSION["id"])) {
                        ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle"
                                   data-toggle="dropdown"><?php echo "hello , " . $_SESSION["username"]; ?><strong
                                        class="caret"></strong></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="./user-info.php">個人中心</a>
                                    </li>
                                    <li>
                                        <a href="./user-clc.php">我的收藏</a>
                                    </li>

                                    <?php
                                    if($_SESSION["permission"]==1){
                                        ?>
                                        <li class="divider">
                                        </li>
                                        <li>
                                            <a href="./admin/admin.php">管理面板</a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                    <li class="divider">
                                    </li>
                                    <li>
                                        <a href="./logout.php">退出登錄</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    <?php
                    }
                    ?>
                </div>
                <script type="text/javascript">
                    function SearchSuggest(searchFuc) {
                        var input = $('#searchtext');
                        var suggestWrap = $('#searchsuggest');
                        var key = "";
                        var init = function () {
                            input.bind('keyup', sendKeyWord);
                            input.bind('blur', function () {
                                setTimeout(hideSuggest, 100);
                            })
                        }
                        var hideSuggest = function () {
                            suggestWrap.hide();
                        }
                        var sendKeyWord = function (event) {
                            var valText = $.trim(input.val());
                            if (valText == '' || valText == key) {
                                return;
                            }
                            searchFuc(valText);
                            key = valText;
                        }
                        this.dataDisplay = function (data) {
                            if (data.length <= 0) {
                                suggestWrap.hide();
                                return;
                            }
                            var li;
                            var tmpFrag = document.createDocumentFragment();
                            suggestWrap.find('ul').html('<li>您要找的是不是:</li>');
                            for (var i = 0; i < data.length; i++) {
                                a=document.createElement('A');
                                a.href="./showItemDetail.php?id="+data[i].id;
                                a.innerHTML=data[i].goodsname;
                                li = document.createElement('LI');
                                li.appendChild(a);
                                tmpFrag.appendChild(li);
                            }
                            suggestWrap.find('ul').append(tmpFrag);
                            suggestWrap.show();
                            suggestWrap.find('li').hover(function () {
                                suggestWrap.find('li').removeClass('hover');
                                $(this).addClass('hover');

                            }, function () {
                                $(this).removeClass('hover');
                            }).bind('click', function () {
                                input.val(this.innerHTML);

                                suggestWrap.hide();
                            });
                        }
                        init();
                    }
                    ;
                    var searchSuggest = new SearchSuggest(sendKeyWordToBack);
                    function sendKeyWordToBack(keyword) {
                        var obj = {
                            "keyword": keyword
                        };
                        $.ajax({
                            type: "GET",
                            url: "http://www.nthuhw.com/searchAdvice.php",
                            async: true,
                            data: obj,
                            dataType: "json",
                            success: function (data) {
                                var aData = [];
                                for (var i = 0; i < data.length; i++) {
                                    var dataobj={};
                                    dataobj.goodsname=data[i]["goodsname"];
                                    dataobj.id=data[i]["id"];
                                    aData.push(dataobj);
                                }
                                searchSuggest.dataDisplay(aData);
                            }
                        });
                    }

                </script>

            </nav>

        </div>

    </div>

    <div class="row clearfix">
        <div class="col-md-2 column">
        </div>
        <div class="col-md-3 column" >
            <img style="width:275px; height:290px; overflow: hidden" src=<?php echo $picture; ?> class="img-rounded" />
            <?php
                $sql0 = "select * from collection where gid=?";
                $sth0 = $dbh->prepare($sql0);
                $sth0->execute(array($id));
                $temp=1;
                while ($row1 = $sth0->fetch(PDO::FETCH_ASSOC))
                {
                    if($row1["uid"]==$_SESSION["id"])
                    {
                        $temp=0;
                        $cid=$row1["id"];
                    }
                }
                if($temp==1) {
                    echo "<a href='./like.php?gid=$id' style='position:absolute;z-index:2;top:265px;left:235px;font-size: 7px'><img src='./userimgs/like.png' width='20' height='20'>收藏</a>";
                }
                else
                {
                    echo "<a href='./unlike.php?id=$cid&a=1' style='position:absolute;z-index:2;top:265px;left:220px;font-size: 7px'><img src='./userimgs/liked.png' width='20' height='20'>取消收藏</a>";
                }

            ?>
          </div>
    <?php
    if($fbid==NULL) {
        ?>
        <div class="col-md-5 column">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        商品名：<?php echo nl2br($goodsname); ?>
                    </h3>
                </div>
                <div class="panel-body">
                    價格：<?php echo $price; ?>
                </div>
                <div class="panel-body">
                    發佈者：<?php echo $author; ?>
                </div>
                <div class="panel-body">
                    聯繫方式：<?php echo $line; ?>
                </div>
                <div class="panel-body">
                    交易地點：<?php echo $location; ?>
                </div>
                <div class="panel-body">
                    發佈時間：<?php echo $time; ?>
                </div>

            </div>
        </div>
    <?php
    }
        ?>
    </div>
    <div class="row clearfix">
        <div class="col-md-1 column">
        </div>
        <div class="col-md-10 column" style="left:95px;">
            <blockquote style="background-color: #FFFFFF;width:752px">
                <p>
                    <?php echo nl2br($goodscon); ?>
                </p>
                <?php
                if($fbid!=NULL) {
                echo"<small>資料來源Facebook<cite><a href='http://www.facebook.com/$fbid'>$author</a></cite></small>";
                }
                else
                {
                    echo"<p style='font-size:7px'>（聯繫我的時候，請說明是在清交二手市場看到的哦！）</p>";
                }
                ?>
            </blockquote>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-1 column">
        </div>
        <div class="col-md-10 column">
            <div class="row" style="left:95px" >
                <?php
                while($row=mysql_fetch_array($result)){
                    $uid=$row["send"];
                    $sql1="select * from users where id=$uid";
                    $result1=mysql_query($sql1);
                    $row2=mysql_fetch_array($result1);
                    $src=$row2["userimg"];
                ?>
                    <div class="media" style="position:relative;left:105px">
                        <a  class="pull-left"><img src=<?php echo $src;?> class="media-object"  style="width:80px;height=80px" /></a>
                        <div class="media-body" style="background-color: #FFFFFF;width:672px;height: 80px">
                            <h4 class="media-heading">
                                <a><?php echo $row2["username"]; ?></a>
                            </h4>
                            <?php echo $row["content"]; ?>
                        </div>
                    </div>
                <?php
                }
                if($_SESSION["permission"]!=-3&&$_SESSION["permission"]!=-1) {
                    echo " <div class='media' style='left:105px;position:relative'>
                <form action='showItemDetail.php?id=$id' method='post'>
                <textarea id='cont'name='cont' class='form-control'  rows='3'style='width:450px'></textarea>
                <button class='btn btn-default' type='submit'>評論</button>
                </form>
                </div>";
                }
                ?>
            </div>
        </div>
        <div class="col-md-1 column">

        </div>
    </div>

</div>

<!--百度联盟广告-->
</div>
</div>
</body>
</html>
