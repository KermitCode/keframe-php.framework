<?php

/***********************************
 *Note:		:框架核心配置文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
final class KeConfig extends KeBase implements KeKe
{
	
	static $__frameConfig;


	/***********************************
		实例化类
	 ***********************************/

	public function __construct(&$KE=NULL)
    {

		parent::__construct($KE);

        $this->init();

	}

    
	/***********************************
		初始化配置项
	 ***********************************/
	
	private function init()
    {
        
		//项目配置路径 

		$this->KE->configPath = (APPLICATION_NAME?(APPLICATION_PATH):(APPPATH)).'config/';

		self::$__frameConfig = FRAMEPATH .'coreconfig/';


		//加载基本配置

		$this->configCommen();

		
		//执行数据源配置

		$this->configDatabase();

	}


	/***********************************
		加载基本配置数据
	 ***********************************/

	private function configCommen()
	{
		
		$config = array();

		if(file_exists($appConfig = $this->KE->configPath.'config.php'))
		{
		
			$config = (array)require($appConfig);

		}

		$this->KE->config = array_merge(require(self::$__frameConfig.'config.php'), $config);
		
		$config = NULL;
		
        $this->KE->config = ArrObjHelp::arrayToObject($this->KE->config);

	}


    /***********************************
		加载数据源配置
	 ***********************************/

	private function configDatabase()
	{
		
		$config = array();

		if(file_exists($dbConfig = $this->KE->configPath.'dbconfig.php'))
		{
		
			$config = (array) require($dbConfig);

		}

		$config = array_merge(require(self::$__frameConfig.'dbconfig.php'), $config);
	
        !empty($config['mysql'])	 && KeDao::__config($config['mysql']);

        !empty($config['redis'])	 && KeRedis::__config($config['redis']);

        !empty($config['interface']) && KeCurl::__config($config['interface']);

	}

	
	/***********************************
		应用配置
	 ***********************************/
	
	public function initConfig()
    {

        //session 启动

        $this->KE->config->session_autostart && session_start();
        
		
		//时区配置

        $this->KE->config->timezone_default == null &&  $this->KE->config->timezone_default = 'PRC';

        date_default_timezone_set($this->KE->config->timezone_default);


		//输出字符编码

        $this->KE->config->charset_default == null &&  $this->KE->config->charset_default = 'PRC';

		HtmlHelp::headerCharset($this->KE->config->charset_default);


		//用户扩展类

        $this->checkExtend();


		//初始化一些基础配置
		
		$this->config->cache->cache_time = intval($this->config->cache->cache_time);

        KeDebug::setDebugConfig($this->KE->config->debug_show);

		KeLogs::setLogsConfig($this->config->log);

		KeCache::setCatchConfig($this->config->cache);

	}
	
	
	/***********************************
		加载配置
	 ***********************************/
	
	public function loadConfig($config, $obj=false)
    {
        
        //数组递归调用
        
        if(is_array($config))
        {
        
            foreach($config as $con)
            {

                $this->loadConfig($con, $obj);

            }

        }
        
        
        //加载配置文件

		$configFile = $this->KE->configPath. $config . SUFFIX;

        if(file_exists($configFile))
        {
            
            $configData = require($configFile);
			
			if($obj)
			{
				
				return ArrObjHelp::arrayToObject($configData);

			}

			return $configData;

        }
	
	}

    
	/***********************************
		用户配置的自动加载类检查
	 ***********************************/

    private function checkExtend()
    {
		
		//检查是否有同名的KEY
		
		$tempMap = (array)$this->KE->keClassMap;

        if($sameKey = array_intersect_key($tempMap, (array)$this->KE->config->extendClass))
        {
                    
                KeDebug::error("in config Data,there is a extendClass key:'".key($sameKey)
								."' is a system keyName! please change another.", __FILE__, __LINE__);
                        
        }

		
		//检查是否有重复路径

		foreach($this->KE->config->extendClass as $key=>$path)
		{
			
			if(!in_array($path, $tempMap))
			{
			
				unset($this->KE->config->extendClass->$key);

			}
			
		}

		return true;

    }
	
}