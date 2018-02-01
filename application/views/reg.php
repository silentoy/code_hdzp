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
            <li class="selectTags">
                <div>
                    公司地点标签
                </div>
                <div class="select" id="selectTags">
                    <em>请选择公司地点标签</em>
                    <ul name="tagid" id="tags">
                        <?php foreach($tags as $item) { ?>
                            <li data-id="<?=$item['id'];?>"><?=$item['name'];?></li>
                        <?php } ?>
                    </ul>
                </div>
                <!-- <input type="text" name="tagid[]" placeholder=""> -->
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
              <label class="upload-button">上传<input type="file" class="upLoadImg" id="upLoadImg" accept="image/*"></label>
              <span class="notes">上传图片请控制在2M以内</span>
              <span>请上传营业执照副本电子版</span>
            </li>
            <li id="imgList" class="img-list">
                <figure></figure>
                <span>重新上传<input class="upLoadImg" type="file"accept="image/*"></span>
            </li>
            <li>
                <div>
                    公司简介
                </div>
                <div class="introduction">
                    <textarea name="intro" id="regLicense" maxlength="200" cols="30" rows="10" placeholder="请填写公司简介"></textarea>
                    <span><em id="regLicenseNumber">0</em>/200</span>
                </div>
            </li>
            <li>
                <div class="submit" id="regBtn">立即注册</div>
            </li>
        </ul>
    </form>
</div>
<!-- 注册成功弹层 -->
<div class="mask reg-success" id="regSuccess" style="display:none">
    <div class="mask-content">
        <p>恭喜你，注册成功</p>
        <p>您的密码是 <em>K6YU8879</em>  请牢牢记住或写到本子上</p>
        <p>密码无法更改，忘记密码请联系客服: 15901071586</p>
        <div class="footer">
            <span class="determine">确认</span>
        </div>
    </div>
</div>

<!-- 失败弹窗 -->
<div class="mask error-pop" id="errorPop" style="display:none">
    <div class="title">
        <p>注册失败</p>
        <span class="shutBox">关</span>
    </div>
    <div class="mask-content">
        <p>名称重复了</p>
        <div class="footer">
            <span class="determine">确认</span>
        </div>
    </div>
</div>
    <script src="<?=BASEURL;?>/static/js/jquery.js"></script>
    <script src="<?=BASEURL;?>/static/js/home.js"></script>
</body>

</html>