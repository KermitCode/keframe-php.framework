<!DOCTYPE html>
<!--[if lt IE 7 ]><html lang="en" class="ie6 ielt7 ielt8 ielt9"><![endif]--><!--[if IE 7 ]><html lang="en" class="ie7 ielt8 ielt9"><![endif]--><!--[if IE 8 ]><html lang="en" class="ie8 ielt9"><![endif]--><!--[if IE 9 ]><html lang="en" class="ie9"> <![endif]--><!--[if (gt IE 9)|!(IE)]><!--> 
<html lang="en"><!--<![endif]--> 
	<head>
		<meta charset="utf-8">
		<title><?php echo $this->basicData['web_name'];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="<?php echo $this->imagesUrl;?>admindir/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $this->imagesUrl;?>admindir/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="<?php echo $this->imagesUrl;?>admindir/css/site.css" rel="stylesheet">
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<script src="<?php echo $this->imagesUrl;?>admindir/js/jquery.min.js"></script>
		<script src="<?php echo $this->imagesUrl;?>admindir/js/bootstrap.min.js"></script>
		<script src="<?php echo $this->imagesUrl;?>admindir/js/site.js"></script>
		<script language="javascript">
			$(document).ready(function(){
				$.changeCode = function(){
					$("#imgcode").attr('src', $("#imgcode").attr('src'));
				};
				$("#imgcode").click(function(){
					$.changeCode();
				});
			});
		</script>
		<div id="login-page" class="container">
			<center><h3><?php echo $this->basicData['web_name'];?></h3></center>
			<form id="login-form" class="well" action="<?php echo $this->makeUrl('login/login');?>" method="post">
                呢  称：<input type="text" class="span2" placeholder="Username" name="username" /><br />
                密  码：<input type="password" class="span2" placeholder="Password" name="password" /><br />
                <div style="vertical-align:middle;">
                验  证：<input type="text" class="span1" placeholder="Code" name="code" />&nbsp;
                <img src="<?php echo $this->makeUrl('login/code',array('k'=>rand(0,100000)));?>" style="vertical-align:middle;margin-top:-10px;" id="imgcode">
                </div><br>
                <button type="submit" class="btn btn-primary">点击登录</button>&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn" onClick="javascript:$.changeCode();">更换验证码</button>
            </form>
		</div>
		
	</body>
</html>