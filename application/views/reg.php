<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <title>注册</title>
    <link rel="stylesheet" href="<?=BASEURL;?>/static/css/page.css">
    <link rel="stylesheet" href="<?=BASEURL;?>/static/css/home.css">
</head>

<body>
<div class="container">
    <div class="top-bar">
        <h1 class="wrapper">
            <img src="<?=BASEURL;?>/static/img/logo.png" alt="">
        </h1>
    </div>
    <form action="/index.php?c=reg&m=onreg">
        <ul class="register">
            <li class="notes">
                <p>注册过程中遇到任何问题，可以联系客服: 15901071586 </p>
            </li>
            <li class="name">
                <div>
                    公司名称
                </div>
                <input type="text" name="name" placeholder="请填写公司或机构名称">
                <span>请填写公司名称</span>
            </li>
            <li class="location">
                <div>
                    公司地址
                </div>
                <input type="text" name="address" placeholder="请填写公司地址">
                <span>请填写公司地址</span>
            </li>
            <li>
                <div>
                    公司地点标签
                </div>
                <input type="text" name="tagid[]" placeholder="请填写公司或机构名称">
                <span>请选择地点标签</span>
            </li>
            <li>
                <div>
                    招聘负责人
                </div>
                <input type="text" name="master" placeholder="请填写真实姓名">
                <span>请填写负责人姓名</span>
            </li>
            <li>
                <div>
                    联系电话
                </div>
                <input type="text" name="tel" placeholder="请填写联系电话">
                <span>请填写联系电话</span>
            </li>
            <li class="email">
                <div>
                    电子邮箱
                </div>
                <input type="text" name="email" placeholder="请填写简历接收邮箱">
                <span>请填写邮箱</span>
            </li>
            <li class="image">
                <div>
                    营业执照副本
                </div>
                <span class="upload-button">上传</span>
                <span class="notes">上传图片请控制在2M以内</span>
                <span>请填写邮箱</span>
            </li>
            <li>
                <div>
                    <input type="hidden" name="license">
                    营业执照副本
                </div>
                <div class="introduction">
                    <textarea name="intro" id="" cols="30" rows="10" placeholder="请填写公司简介"></textarea>
                    <span><em>0</em>/200</span>
                </div>
            </li>
            <li>
                <button type="submit" class="submit">立即注册</button>
            </li>
        </ul>
    </form>
</div>
</body>

</html>