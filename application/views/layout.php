<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title><?php echo $this->web_name;?></title>
<meta name="Keywords" content="<?php echo $this->web_keyword;?>" />
<meta name="Description" content="<?php echo $this->web_description;?>" />
<meta name="viewport" content="width=device-width" />
<link rel='stylesheet' href='<?php echo $this->imagesUrl;?>frontdir/css/bootstrap.css?ver=4.1.1' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo $this->imagesUrl;?>frontdir/css/styles.css?ver=4.0.3' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo $this->imagesUrl;?>frontdir/css/style.css?ver=4.1.1' type='text/css' media='all' />
<script src="<?php echo $this->imagesUrl;?>admindir/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo $this->imagesUrl;?>frontdir/js/bootstrap.js"></script>
<!--[if lt IE 9]>
<script src="<?php echo $this->imagesUrl;?>frontdir/js/html5.js" type="text/javascript"></script>
<![endif]-->
<style type="text/css" id="custom-css"></style>
<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
</head>

<body class="wordpress ltr en en-us child-theme multisite blog-8 y2015 m03 d14 h14 saturday logged-out singular singular-post singular-post-582 group-blog layout-2c-l">
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">04007.cn</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $this->webUrl.$this->baseUrl;?>"  title="Magazine"><span>04007.cn</span></a>    
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul id="menu-short" class="nav navbar-nav">
                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home first menu-item-1852">
                <a href="<?php echo $this->baseUrl;?>">首页</a></li>
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-1721 dropdown">
                <a title="About The Tests" href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">文章分类 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    	<?php foreach($this->categoryArr as $cid=>$crow){?>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page">
                        <a title="<?php echo $crow['cfn'];?>" href="<?php echo $this->makeUrl('Php/list',array('type'=>strtolower($crow['cn'])));?>"><?php echo $crow['cfn'];?></a></li>
                        <?php }?>
                    </ul>
                </li>
                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home first menu-item-1852">
                <a title="资源下载" href="<?php echo $this->makeUrl('download/index');?>">资源下载</a></li>
                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home first menu-item-1852">
                <a title="KeFrame框架" href="<?php echo $this->makeUrl('keframework');?>">KeFrame框架</a></li>
            </ul>
        </div>  
      </div><!-- /.container -->
    </nav>

<div class="site-container">

	<header id="header" class="site-header" role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
    	<div class="container">
        	<div class="row">
            	<div class="title-area col-xs-12 col-md-4">
                	<h2 class="site-title" itemprop="headline">
                    <a href="<?php echo $this->webUrl.$this->baseUrl;?>" title="Magazine" rel="home">04007.cn</a>
                    </h2>
                    <h3 class="site-description">
                    <span>读不在三更五鼓，功只怕一曝十寒。</span>
                    </h3>
                </div>
				<aside class="col-xs-12 col-md-8 header-right widget-area sidebar">
                	<section id="search-2" class="widget widget-1 even widget-first widget_search">
                    	<div class="widget-wrap">
                        	<form role="search" method="get" class="search-form" action="<?php echo $this->makeUrl('search/index');?>">
								<input type="search" class="search-field" placeholder="Search ..." value="<?php
                                if(isset($this->query)) echo $this->query;?>" name="q">
								<input type="submit" class="search-submit" value="Search">
							</form>
						</div>
                    </section>
  				</aside>
			</div>
            <!-- .row -->
        </div>
        <!-- .container -->
    </header>
    <!-- .site-header -->	

	<div class="container">
		<nav class="navbar navbar-default nav-secondary" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".menu-secondary">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">全站文章分类</a>
            </div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse menu-secondary">
        	<ul class="nav navbar-nav">
            	<li class="menu-item menu-item-type-taxonomy menu-item-object-category current-post-ancestor current-menu-parent current-post-parent first menu-item-1853<?php echo $this->type=='homeindex'?' active':'';?>"><a title="Post Formats" href="<?php echo $this->baseUrl;?>">最新</a></li>
                <?php foreach($this->categoryArr as $cid=>$crow){
						$active=strcasecmp($crow['cn'],$this->type)===0?' active':'';  
						?>
                <li class="menu-item menu-item-type-taxonomy menu-item-object-category<?php echo $active;?>">
                <a title="<?php echo $crow['cn'];?>" href="<?php echo $this->makeUrl('Php/list',array('type'=>strtolower($crow['cn'])));?>"><?php echo $crow['cn'];?></a></li>
                <?php }?>
			</ul>
        </div>  
	</nav>
    <!-- .nav-secondary -->
