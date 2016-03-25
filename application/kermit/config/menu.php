<?php

/***********************************
 *Note:		:管理后台首页控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2016-02
 ***********************************/

return array(
	 '文章及评论管理'=>array(
		'后台管理首页'=>array('u'=>'home/index','i'=>'icon-home'),
		'文章类目列表'=>array('u'=>'class/index','i'=>'icon-list-alt'),
		'新增/修改类目'=>array('u'=>'class/modify','i'=>'icon-edit'),
		'文章列表'=>array('u'=>'page/index','i'=>'icon-folder-open'),
		'发表新文章'=>array('u'=>'page/create','i'=>'icon-plus'),
		'文章评论列表'=>array('u'=>'comment/index','i'=>'icon-envelope'),
		'下载资源列表'=>array('u'=>'download/index','i'=>'icon-arrow-down'),
		'新加/修改资源'=>array('u'=>'download/add','i'=>'icon-arrow-up'),
		),
	'访问及管理员管理'=>array(
		'每日访问用户'=>array('u'=>'day/user','i'=>'icon-calendar'),
		'每日来访蜘蛛'=>array('u'=>'day/engine','i'=>'icon-share-alt'),
		'网站设置'=>array('u'=>'setting/index','i'=>'icon-cog'),
		'用户访问记录'=>array('u'=>'visit/user','i'=>'icon-envelope'),
		'蜘蛛访问记录'=>array('u'=>'visit/engine','i'=>'icon-warning-sign'),
		'友情链接'=>array('u'=>'setting/friend','i'=>'icon-leaf'),
		#'统计分析'=>array('u'=>'home/stat','i'=>'icon-barcode'),
		),
	);