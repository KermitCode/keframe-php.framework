<?php

/***********************************
 *Note:		:框架缓存类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
final class KeCache extends KeBase implements KeKe
{
	
	//缓存目录路径，配置文件中设置；可调用更改
	
	private static $__catchPath;


	//缓存时间，由配置文件决定，可调用更改;如缓存时间设置为0，则表示永久有效:单位，分钟

	private static $__catchTime;

	const CACHE_SUFFIX = '.cache';


    /***********************************
           实例化Cache类
     ***********************************/

	public function __construct(&$KE=NULL)
    {

		parent::__construct($KE);

	}


    /***********************************
            设置cache配置
     ***********************************/

    public static function setCatchConfig($config)
    {

		$catchPath = APPLICATION_PATH.'cache/';
		
		if($config->cache_path && is_dir($config->cache_path))
		{
			
			$catchPath = rtrim($config->cache_path, '/').'/';
		
		}

        self::$__catchPath = $catchPath;

        self::$__catchTime = $config->cache_time;

		self::checkWritable(self::$__catchPath);
    
    }


    /***********************************
            检查缓存目录可写性
     ***********************************/

    public static function checkWritable($path)
    {
    
        if(!FileHelp::checkWrite($path))
        {

            KeDebug::warning("cann't write cache directory:{$path},please check the right.", __FILE__, __LINE__);
        
        }

        return true;
    
    }


    /***********************************
            更改缓存目录
     ***********************************/

    public function setCachePath($cachePath)
    {
        
        self::$__catchPath = $catchPath;

    }


    /***********************************
            更改缓存时间
     ***********************************/

    public function setCacheTime($cacheTime)
    {
        
        self::$__catchTime = intval($cacheTime);

    }


	/***********************************
            根据KEY得到缓存完全路径
     ***********************************/
	
	private function getFullPath($key)
	{
		
		if(!$key = trim($key, '/'))
		{
			
			KeDebug::error("cacheFileName:{$key} is invalid path", __FILE__, __LINE__);

		}

		return self::$__catchPath.trim($key, '/').self::CACHE_SUFFIX;
	
	}

	
	/***********************************
            写cache:$lifetime分钟
     ***********************************/

	public function write($key, $value, $lifetime=null)
    {
        
		$lifetime = abs(intval($lifetime === null?self::$__catchTime:$lifetime));


		//如缓存时间为0，则表示永久有效
		
		$expire = $lifetime?(time() + 60*$lifetime):'0';
		

		//存储数据中带上过期时间以判断数据是否有效

		$cacheData = array('expire'=>$expire, 'cacheData'=>$value);

		
		//缓存目录有效性检查创建

		self::checkWritable(dirname($filePath = $this->getFullPath($key)));

		FileHelp::writeNew($filePath, serialize($cacheData));

		return true;
		
	}
	
	
    /***********************************
            读取cache
     ***********************************/

	public function read($key)
    {
		
		if(!file_exists($filePath = $this->getFullPath($key)))
		{
		
			return null;
		
		}


		//读取缓存内容，反序列化并判断是否过期
		
		$cacheContent = file_get_contents($filePath);
		
		$cacheContent = unserialize($cacheContent);
        
		if($cacheContent['expire'] === '0' || $cacheContent['expire'] > time())
		{
			
			return $cacheContent['cacheData'];
			
		}
		
		@unlink($filePath);

		return null;

	}
	

    /***********************************
            清除指定缓存
     ***********************************/

	public function remove($key)
    {

		if(file_exists($filePath = $this->getFullPath($key)))
		{
			
			return unlink($filePath);
		
		}
		
		return false;

	}
	
	
    /***********************************
            清空所有cache
     ***********************************/

	public function clear($path=null)
    {
		
		$path = $path?$path:self::$__catchPath;
		
		if(!is_dir($path))
		{

			KeDebug::error("clearPath:{$path} is invalid path", __FILE__, __LINE__);

		}

		return FileHelp::clear($path);
		
	}

	
		
}