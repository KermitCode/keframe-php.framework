<?php

/***********************************
 *Note:		:取PHP配置
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/

class KePhpini
{

	//存储php设置
	
	public static $initArr;


	/***********************************
		获取设置
	 ***********************************/

	public static function getIni($iniKey, $separated = false)
    {

		if(isset(self::$initArr[$iniKey]))
		{
			
			return self::$initArr[$iniKey];
		
		}

		//成功是返回配置选项值的字符串，null 的值则返回空字符串。如果配置选项不存在，将会返回 FALSE。

		self::$initArr[$iniKey] = ini_get($iniKey);
		
		if($separated && self::$initArr[$iniKey] !== false)
		{
		
			self::$initArr[$iniKey] = explode(',', self::$initArr[$iniKey]);
		
		}

		return self::$initArr[$iniKey];
	
	}
	

	

}