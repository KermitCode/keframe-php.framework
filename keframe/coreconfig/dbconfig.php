<?php

/***********************************
 *Note:		:数据源配置文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/

return array(
	
	/*************************
			mysql配置
	 ************************/
	
	'mysql'=>array(
        
        /*
        KEY建议命名方式使用：db_后缀，在Model中直接使用$this->KEY名即可访问db连接，
		第一个KEY数据库的访问也可以直接使用$this->db访问
		'db_default'=>array(
			'note'=>'',             //数据库连接说明
			'host'=>'',             //数据库连接地址
            'port'=>'',             //数据库连接端口
			'username'=>'',         //数据库连接帐户
			'password'=>'',         //数据库连接密码
			'database'=>'',         //连接的数据库名称
			'charset'=>'',          //使用的字符编码
		),*/

	),
	

	/*************************
			redis配置
	 ************************/

	'redis'=>array(
		
		/*
        建议KEY的命名方式使用：redis_后缀，在Model中直接使用$this->redis_后缀 启动连接Redis
        'redis_local'=>array(
			'note'=>'',             //Redis连接说明
			'host'=>'',             //Redis服务host地址
			'port'=>'',             //Redis连接端口
			'auth'=>'',             //Redis连接密码，没有密码置空
		),*/

	),
	
	/*************************
			接口URL调用地址
	 ************************/
	'interface'=>array(
	
		/*
        建议KEY的命名方式使用：inter_后缀，在Model中直接使用$this->inter_后缀 启动CURL并可调用get/post方法
        'inter_default'=>array(
			'note'=>'',             //接口说明
			'host'=>'',             //接口地址（IP或者域名)
			'port'=>'',             //请求端口
			'baseuri'=>'',          //请求的URI(顶层的URI，各细接口的uri在调用接口时指定)
            'retry'=>2,             //请求次数
		),*/
	
	)
	


);