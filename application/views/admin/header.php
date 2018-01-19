<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>管理员管理后台</title>
    <?php if (!$_GET['m'] || $_GET['m']=='index') { ?>
    <link rel="stylesheet" href="<?= BASEURL; ?>/static/css/style-index.css" />
    <?php } ?>
    <?php if ($_GET['m']=='companyadd') { ?>
        <link rel="stylesheet" href="<?= BASEURL; ?>/static/css/style-newwork.css" />
    <?php } ?>
    <?php if ($_GET['m']=='positionlist') { ?>
        <link rel="stylesheet" href="<?= BASEURL; ?>/static/css/style-job.css" />
    <?php } ?>
    <?php if ($_GET['m']=='positionadd') { ?>
        <link rel="stylesheet" href="<?= BASEURL; ?>/static/css/style-station.css" />
    <?php } ?>
    <?php if ($_GET['m']=='noticelist') { ?>
        <link rel="stylesheet" href="<?= BASEURL; ?>/static/css/style-hint.css" />
    <?php } ?>
    <?php if ($_GET['m']=='taglist') { ?>
        <link rel="stylesheet" href="<?= BASEURL; ?>/static/css/style-tags.css" />
    <?php } ?>
</head>

<body>
<!-- 公共头 -->
<div class="headers">
    <div class="header-left">
        <a href="#">
            <img src="<?= BASEURL; ?>/static/img/logo.png" alt="">
        </a>
        <span>(管理员后台)</span>
    </div>
    <div class="header-right">
        <a href="#"><?=GLOBAL_USER['name']?></a>，
        <a href="#">退出</a>
    </div>
</div>

<!-- 左侧导航 -->
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
    </ul>
</div>