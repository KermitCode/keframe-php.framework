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
	'home'=>array(
		'name'=>'平台首页',
		'icon'=>'icon-home',
		),
	'datastruct'=>array(
		'name'=>'各中心数据表结构',
		'icon'=>'icon-fire',
		'child'=>array(
			'tp'=>'TP数据表列表',
			'cgoods'=>'C商品中心表列表',
			'bgoods'=>'B商品中心表列表',
			),
		),
	'tpdata'=>array(
		'name'=>'TP数据查询',
		'icon'=>'icon-eye-open',
		'child'=>array(
			'recent'=>'TP最新数据',
			'order'=>'TP订单查询',
			'trade'=>'线上交易中心数据',
			),
		),
	'testdata'=>array(
		'name'=>'测试数据查看(待)',
		'icon'=>'icon-leaf',
		'child'=>array(
			'tp'=>'测试TP数据',
			'goods'=>'测试商品中心数据',
			'trade'=>'测试交易中心数据',
			),
		),
	'antifraud'=>array(
		'name'=>'反作弊测试辅助(待)',
		'icon'=>'icon-tag',
		'child'=>array(
			'newold'=>'新老客操作',
			'balck'=>'黑名单操作',
			'pay'=>'支付记录'
			),
		),
	'hbmoney'=>array(
		'name'=>'余额辅助(待)',
		'icon'=>'icon-list',
		'child'=>array(
			'remain'=>'用户余额数据查询',
			'isuseful'=>'是否可用余额查询',
			'pay'=>'支付记录'
			),
		),
	'goods'=>array(
		'name'=>'商品中心辅助(待)',
		'icon'=>'icon-list-alt',
		'child'=>array(
			'check'=>'团单详情查询',
			'isuseful'=>'是否可用余额查询',
			'pay'=>'支付记录'
			),
		),
	'market'=>array(
		'name'=>'营销辅助(待)',
		'icon'=>'icon-file-text',
		'child'=>array(
			'check'=>'营销数据查询',
			'isuseful'=>'是否可用余额查询',
			'pay'=>'支付记录'
			),
		),
	'spadchongzhi'=>array(
		'name'=>'手机充值辅助(待)',
		'icon'=>'icon-edit',
		'child'=>array(
			'check'=>'手工取消订单',
			'isuseful'=>'营销效果统计',
			'pay'=>'蓝标编号转糯米ID'
			),
		),
	'user'=>array(
		'name'=>'用户中心辅助(待)',
		'icon'=>'icon-user',
		'child'=>array(
			'check'=>'手工取消订单',
			'isuseful'=>'营销效果统计',
			'pay'=>'蓝标编号转糯米ID'
			),
		),
		//   icon-calendar  icon-picture   icon-plus icon-pencil
);