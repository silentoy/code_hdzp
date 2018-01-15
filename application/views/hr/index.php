<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>个人中心</title>
    <link rel="stylesheet" href="<?=BASEURL;?>/static/css/page.css">
    <link rel="stylesheet" href="<?=BASEURL;?>/static/css/home.css">
</head>
<body>
<div class="container clearfix">
    <div class="headers">
        <div class="header-left">
            <a href="#">
                <img src="<?=BASEURL;?>/static/img/logo.png" alt="">
            </a>
            <span>(管理员后台)</span>
        </div>
        <div class="header-right">
            <a href="#"></a>，
            <a href="#">退出</a>
        </div>
    </div>
    <div class="nav-view">
        <ul>
            <li class="selected">
                <a href="">
                    <i class="nav1"></i>
                    公司管理
                </a>
            </li>
            <li>
                <a href="">
                    <i class="nav2"></i>
                    职位管理
                </a>
            </li>
            <li>
                <a href="">
                    <i class="nav3"></i>
                    标签和通知管理
                </a>
            </li>
            <li>
                <a href="">
                    <i class="nav4"></i>
                    标签和通知管理
                </a>
            </li>
        </ul>
    </div>
    <div class="contrast">
        <!-- 免费用户 升级VIP -->
        <?php if ($data['hrInfo']['ulevel']==1) { ?>
        <div class="upgrade">
            <p>您目前是 <span>免费用户</span> 升级 <span>VIP用户</span> 请联系：15901071586</p>
        </div>
        <?php } ?>
        <?php if ($data['hrInfo']['ulevel']==2) { ?>
        <div class="upgrade">
            <p>您目前是 <span>VIP用户</span> 剩余 <span><?=ceil(($data['hrInfo']['vip_end']-TIMESTAMP)/86400);?>天</span> 有效期至<?=date("Y-m-d", $data['hrInfo']['vip_end']);?>  续费请联系：15901071586</p>
        </div>
        <?php } ?>
        <?php if ($data['hrInfo']['ulevel']==3) { ?>
        <div class="upgrade">
            <p>您目前是 <span>待审核用户</span> 有问题请联系：15901071586</p>
        </div>
        <?php } ?>

        <div class="total">
            <span class="visit">职位：<var>65</var></span>
            <span>访问量：<var>2585</var></span>
        </div>
        <div class="notice">
            <h3>系统通知</h3>
            <ul class="notice-list">
                <li>
                    <span class="time">2017-1-13</span>
                    <a href="#">关于举办海淀招聘首场线下发布会的通知</a>
                </li>
                <li>
                    <span class="time">2017-1-13</span>
                    <a href="#">关于举办海淀招聘首场线下发布会的通知</a>
                </li>
                <li>
                    <span class="time">2017-1-13</span>
                    <a href="#">关于举办海淀招聘首场线下发布会的通知</a>
                </li>
                <li>
                    <span class="time">2017-1-13</span>
                    <a href="#">关于举办海淀招聘首场线下发布会的通知</a>
                </li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>