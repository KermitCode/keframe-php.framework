<?php

/***********************************
 *Note:		:框架核心文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
final class KeGlobal
{

	//项目启动标志

	private static $__initFlag = false;


	//框架核心容器

	public $keContainer;
	

	//应用容器

	public $keApplication;


	/***********************************
		初始化框架
	 ***********************************/
	
	static function __init()
	{
	
		if(self::$__initFlag)
		{

			return false;

		}


		//启动时间、内存占用标记.

		define('START_TIME', microtime(true));

		define('MEMORY_START', memory_get_usage());


		//实例化全局核心类并标记
	
		self::$__initFlag = true;

		return new self;

	}
	

	/***********************************
		初始化核心属性
	 ***********************************/

	private function __initAttribute()
	{

		$this->keContainer = new stdClass();

		$this->keClassMap = new stdClass();
		
		$this->_addClassMap(array(COREPATH, HELPPATH));

		$this->_addClassMap(FileHelp::scanDirectory(COREPATH, 'folder'));

	}


	/***********************************
		其它核心类属性入口
	 ***********************************/

	public function setKeAttribute($key, $value)
	{

		if($this->$key === NULL) 
		{
			
			$this->keContainer->$key = $value;

			return true;
		
		}
		
		return false;

	}


	/***********************************
		加载类地图
	 ***********************************/

	protected function _addClassMap($path, $pathKey='')
	{

		if(is_array($path))
		{
			
			foreach($path as $p)
			{
			
				$this->_addClassMap($p);

			}

		}else{

            !$pathKey && $pathKey = str_replace('/', '_', rtrim(str_replace(ROOTPATH, "", $path), '/'));

		    if(is_dir($path))
            {
                
                $this->keClassMap->{$pathKey} = rtrim($path, '/').'/';

            }else{
       
                KeDebug::warning("class path:{$path} id not a valid dir.", __FILE__, __LINE__);
            
            }

        }

	}


	/***********************************
			全局设置方法
	 ***********************************/
	 
	public function __set($key,$value)
	{
		
		$this->keContainer->$key = $value;

	}
	
	
	/***********************************
			全局调用方法
	 ***********************************/
	 
	public function __get($key)
	{

		if(isset($this->keContainer->$key))
		{

			return $this->keContainer->$key;
		
		}elseif($this->loadKeframe($key, true)){
			
			return $this->init($key);
		
		}else return NULL;

	}
	

	/***********************************
			自动加载类方法
	 ***********************************/
     
	public function loadKeframe($c)
	{

		foreach($this->keClassMap as $name=>$path)
		{
			
			$coreFlag = substr($name, 0, 7) == KEFRAME;

			$classPath = $path. ($coreFlag?($c.KE_SUFFIX):($c.SUFFIX));

			if(file_exists($classPath))
			{

				require_once($classPath);

				return true;
			
			}
			
		}

        KeDebug::notice("class: {$c} not found in all keclassmap.", __FILE__, __LINE__);

		return false;

	}


	/***********************************
			实例化核心类
	 ***********************************/
     
	public function init($o)
    {
	
		if(isset($this->$o))
		{

			return $this->$o;
		
		}else{

			$objKe = new $o($this);
			
			$this->keContainer->$o = &$objKe;

			return $this->keContainer->$o;

		}
			
	}
	

	/***********************************
			实例化全局类
	 ***********************************/
	 
	private function __construct()
	{

		//加载AUTOlOAD
		 
		spl_autoload_register(array($this, 'loadKeframe'));
 
		$this->__initAttribute();


		//提取访问app应用并初始化APP核心路径

        $this->_addClassMap($this->KeRoute->initAppName());


		//用户配置初始化
   
        $this->KeConfig->initConfig();

		set_error_handler(array('KeException', 'errorHandle'));


        //用户自定义扩展类加载
        
        if($this->config->extendClass)
        {

            foreach($this->config->extendClass as $pathKey => $path)
            {
				
                $this->_addClassMap(rtrim($path,'/').'/', $pathKey);

            }
        
        }

	
        //APP启动

	    return $this->boot();
		
	}

	
	/***********************************
			禁止克隆
	 ***********************************/

	private function __clone()
    {

    }


	/***********************************
			启动应用
	 ***********************************/
     
	public function boot()
    {

		$this->KeEngine->init();

		return $this;
		
	}

	
	/***********************************
			响应呈现
	 ***********************************/
     
	public function response()
    {
		
		$this->KeEngine->response();
					
	}
	

}