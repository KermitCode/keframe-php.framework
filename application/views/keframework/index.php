<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Keframe,php,frameWork,简单,PHP,框架">
    <meta name="description" content="Keframe-一个简单的PHP框架">
    <meta name="author" content="Kermit">
    <link rel="shortcut icon" href="<?php echo $this->imagesUrl;?>keframework/ico/favicon.png">
    <title>Keframe-一个简单的PHP框架</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo $this->imagesUrl;?>bootstrap-3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $this->imagesUrl;?>keframework/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo $this->imagesUrl;?>keframework/css/main.css" rel="stylesheet">
    <!--[if lt IE 9]>
        <script src="<?php echo $this->imagesUrl;?>bootstrap-3.3.5/js/html5shiv.min.js"></script>
        <script src="<?php echo $this->imagesUrl;?>bootstrap-3.3.5/js/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo $this->imagesUrl;?>bootstrap-3.3.5/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo $this->imagesUrl;?>bootstrap-3.3.5/js/bootstrap.min.js"></script>
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Keframe框架</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="https://github.com/KermitCode/keframe-php.framework">框架GitHub下载</a></li>
            <li><a href="http://www.04007.cn/article/99.html">文档下载</a></li>
            <li><a href="http://www.04007.cn">DEMO</a></li>
            <li><a href="http://www.04007.cn/article/99.html">留言</a></li>
            <li><a data-toggle="modal" data-target="#myModal" href="#myModal"><i class="fa fa-envelope-o"></i></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

	<div id="headerwrap">
		<div class="container">
			<div class="row centered">
				<div class="col-lg-8 col-lg-offset-2">
				<h1>KeFrame</b></h1>
				<h2>一个简单的PHP框架</h2>
				</div>
			</div><!-- row -->
		</div><!-- container -->
	</div><!-- headerwrap -->


	<div class="container w">
		<div class="row centered">
			<br><br>
			<div class="col-lg-6">
				<i class="fa fa-heart"></i>
				<h4>关于KeFrame</h4>
				<p style="text-indent:30px;">KeFrame是一个个人开发的简单PHP框架。网上已经有太多的框架，我写此框架只是想有一个简单小巧、拥有基本功能、用起来顺手的框架，于是KeFrame诞生了。如果你觉得去研究市面上的框架比较费力的话，你可以从研究此框架入手。框架仍在持续完善，如发现有不足之处，敬请指正包涵。</p>
			</div><!-- col-lg-4 -->

			<div class="col-lg-3">
				<i class="fa fa-laptop"></i>
				<h4>基本特点</h4>
				<p>
                MVC架构<BR>
                支持数据关系模型 <BR>
                访问日志、慢日志、错误日志<BR>
                配置化、支持多应用<br>
                内附chm简单文档
                </p>
			</div><!-- col-lg-4 -->

			<div class="col-lg-3">
				<i class="fa fa-trophy"></i>
				<h4>作者信息</h4>
				<p>
                    作者：Kermit<br>
                    QQ：956952515 <br>
                    职场：曾任职于Baidu <br>
                    框架实践：简单网站 <a target="_blank" href="http://www.04007.cn">04007.cn</a>
                </p>
			</div><!-- col-lg-4 -->
		</div><!-- row -->
		<br>
		<br>
	</div><!-- container -->
    
    <div id="r">
		<div class="container">
			<div class="row centered">
				<div class="col-lg-8 col-lg-offset-2 text-center"">
					<h4>小事记.</h4>
					<p style="margin:0 auto;width:400px;text-align:left;">
                        1、2012年开始使用YII，CI，ThinkPhp，Laravel框架<br>
                        2、2014年12月开始写KeFrame1.0版<br>
                        3、2015年11月开始升级KeFrame2.0版
                    </p>
				</div>
			</div><!-- row -->
		</div><!-- container -->
	</div>

	<!-- FOOTER -->
	<div id="f">
		<div class="container">
			<div class="row centered">
				
	            KeFrame <span style="font-size:14px;">可免费用于任何用途(非法事情除外).</span><br>
                Kermit | Copyright © 2016-2026  All Rights Reserved.
			</div><!-- row -->
		</div><!-- container -->
	</div><!-- Footer -->

    <script src="<?php echo $this->imagesUrl;?>keframework/js/jquery-1.10.2.min.js"></script>
    <script src="<?php echo $this->imagesUrl;?>keframework/js/bootstrap.min.js"></script>
  </body>
</html>
