<?php
/**
 * Created by PhpStorm.
 * User: caolina
 * Date: 2015/5/24
 * Time: 8:57
 */
$db_server = "localhost";
$db_user = "root";
$db_passwd = "Wwm19940419";
$db_name = "nthustore";
$dsn = "mysql:host=$db_server;dbname=$db_name";
$dbh = new PDO($dsn, $db_user, $db_passwd);
$dbh->exec("SET NAMES utf8mb4");
session_start();
if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $sql = "SELECT * FROM users WHERE id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($id));
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    //$result = mysql_query($sql);
    $sql = "select * from message where receive=?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($id));
    //$result2 = mysql_query($sql);
    ?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/html">
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
    <body>
    <div class="container">
        <div class="row clearfix" style="position:relative;top:0px;left:-112px;width:1394px">

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
            <div class="col-md-8 column">
                <div class="row clearfix">
                    <div class="col-md-3 column">
                        <a href="" data-toggle="modal" data-target="#Modal" ><img  style="width:140px;height:133px" src=<?php echo $row['userimg']?> /></a>
                    </div>
                    <div class="col-md-9 column">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    用户:<?php echo $row["username"];?>
                                </h3>
                            </div>
                            <div class="panel-body">當前等級:<?php
                                echo $row["rank"];
                                ?>
                            </div>
                            <div class="panel-footer">
                                當前積分:<?php echo $row["score"];?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 column">
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-2 column">
            </div>
            <div class="col-md-8 column">
                <ul class="nav nav-tabs" style="background-color: #FFFFFF">
                    <li>
                        <a href="./user-info.php">个人信息</a>
                    </li>
                    <li >
                        <a href="./user-items.php">我发布的商品</a>
                    </li>
                    <li>
                        <a href="./user-clc.php">我的收藏</a>
                    </li>
                    <li class="active">
                        <a href="./user-msg.php"  style="background-color: #a6c9e8">消息中心</a>
                    </li>
                    <li class="disabled">
                        <a href="#"></a>
                    </li>

                </ul>
                </br>
                </br>
                <table class="table table-bordered" style="background-color: #FFFFFF">
                    <tbody>
                    <?php
                    while ($row2 = $sth->fetch(PDO::FETCH_ASSOC)) {
                        $sql = "SELECT * FROM users WHERE id=?";
                        $sth1 = $dbh->prepare($sql);
                        $sth1->execute(array($row2['send']));
                        $row3 = $sth1->fetch(PDO::FETCH_ASSOC);
                        ?>
                            <?php
                           $time=$row2['time'];
                            $send=$row3['username'];
                            echo"<tr><td><p style='color:grey;font-size: 7px;font-style:oblique'>$time</p>";
                          //  echo"<p style='color:black;font-size: 7px'></p>";
                            ?>
                            <?php
                        $id=$row2['goods'];
                        $url='http://127.0.0.1/getItem.php?id='.$id;
                        $jsonstr = file_get_contents($url);
                        $datas = json_decode($jsonstr,true);
                        $data=$datas[0];
                        $goods=$data["goodsname"];
                        $goods=nl2br($goods);
                        $goods=str_replace(array("《物品名稱》","→"),"",$goods);
                            if($row2["type"]==1)
                            {  echo"<p style='color:black;font-size: 7px'>$send.評論了您的商品<a  style='font-size:7px' href='showItemDetail.php?id=$gid&read=1'> $goods</a></p>";}
                            else
                            {
                                echo"<p style='color:black;font-size: 7px'>$send.收藏了您的商品<a  style='font-size:7px' href='showItemDetail.php?id=$gid&read=1'> $goods</a></p>";
                            }

                      //  $goods=nl2br($goods);
                       //  echo $goods;
                        echo "</td></tr>";
                            ?>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-2 column">
        </div>

    </div>
    </body>
    </html>

<?php
}
?>