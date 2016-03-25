<?php

/***********************************
 *Note:		:字符串处理类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/

abstract class KeApplication
{
	
	private static $__KE;
	
	private static $__coreObject;


    //公用模型

    protected $NormalModel = NULL;


	/***********************************
			引入KE核心
	 ***********************************/
	
	public function _initKE($KE)
    {
		
		self::$__KE = $KE;

        $this->NormalModel = new KeNormalModel();

        register_shutdown_function('KeApplication::__shutDown');

	}


    /***********************************
			项目级顶层公用执行方法
	 ***********************************/
	
	public function __initApplication()
    {
     
    }


    /***********************************
			控制器级公用执行方法
	 ***********************************/
	
	public function __init()
    {
    
    }


	/***********************************
		    页面执行完毕时执行
	 ***********************************/
	 
	public function __afterRequest()
    {
    
    }


	/***********************************
			全局核心设置方法
	 ***********************************/
	 
	public function __set($key, $value)
    {
		
		$this->$key=$value;
	
	}


    /***********************************
			测试时展示KE
	 ***********************************/
	
	public function __getKe()
    {
            
        return self::$__KE;

    }


	/***********************************
			获取KE核心对象
	 ***********************************/
	
	public function __get($key)
    {
		
		$prefix_key = ucwords(strtolower(substr($key, 0, 2)));

		$suffix_key = ucwords(strtolower(substr($key, 2)));

		$stand_key = ucwords(strtolower(KE));

		if($prefix_key == $stand_key)
		{

			$dst_key = $prefix_key.$suffix_key;

			if(in_array($dst_key, $this->__getCoreAttribute()))
			{

				return self::$__KE->$dst_key;

			}
		
		}

		return $this->__getContailer($key);

	}
	

	/***********************************
			获取KE核心数据
	 ***********************************/
	
	private function __getContailer($key)
    {

		if(isset(self::$__KE->keContainer->$key))
		{

			return self::$__KE->keContainer->$key;
		
		}

		return NULL;

	}


	/***********************************
			得到核心类
	 ***********************************/

	private function __getCoreAttribute()
    {

		if(self::$__coreObject) return self::$__coreObject;

		self::$__coreObject = FileHelp::directory(COREPATH);

		foreach(self::$__coreObject as $key=>$value)
		{
			
			self::$__coreObject[$key] = substr(strrchr($value, '/'), 1, -strlen(KE_SUFFIX));

		}

		return self::$__coreObject;
		
	}


	/***********************************
			App呈现
	 ***********************************/

	public function __response($controller, $action)
    {

		ob_start();

		$KeContent = call_user_func_array(array($controller,$action), (array)$this->Get);

		$KeContent = ob_get_contents();

		ob_end_clean();

		if($this->layout && file_exists($lfile=$this->viewPath.$this->layout.SUFFIX)){
			
			require($lfile);
			
		}else{
			
			echo $KeContent;
			
		}
		
	}


	/*************************
		ERROR错误日志
	 ************************/

    public static function __shutDown()
    {
    
        $error = error_get_last();
        
        if(!empty($error['message']))
        {
        
            KeDebug::error($error['message'], $error['file'], $error['line'], 'type:'.$error['type']);
        
        }
          
    }

	
	/*************************
		App错误展示 
	 ************************/
	
	public static function error()
    {
		
		echo 'kecontroller  error';exit;

		
		
		$error=current($error);
		
		if(!$error) return;
		
		else{

			ob_start();
			
			$obj=new HomeController();

			$keContent =call_user_func(array($obj,'actionError'),$error);
	
			$keContent = ob_get_contents();
	
			ob_end_clean();
	
			if($this->layout && file_exists($lfile=$this->getSet('viewPath').$this->layout.".php")){
				
				require($lfile);
				
			}else{
				
				echo $keContent;
				
			}
			
			exit;
		
		}
		
	}
	
}