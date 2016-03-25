<?php

/***********************************
 *Note:		:手机版相关处理类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
class WapHelp
{
	
	private static $__userAgent;


	/***********************************
			搜索引擎标记
	 ***********************************/

	public static function initAgent($agent)
	{
	
		self::$__userAgent = strtolower($agent);
	
	}


	/***********************************
			搜索引擎标记
	 ***********************************/
	
	public static function getSpriderArr()
	{
		
		return array(
				'Google'=>'googlebot',
				'Googleadsense'=>'mediapartners-google',
				'Baidu'=>'baiduspider',
				'MSN'=>'msnbot',
				'360'=>'360spider',
				'Yodao'=>'yodaobot',
				'YahooSlurp'=>'slurp;',
				'Iask'=>'iaskspider',
				'Sogouweb'=>'sogou web spider',
				'Sogoupush'=>'sogou push spider',
				'Sohu'=>'sohu-search',
				'Lycos'=>'lycos',
				'Robozilla'=>'robozilla',
				'soso'=>'soso',
				'Microsoft'=>'bing',
				'Yisou'=>'yisouspider',
				
				'Slurp'=> 'inktomi slurp',	
				'Yahoo'=> 'yahoo',
				'Askjeeves'	=> 'askjeeves',
				'fastcrawler'=> 'fastcrawler',
				'infoseek'	 => 'infoseek robot 1.0',
				'yandex'		=> 'yandexbot',
				'Googleadsense2'=> 'mediapartners google',
				'CRAZYWEBCRAWLER'	=> 'crazy webcrawler',
				'adsbot-google'		=> 'adsbot google',
				'feedfetcher-google'	=> 'feedfetcher google',
				'curious-george'	=> 'curious george',
				'MJ12bot' =>'mj12bot'
				);
		
	}
	
	
	/***********************************
			是否是手机访问用户
	 ***********************************/

	public static function isMobile()
	{
	
		$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";
	
		return preg_match($uachar, self::$__userAgent);
		
	}
	

	/***********************************
			检查搜索引擎名称
	 ***********************************/

	public static function checkSprider()
	{
	
		$sprider_arr = self::getSpriderArr();


		//检查蜘蛛类型

		foreach($sprider_arr as $key=>$value)
		{
			
			if(strpos(self::$__userAgent, $value) !== false)
			{
				
				return $key;
			
			}
			
		}

		return false;
		
	}



}