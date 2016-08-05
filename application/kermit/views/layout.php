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
        <script src="<?php echo $this->imagesUrl;?>admindir/js/jquery-1.8.3.min.js"></script>
        <script src="<?php echo $this->imagesUrl;?>admindir/js/bootstrap.min.js"></script>
		<script src="<?php echo $this->imagesUrl;?>admindir/js/site.js"></script>
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<div class="container-fluid">
        	<div class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
                        	<span class="icon-bar"></span> 
                            <span class="icon-bar"></span> 
                            <span class="icon-bar"></span> 
                        </a> 
                        <a class="brand" href="#">
                        	<strong><?php echo $this->basicData['web_name'];?></strong>
                        </a>
                        <div class="nav-collapse">
                            <ul class="nav pull-right">
                                <li><a href="#">管理员：<?php echo $_SESSION['adminer'];?></a></li>
                                <li><a href="<?php echo $this->makeUrl('login/quit');?>">退出</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
				<div class="span2">
					<div class="well" style="padding: 0px 0;">
                        <ul class="nav nav-list">
                        <?php foreach($this->menuData as $name=>$row){?>
                        	<li class="nav-header"><?php echo $name;?></li>
                        	<?php foreach($row as $n=>$r){?>
                            <li<?php echo $r['c'];?>>
                            	<a href="<?php echo $this->makeUrl($r['u']);?>">
                                <i class="<?php echo $r['i'];?>"></i><?php echo $n;?></a>
                            </li>
                            <?php }?>
                        <?php }?>
                        </ul>
                    </div>
				</div>

                <?php echo $KeContent;?> 

                <div class="clear"></div>
                <ul class="pager footer">
                    <li class="next">04007.cn &#8226; 中国 &#8226; 山东 &#8226; 青岛 &#8226; Kermit<br />2015-2025 &copy; all rights reserved</li>
                </ul>
			</div>
		</div>
	</body>
</html>
                