<!DOCTYPE html>
<!--[if lt IE 7 ]><html lang="en" class="ie6 ielt7 ielt8 ielt9"><![endif]--><!--[if IE 7 ]><html lang="en" class="ie7 ielt8 ielt9"><![endif]--><!--[if IE 8 ]><html lang="en" class="ie8 ielt9"><![endif]--><!--[if IE 9 ]><html lang="en" class="ie9"> <![endif]--><!--[if (gt IE 9)|!(IE)]><!--> 
<html lang="en"><!--<![endif]--> 
	<head>
		<meta charset="utf-8">
		<title><?php #echo $this->admin_title;?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="<?php echo $this->getSet('imagesUrl');?>admindir/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $this->getSet('imagesUrl');?>admindir/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="<?php echo $this->getSet('imagesUrl');?>admindir/css/site.css" rel="stylesheet">
        <script src="<?php echo $this->getSet('imagesUrl');?>admindir/js/jquery-1.8.3.min.js"></script>
        <script src="<?php echo $this->getSet('imagesUrl');?>admindir/js/bootstrap.min.js"></script>
		<script src="<?php echo $this->getSet('imagesUrl');?>admindir/js/site.js"></script>
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<div class="container">
        	<div class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> <a class="brand" href="#"><strong><?php #echo $this->admin_title;?></strong></a>
                        <div class="nav-collapse">
                            <ul class="nav pull-right">
                                <li><a href="#">管理员：<?php #echo $_SESSION['adminer'];?></a></li>
                                <li><a href="<?php # echo $this->makeUrl('admin/Index/quit');?>">退出</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
				<div class="span3">
					<div class="well" style="padding: 8px 0;">
                        <ul class="nav nav-list">
                            <li class="nav-header">管理菜单</li>
                            <li<?php #if($this->globalObj->action=='index') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Index/index');?>"><i class="icon-home"></i> 后台管理首页</a></li>
                            <li<?php #if($this->globalObj->action=='record') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Main/record');?>"><i class="icon-folder-open"></i> 数据调用记录</a></li>
                            <li<?php #if($this->globalObj->action=='search') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Main/search');?>"><i class="icon-check"></i> 淘宝搜索缓存列表</a></li>
                            <li<?php #if($this->globalObj->action=='product') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Main/product');?>"><i class="icon-envelope"></i> 淘宝产品缓存列表</a></li>
                            <li<?php #if($this->globalObj->action=='comment') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Main/comment');?>"><i class="icon-envelope"></i> 淘宝评论缓存列表</a></li>
                            
                            <li<?php #if($this->globalObj->action=='searchvip') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Main/searchvip');?>"><i class="icon-fire"></i> VIP搜索缓存列表</a></li>
                            <li<?php #if($this->globalObj->action=='productvip') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Main/productvip');?>"><i class="icon-warning-sign"></i> vip产品缓存列表</a></li>
                            <li<?php #if($this->globalObj->action=='searchvancl') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Main/searchvancl');?>"><i class="icon-cog"></i> VANCL搜索缓存列表</a></li>
                            <li<?php #if($this->globalObj->action=='productvancl') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Main/productvancl');?>"><i class="icon-film"></i> VANCL产品缓存列表</a></li>
                                    
                            <li<?php #if($this->globalObj->action=='pvid') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Index/pvid');?>"><i class="icon-file"></i> PVID值列表</a></li>
                            <li<?php #if($this->globalObj->action=='trans') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Main/trans');?>"><i class="icon-edit"></i> 翻译记录</a></li>
                            <li<?php #if($this->globalObj->action=='analy') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Main/analy');?>"><i class="icon-barcode"></i> 调用次数统计分析</a></li>
                            <li<?php #if($this->globalObj->action=='analytime') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Main/analytime');?>"><i class=" icon-calendar"></i> 抓取耗时统计分析</a></li>     
                             
                            <li class="divider"></li>
                            <li class="nav-header">管理员管理</li>
                            <li<?php #if($this->globalObj->action=='users') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Index/users');?>"><i class="icon-user"></i>管理员列表</a></li>
                            <li<?php #if($this->globalObj->action=='adduser') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Index/adduser');?>"><i class="icon-plus"></i>新增管理员</a></li>
                            <li<?php #if($this->globalObj->action=='useron') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Index/useron');?>"><i class="icon-list-alt"></i>管理员登录记录</a></li>
                            
                            <li class="divider"></li>
                            <li class="nav-header">系统设置等</li>
                            <li<?php #if($this->globalObj->action=='settings') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Index/settings');?>"><i class="icon-cog"></i>系统设置</a></li>
                            <li<?php #if($this->globalObj->action=='token') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Index/token');?>"><i class="icon-forward"></i>TOKEN列表</a></li>
                            <li<?php #if($this->globalObj->action=='addtoken') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Index/addtoken');?>"><i class="icon-flag"></i>新增TOKEN</a></li>
                            <li<?php #if($this->globalObj->action=='info') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Main/info');?>"><i class="icon-share-alt"></i>Redis信息</a></li>
                                
                            <li class="divider"></li>
                            <li class="nav-header">淘宝API相关管理</li>
                            <li<?php #if($this->globalObj->action=='class') echo ' class="active"';?>>
                            	<a href="<?php #echo $this->makeUrl('admin/Api/class');?>"><i class="icon-cog"></i>API类目管理</a></li>  
                        </ul>
                    </div>
				</div>
                
                
                
                
                
                
                
                <div class="clear"></div>
             <hr />
                <ul class="pager footer">
                    <li class="next">青岛阿尔比昂电子商务有限公司 &#8226; 山东 &#8226; 青岛<br />2014 &copy; all rights reserved</li>
                </ul>
			</div>
		</div>
	</body>
</html>