<?php

/***********************************
 *Note:		:应用配置文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/

return array(
	
	#时区配置
	'timezone_default' => 'PRC',

	#默认是否启动session
	'session_autostart' => true,

	#输出编码
	'charset_default' => 'utf8',

    #是否在页面上开启调试
	'debug_show'=>false,

	#自动加载的扩展类
	'extendClass'=>array(
		'a'=>APPPATH.'models',			    #如还需要加载类，将路径添加至此
	),
	
	#分页参数
	'pageParam'=>'page',

	#默认控制器
	'defaultController'=>'home',
	
	#默认控制器方法
	'defaultAction'=>'index',

    #缓存配置
    'cache' => array(
        'cache_open'=>1,                    #缓存是否打开，如打开会检查
        'cache_path' => '',                 #默认缓存放在对应项目的cache目录下/，此处可设置子目录，如固定在application目录下可使用 APPPATH.cache
        'cache_time'=> 86400,               #默认缓存时间
    ),

	#日志配置
    'log' => array(
		'level' => 'full',					#值：full|basic; 都包括error错误日志, 慢日志，访问日志；full和basic的区别在full会在访问日志中记录调试的日志
        'split' => 'day',                   #日志文件分割：day:按日存储一个日志文件；hour:按时存储一个日志文件；默认是day
        'folder' => 'Ym',					#留空则日志全部散列在logs目录下，如使用Ym则会按月放文件夹中，如是ymd则是按日放文件夹中
		'slowdbquery'=>1000,				#记录SQL查询耗时多少ms以上的查询日志,单位毫秒
		'slowinterquery'=>1000,				#记录接口调用耗时多少ms以上的查询日志,单位毫秒
    ),

	#URL伪静态配置
	'url_rewrite'=>array(

		'rewrite_open'=>true,				#伪静态开关
		'rewrite_suffix'=>'.html',			#伪静态后缀
		'rewrite_rule'=>array(				#伪静态规则
			'php/<string>'=>"php/list/type/<string>",
			'article/<id>'=>"article/view/id/<id>",
			'download/<id>'=>"download/down/id/<id>",
		),

	),

	#应用异常时控制器方法
	'errorRoute'=>'home/error'

);