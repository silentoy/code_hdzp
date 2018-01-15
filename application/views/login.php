<!DOCTYPE html>
<html lang="zh">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>登录</title>
	<link rel="stylesheet" href="<?=BASEURL;?>/static/css/page.css">
	<link rel="stylesheet" href="<?=BASEURL;?>/static/css/home.css">
</head>

<body>
<div class="login-page">
	<div class="top-bar">
		<h1 class="wrapper">
			<img src="<?=BASEURL;?>/static/img/logo.png" alt="">
		</h1>
	</div>
	<div class="login-content">
		<div class="login-box">
			<div class="greet">
				<img src="<?=BASEURL;?>/static/img/greet.jpg" alt="">
			</div>
			<div class="impot-box">
				<div class="name">
					<img src="<?=BASEURL;?>/static/img/user.png" alt="">
				</div>
				<input type="text" name="name" placeholder="用户名">
				<span class="error">请填写正确的企业名称</span>
			</div>
			<div class="impot-box">
				<div class="name">
					<img src="<?=BASEURL;?>/static/img/password.png" alt="">
				</div>
				<input type="text" name="password" placeholder="密码">
				<span class="error">请填写密码</span>
			</div>
			<?php if($falseNum > 3)  { ?>
			<div class="code">
				<input type="text" name="code">
				<div class="img">
					<img src="/index.php?c=code"
						 onclick="this.src='/index.php?c=code&amp;_' + Math.random()" title="看不清？点击更换另一个验证码。"
						 alt=""></div>
				<a href="" class="">换一张</a>
			</div>
			<?php } ?>
			<button type="submit" class="button">
				提交
			</button>
			<div class="menu">
				<a href="/index.php?c=reg">企业用户注册</a>
				<a class="forget-pass" href="">忘记密码</a>
			</div>
		</div>
	</div>
	<div class="footer-bar">
		客服联系电话： 15901071586
	</div>
</div>
</body>

</html>