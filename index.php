<?php

/***********************************
 *Note:		:项目入口文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12
  
  keframe:可以做语言上的矮子，但要争做行动上的巨人。

项目目录：
	application:应用程序，包含mvc文件
		controllers:控制器目录
		models:		数据模型目录
		views:		视图目录
		config:		应用配置目录
		cache:		缓存目录
		libraries：	公用加载库目录
        backup:     备份文件目录
        logs:       日志目录
        子系统目录：子系统下重复application下目录
	keframe    :keframe框架程序
	images	   :外网访问资源
	uploads    :上传资源
    .htaccess  :rewrite规则
	index.php  :项目入口文件
***********************************/


/***********************************
		全局错误显示，线上请关闭
 ***********************************/

define('DEBUG', false);


/***********************************
		网站根目录路径
 ***********************************/

define('ROOTPATH', str_replace('\\','/',dirname(__FILE__)).'/');


/***********************************
		框架路径
 ***********************************/

define('FRAMEPATH', ROOTPATH.'keframe/');


/***********************************
		加载Keframe框架入口文件
 ***********************************/

$application = require(FRAMEPATH.'index.php');


/***********************************
		运行项目
 ***********************************/

$application->response();