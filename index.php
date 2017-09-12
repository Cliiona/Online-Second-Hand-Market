<?php
session_start();
if(isset($_GET["page"])){
    $page=$_GET["page"];
}else{
    $page=0;
}
$url='http://127.0.0.1/getItems.php?page='.$page;
$jsonstr = file_get_contents($url);
$datas = json_decode($jsonstr,true);
$url='http://127.0.0.1/getCategories.php';
$jsonstr = file_get_contents($url);
$categories = json_decode($jsonstr,true);
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="./js/bootstrap-wysiwyg.js"></script>

    <script>
        $('#editor').wysiwyg();
    </script>

    <style type="text/css">
        .price{
            padding-right: 3px;
            width: 57px;
            height: 30px;
            background-color: #EB5055;
            position: absolute;
            top: 5px;
            right: -5px;
            font-size: 16px;
            color: #FFF;
            line-height: 30px;
            vertical-align: middle;
            text-align: center;
            overflow: visible;
        }
        #editor {overflow:scroll; max-height:300px}
    </style>
    <title></title>
</head>
<body>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">发布新商品</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="./newItem.php" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">标题</label><input type="text" class="form-control" name="title" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">内容</label>
<!--                        <input type="password" class="form-control" id="exampleInputPassword1" />-->
                        <textarea class="form-control" name="content"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile">图片</label><input type="file" id="exampleInputFile" />
                        <p class="help-block">
                            Example block-level help text here.
                        </p>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" /> Check me out</label>
                    </div> <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
<!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">发布新商品</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="./register.php" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">用户名</label>
                        <input type="text" class="form-control" name="username" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">密码</label>
                        <input type="password" class="form-control" name="password" />
<!--                        <textarea class="form-control" id="exampleInputPassword1"></textarea>-->
                    </div>
                    <div id="editor"></div>
                    <div class="form-group">
                        <label for="exampleInputFile">头像</label><input type="file" id="exampleInputFile" />
                        <p class="help-block">
                            Example block-level help text here.
                        </p>
                    </div>
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
<div class="container">
<div class="row clearfix">
    <div class="col-md-12 column">
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="#">Brand</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="#">Link</a>
                    </li>
                    <li>
                        <a href="#">Link</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">Action</a>
                            </li>
                            <li>
                                <a href="#">Another action</a>
                            </li>
                            <li>
                                <a href="#">Something else here</a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="#">Separated link</a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="#">One more separated link</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" />
                    </div> <button type="submit" class="btn btn-default">Submit</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#">Link</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">Action</a>
                            </li>
                            <li>
                                <a href="#">Another action</a>
                            </li>
                            <li>
                                <a href="#">Something else here</a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="#">Separated link</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </div>
</div>
<div class="row clearfix">
<div class="col-md-2 column">
    <ul class="nav nav-stacked nav-pills">

        <li class="active">
            <a href="./index.php">首页</a>
        </li>
        <?php
        foreach($categories as $category) {
            ?>
            <li>
                <a href="#"><?php echo $category["title"]; ?></a>
            </li>
        <?php
        }
        ?>
    </ul>
</div>
<div class="col-md-8 column">
<div class="row">
    <?php
        foreach($datas as $data){
    ?>
            <div class="col-md-4">
                <div class="thumbnail">
                    <div class="price"><?php echo "NT$".$data["price"]; ?></div>
                    <img style="height: 200px;" alt="300x200" src=<?php echo $data["picture"]; ?> />
                    <div class="caption">
                        <h3 style="font-size: larger; height: 50px; overflow: hidden;">
                            <?php echo $data["title"]; ?>
                        </h3>
                        <p style="height: 100px; overflow:hidden;">
                            <?php echo $data["content"]; ?>
                        </p>
                        <p>
                            <a class="btn btn-primary" href=<?php echo "./showItemDetail.php?id=".$data["id"];?>>查看详情</a> <a class="btn" href="#">Action</a>
                        </p>
                    </div>
                </div>
            </div>
    <?php
        }
    ?>











</div>
<ul class="pagination">
    <li>
        <a href=<?php echo "http://www.nthuhw.com/index.php?page=".($page-1);?>>上一頁</a>
    </li>
    <li>
        <a href=<?php echo"http://www.nthuhw.com/index.php?page=".($page);?>><?php echo $page;?></a>
    </li>
    <li>
        <a href=<?php echo"http://www.nthuhw.com/index.php?page=".($page+1);?>><?php echo intval($page)+1;?></a>
    </li>
    <li>
        <a href=<?php echo"http://www.nthuhw.com/index.php?page=".($page+2);?>><?php echo intval($page)+2;?></a>
    </li>
    <li>
        <a href=<?php echo"http://www.nthuhw.com/index.php?page=".($page+3);?>><?php echo intval($page)+3;?></a>
    </li>
    <li>
        <a href=<?php echo"http://www.nthuhw.com/index.php?page=".($page+4);?>><?php echo intval($page)+4;?></a>
    </li>
    <li>
        <a href=<?php echo "http://www.nthuhw.com/index.php?page=".($page+1);?>>下一頁</a>
    </li>
</ul>
</div>
<div class="col-md-2 column">
    <?php
    if($_SESSION['id']==null){
    ?>
        <form role="form" action="./login.php" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">用户名</label><input type="text" class="form-control" name="username" />
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">密码</label><input type="password" class="form-control" name="password" />
            </div>
<!--            <div class="form-group">-->
<!--                <label for="exampleInputFile">头像</label><input type="file" id="exampleInputFile" />-->
<!--                <p class="help-block">-->
<!--                    Example block-level help text here.-->
<!--                </p>-->
<!--            </div>-->
<!--            <div class="checkbox">-->
<!--                <label><input type="checkbox" /> Check me out</label>-->
<!--            </div>-->
            <button type="submit" class="btn btn-default">登录</button>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#registerModal">
                注册
            </button>
        </form>

    <?php
    }else {
        ?>
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
            点击发布内容
        </button>
        <button type="button" class="btn btn-primary btn-lg" >
            <a href="./user-info.php">查看个人信息</a>

        </button>
        <button type="button" class="btn btn-primary btn-lg" >
            <a href="./logout.php">退出登录</a>

        </button>
    <?php
    }
    ?>



</div>
</div>
<div class="row clearfix">
    <div class="col-md-12 column">
    </div>
</div>
</div>
</body>
</html>