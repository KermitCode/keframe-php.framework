<?php

/***********************************
 *Note:		:字符串处理类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
final class KeRedis extends KeRedisbase implements KeData
{


    /***********************************
		    阻止对redis类进行实例化
	 ***********************************/

	private function __construct()
    {

	}


    /***********************************
		    redis数据配置
	 ***********************************/

    public static function __config($config)
    {
        
        if(!self::$__config)
        {

            self::$__config = ArrObjHelp::arrayToObject($config);
        
        }else{
        
            self::$__config = ArrObjHelp::arrayToObject(array_merge(ArrObjHelp::objectToArray(self::$__config), $config)); 

        }

    }


    /***********************************
		    取得Redis资源
	 ***********************************/

    public static function __getInstance($redis)
    {

        if(isset(self::$__Instance[$redis])) return self::$__Instance[$redis];

        if(!isset(self::$__config->$redis))
        {
            
            trigger_error("no redis config:{$redis} in dbconfig!");
            
            exit;

        }

        self::$__Instance[$redis] = parent::init($redis, self::$__config->$redis);

        return self::$__Instance[$redis];

    }


    /***********************************
		    外部取得Redis配置
	 ***********************************/

    public static function __checkConfigIndex($key)
    {

        return isset(self::$__config->$key);
    
    }
	
}