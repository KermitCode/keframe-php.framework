<?php

/***********************************
 *Note:		:字符串处理类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
abstract class KeRedisbase extends KeException
{
	
	protected static $__Instance = array();

    protected static $__config = NULL;


    /***********************************
		    初始化Redis资源
	 ***********************************/

	protected static function init($redis, $redisconfig)
    {
        try
        {

            $Redis = KeException::__getExtension('Redis');

            @$Redis->connect(self::$__config->$redis->host, self::$__config->$redis->port);

            if(isset(self::$__config->$redis->auth) && self::$__config->$redis->auth)
            {
            
                @$Redis->auth(self::$__config->$redis->auth);
                
            }

            if($Redis->getLastError())
            {
                
                throw new Exception($Redis->getLastError());

            }
            
        }catch(Exception  $e){

			KeDebug::errorExit("Redis Connect Failed:". $e->getMessage().', Link Config:'.(self::$__config->$redis->host).':'.(self::$__config->$redis->port).(self::$__config->$redis->auth?' with auth ***':''));
		
		}

        return $Redis;

	}
	
    

}