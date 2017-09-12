<?php
/**
 * Created by PhpStorm.
 * User: caolina
 * Date: 15/5/22
 * Time: 下午1:59
 */
$db_server = "localhost";
$db_user = "root";
$db_passwd = "Wwm19940419";
$db_name = "nthustore";
$dsn = "mysql:host=$db_server;dbname=$db_name";
$dbh = new PDO($dsn, $db_user, $db_passwd);
$dbh->exec("SET NAMES utf8mb4");
session_start();
/*select 用法*/
if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $sql = "SELECT * FROM users WHERE id=?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($id));
    $row = $sth->fetch(PDO::FETCH_ASSOC);

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
    <body>
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">基本信息</h4>
                </div>
                <div class="modal-body">
                    <form role="form" action="./update.php" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">用户名</label>
                            <input type="text" class="form-control" name="username" value=<?php echo $row["username"];?> />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">密码</label>
                            <input type="password" class="form-control" name="password"/>
                            <!--                        <textarea class="form-control" id="exampleInputPassword1"></textarea>-->
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">重複密码</label>
                            <input type="password" class="form-control" name="password1"/>
                            <!--                        <textarea class="form-control" id="exampleInputPassword1"></textarea>-->
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">手機</label>
                            <input type="input" class="form-control" name="phone" value=<?php echo $row["phone"];?>/>
                            <!--                        <textarea class="form-control" id="exampleInputPassword1"></textarea>-->
                        </div>
                        <div id="editor"></div>
                        <!--                    <div class="checkbox">-->
                        <!--                        <label><input type="checkbox" /> Check me out</label>-->
                        <!--                    </div> -->
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <!--                <button type="button" class="btn btn-primary">注册</button>-->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">更換頭像</h4>
                </div>
                <div class="modal-body">
                    <form role="form" action="./updatephoto.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleInputFile">头像</label><input type="file"name="testFile" />
                        </div>
                        <button type="submit" class="btn btn-default" id="send">上傳</button>
                        <div id="editor"></div>
                    </form>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <!--                <button type="button" class="btn btn-primary">注册</button>-->
                </div>
            </div>
        </div>
    </div>
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
                    <li class="active">
                        <a href="./user-info.php" style="background-color: #a6c9e8">个人信息</a>
                    </li>
                    <li >
                        <a href="./user-items.php" >我发布的商品</a>
                    </li>
                    <li>
                        <a href="./user-clc.php">我的收藏</a>
                    </li>
                    <li>
                        <a href="./user-msg.php">消息中心</a>
                    </li>
                    <li class="disabled">
                        <a href="#"></a>
                    </li>

                </ul>
                </br>
                </br>
                <a style="position: absolute ;top:60px ;left:720px" href="" data-toggle="modal" data-target="#registerModal">編輯</a>
                <div class="panel panel-primary">

                    <div class="panel-heading">
                        <h3 class="panel-title">
                            基本信息
                        </h3>
                    </div>
                    <div class="panel-body">
                        用戶名：<?php echo $row["username"];?>
                    </div>
                    <div class="panel-footer">
                        手機：<?php echo $row["phone"];?>
                    </div>
                    <div class="panel-footer">
                        E-mail：<?php echo $row["email"];?>
                    </div>
                </div>

            <div class="col-md-2 column">
            </div>

        </div>

    </div>

    </body>
    </html>
<?php
}else{
    echo "error";
}
?>