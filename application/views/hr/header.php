<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>个人中心</title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/static/css/page.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/static/css/home.css">
</head>
<body>
<div class="container clearfix">
    <div class="headers">
        <div class="header-left">
            <a href="#">
                <img src="<?= BASEURL; ?>/static/img/logo.png" alt="">
            </a>
            <span>(HR后台)</span>
        </div>
        <div class="header-right">
            <a href="#"><?=GLOBAL_USER['name']?></a>，
            <a href="#">退出</a>
        </div>
    </div>
    <div class="nav-view">
        <ul>
            <li <?php if (!isset($_GET['m']) || $_GET['m']=='index') { ?>class="selected"<?php } ?>>
                <a href="/index.php?c=hr">
                    <i class="nav1"></i>
                    后台首页
                </a>
            </li>
            <li <?php if (isset($_GET['m']) && strtolower($_GET['m'])=='positionadd') { ?>class="selected"<?php } ?>>
                <a href="/index.php?c=hr&m=positionAdd">
                    <i class="nav2"></i>
                    新建职位
                </a>
            </li>
            <li <?php if (isset($_GET['m']) && strtolower($_GET['m'])=='positionlist') { ?>class="selected"<?php } ?>>
                <a href="/index.php?c=hr&m=positionList">
                    <i class="nav3"></i>
                    职位列表
                </a>
            </li>
            <li>
                <a href="/index.php?c=hr&m=vip">
                    <i class="nav4"></i>
                    升级VIP
                    <em></em>
                </a>
            </li>
        </ul>
    </div>
    <div class="contrast">
        <!-- 免费用户 升级VIP -->
        <?php if ($hrInfo['ulevel'] == 1) { ?>
            <div class="upgrade">
                <p>您目前是 <span>免费用户</span> 升级 <span>VIP用户</span> 请联系：15901071586</p>
            </div>
        <?php } ?>
        <?php if ($hrInfo['ulevel'] == 2) { ?>
            <div class="upgrade">
                <p>您目前是 <span>VIP用户</span> 剩余 <span><?=ceil(($hrInfo['vip_end'] - TIMESTAMP) / 86400); ?>
                        天</span> 有效期至<?= date("Y-m-d", $hrInfo['vip_end']); ?> 续费请联系：15901071586</p>
            </div>
        <?php } ?>
        <?php if ($hrInfo['ulevel'] == 3) { ?>
            <div class="upgrade">
                <p>您目前是 <span>待审核用户</span> 有问题请联系：15901071586</p>
            </div>
        <?php } ?>
