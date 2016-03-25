<?php

/***********************************
 *Note:		:框架入口文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/


/***********************************
		框架版本信息
 ***********************************/

define('KEFRAME', 'keframe');

define('KEFRAME_VERSION', 2.0);

define('KEFRAME_AUTHOR', 'Kermit');


/***********************************
		基本路径定义
 ***********************************/

define('APPPATH', ROOTPATH.'application/');		#框架项目目录

define('COREPATH', FRAMEPATH.'coreapp/');		#框架核心类库

define('ASSETPATH', FRAMEPATH.'coreasset/');	#框架扩展类库

define('HELPPATH', FRAMEPATH.'corehelp/');		#框架扩展类库


/***********************************
		加载框架全局核心文件
 ***********************************/

define('KE', 'ke');

define('SUFFIX', '.php');

define('KE_SUFFIX', '.class.php');

require(COREPATH.'KeGlobal'.KE_SUFFIX);


/***********************************
		返回APP应用实例
 ***********************************/

return keGlobal::__init();