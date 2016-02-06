<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index,follow">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
    <meta name="format-detection" content="adress=no">
    <title>午安网 - 过你想过的生活</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/wuan.css">
</head>
<body>
<!-- file="head.html"-->
<!-- head start-->
<div class="nav navbar navbar-fixed-top navbar-head-color navbar-head">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="navbar-brand navbar-header">
                    <a class="" href="index.php">午安网</a>
                </div>
                <div class="pull-left hidden-sm hidden-xs">
                    <ul class="list-inline">
                        <li><a href="index.php">发现</a></li>
                        <li><a href="myGroup.php">我的星球</a></li>
                        <li><a href="groups.php">全部星球</a></li>
                    </ul>
                </div>
                <div class=" pull-right">
                    <ul class="list-inline">
                        <li><?php
                           $userurl=$_SERVER['REQUEST_URI'];
                            setcookie('userurl',$userurl);

                            if(isset($_COOKIE['nickName'])){
                                $nickName=base64_decode($_COOKIE['nickName']);
                                echo '<a href="myGroup.php">';
                                echo $nickName.'</a></li>';
                            }else{
                                echo '<a href="login.php">登录</a></li>';
                            }
                            ?>
                        <li><?php
                            if(isset($_COOKIE['nickName'])){
                                echo '<a href="exit.php">退出</a></li>';
                            }else{
                                echo '<a href="reg.php">注册</a></li>';
                            }
                            ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- head end-->
<!-- file="nav.html"-->
<!-- mobile nav-->
<div class="hidden-md hidden-lg mobile-nav navbar-fixed-top">
    <div class="container">
        <ul class="list-inline">
            <li class="active"><a href="index.php">发现</a></li>
            <li><a href="myGroup.php">我的星球</a></li>
            <li><a href="groups.php">全部星球</a></li>
        </ul>
    </div>
</div>
<!-- framework-->
<!-- content-->
<div class="framework-content">
    <div class="container">
        <div class="row">
            <!-- main framework-->
            <div class="col-md-12">
                <section>
                    <div class="delete-float">
                        <h2 class="pull-left">发现</h2>
                    </div>
                    <!-- 请判断帖子是否存在图片需要展示，判断后决定输出的模板 第一个是有图 第二个是无图-->
                    <?php
                    include "conn.php";
                    //小组分页
                    $sql="select ID from post_base";
                    $query=mysql_query($sql);
                    $all_num=mysql_num_rows($query);//总条数
                    $page_num=20;//每页条数
                    $page_all_num=ceil($all_num/$page_num);//总页数
                    $page=empty($_GET['page'])?1:$_GET['page'];//当前页数
                    $page=(int)$page;//安全强制转换
                    $limit_st=($page-1)*$page_num;//起始数
                    //显示帖子列表

                    $sql="SELECT pb.title,pd.ID,pd.text,MAX(pd.createTime) AS createTime,ub.nickName,gb.name,gb.ID as Gid
                          FROM post_detail pd,post_base pb ,group_base gb,user_base ub
                          WHERE pb.ID=pd.ID AND pb.userID=ub.ID AND pb.groupID=gb.ID
                          GROUP BY ID
                          ORDER BY MAX(pd.createTime) DESC
                          LIMIT $limit_st,$page_num";
                    $result = mysql_query($sql);
                    while($row = mysql_fetch_array($result))
                    {
                        ?>

                        <article>
                            <?php
                            echo "<h3><a href=\"posts.php?P_ID=". $row['ID'] ."\">". $row['title'] ."</a></h3>";
                            ?>
                            <div class="delete-float">
                                <div>
                                    <?php
                                    echo "<p>". $row['text'] ."</p>";
                                    ?>
                                </div>

                            </div>
                            <footer class="footer">
                                <?php
                                echo "<span class=\"pull-left\"><a href=\"\">". $row['nickName'] ."</a> 发表于 <a href=\"enterLists.php?groupID=". $row['Gid'] ."\">". $row['name'] ."</a></span>";
                                echo "<span class=\"pull-right\">". substr($row['createTime'],0,16) . "</span>";
                                ?>
                            </footer>
                        </article>
                        <?php
                    }
                    $px=$page>=$page_all_num?$page_all_num:$page+1;//下一页
                    $ps=$page<=1?1:$page-1;//上一页
                    ?>

                </section>
            </div>

        </div>
    </div>
</div>
<!-- file="page.html"-->
<!-- page-->
<div class="container page-nav ">
    <div class="row">
        <div class="col-md-12 hidden-lg hidden-md">
            <ul class="list-unstyled list-inline ">
                <li><a href="index.php?page=<?php echo $ps?>">上一页</a></li>
                <li><?php echo  $page." / ".$page_all_num ?></li>
                <li><a href="index.php?page=<?php echo $px?>">下一页</a></li>
            </ul>
        </div>

    </div>
</div>
<div class="container hidden-sm hidden-xs delete-float">
    <nav class="text-center">
        <ul class="pagination">
            <li>
                <a href="index.php?page=<?php echo $ps?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php
            if ($page_all_num>=5) {
                if ($page <= 3) {
                    for ($num = 0; $num < 5; $num++) {
                        $page1= 1 + $num;
                        echo "<li><a href=\"index.php?page=$page1\">$page1</a></li>";
                    }
                } elseif ($page > 3 && $page+4<=$page_all_num) {
                    for ($num = 0; $num < 5; $num++) {
                        $page_ = $page + $num - 2;
                        echo "<li><a href=\"index.php?page=$page_\">$page_</a></li>";
                    }
                }else {
                    for ($num=0; $num < 5; $num++) {
                        $x=$page_all_num-3;
                        $page_ =$x + $num - 1;
                        echo "<li><a href=\"index.php?page=$page_\">$page_</a></li>";
                    }
                }
            }else{
                for($x=1;$x<=$page_all_num;$x++){
                    echo "<li><a href=\"index.php?page=$x\">$x</a></li>";
                }
            }
            ?>
            <li>
                <a href="index.php?page=<?php echo $px?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<script src="js/jquery-1.11.3.min.js"></script>
</body>
</html>