</div>
<!-- /.container -->

	<div class="site-inner">
		<div class="container">
            <div class="row">
                <main class="col-xs-12 col-sm-9" id="content">
                <?php echo $KeContent;?> 
            	</main>

				<aside class="sidebar col-xs-12 col-sm-3">
                    <a href="<?php echo $this->makeUrl('keframework');?>">
                        <button type="button" class="btn btn-success" id="keframe">本站所用框架及本站源码下载</button>
                    </a>
                    <section id="categories-2" class="widget widget-3 even widget_categories" style="margin-top:15px;">
                        <div class="widget-wrap">
                            <h4 class="widget-title">微信扫码赠小费-^_^!</h4>
                            <img src="<?php echo $this->fullUrl;?>/uploads/04007cn.jpg">
                            <!-- <img src="<?php echo $this->webUrl;?>/uploads/04007.cn.png"><br>
                            <img src="<?php echo $this->webUrl;?>/uploads/qq.png"> -->
                        </div>
                    </section>

                    <section id="recent-posts-2" class="widget widget-1 even widget-first widget_recent_entries">
                        <div class="widget-wrap">
                            <h4 class="widget-title">推荐文章</h4>		
                            <ul>
                            	<?php foreach($this->ArticleTui as $id=>$title){?>
                                <li><a href="<?php echo $this->makeUrl('Article/view',array('id'=>$id));?>" title="<?php echo stripslashes($title);?>"><?php echo stripslashes($title);?></a></li>
                                <?php }?>
                            </ul>
                        </div>
                    </section>
                    
                    <section id="categories-2" class="widget widget-3 even widget_categories">
                        <div class="widget-wrap">
                            <h4 class="widget-title">月份归档 <small> (共计：<?php echo array_sum($this->monthArr);?>)</small></h4>		
                            <ul>
                            	<?php foreach($this->monthArr as $month=>$num){?>
                                <li class="cat-item cat-item-2"><a href="<?php echo $this->makeUrl('Article/month',array('yd'=>$month));?>" ><?php echo "{$month}发表篇数 ({$num})";?></a></li>
                                <?php }?>
                            </ul>
                        </div>
                    </section>
                    
					<section id="categories-2" class="widget widget-3 even widget_categories">
                        <div class="widget-wrap">
                            <h4 class="widget-title">最新评论</h4>		
                            <ul>
                            	<?php foreach($this->commentArr as $key=>$row){?>
                                <li class="cat-item cat-item-2"><a href="<?php echo $this->makeUrl('Article/view',array('id'=>$row['id']));?>" ><?php echo $row['text'];?></a></li>
                                <?php }?>
                            </ul>
                        </div>
                    </section>
                    
                    <?php if($this->controller=='home' && $this->action=='index' && $this->link){?>
                    <section id="categories-2" class="widget widget-3 even widget_categories">
                        <div class="widget-wrap">
                            <h4 class="widget-title">友情链接</h4>		
                            <ul>
                            	<?php foreach($this->link as $name=>$url){?>
                                <li class="cat-item cat-item-2"><a href="<?php echo $url;?>" target="_blank" ><?php echo $name;?></a></li>
                                <?php }?>
                            </ul>
                        </div>
                    </section>
                    <?php }?>
 
               </aside><!-- .sidebar -->
		  </div><!-- .row -->
      </div><!-- .container -->
  </div><!-- .site-inner -->

	<footer id="footer" class="site-footer">
    	<div class="container">
        	<div class="row">
            	<div class="footer-content footer-insert">
                	<p class="copyright">Copyright ©  2015 - 2115.</p>
					<p class="credit">Powered by <a href="<?php echo $this->webUrl;?>" title="04007.cn">04007.cn</a>. <?php echo $this->webset['web_beian'];?></p>
                </div>
            </div><!-- .row -->
        </div><!-- .container -->
    </footer><!-- .site-footer -->
</div><!-- .site-container -->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?9c202a22e46ab48498983a7a2047665c";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>