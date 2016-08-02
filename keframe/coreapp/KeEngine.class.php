<?php

/***********************************
 *Note:		:框架核心配置文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
final class KeEngine extends KeBase implements KeKe
{

	/***********************************
			实例化类
	 ***********************************/
     
	public function __construct(&$KE=NULL)
    {
		
		parent::__construct($KE);

	}


	/***********************************
			对APP应用初始化
	 ***********************************/

    public function init()
    {

        $this->KeRoute->initRoute();
		
		$this->initPath();


        //检查控制器文件是否存在

		if(!file_exists( $cfile = CONPATH.$this->KE->controllerName.SUFFIX))
        {

			KeDebug::error("Controller file:'{$this->KE->controllerName}' not found in Path:".CONPATH, __FILE__, __LINE__);
			
		}


        //检查控制器是否存在
	
		if(!$this->KE->loadKeframe($this->KE->controllerName))
        {

			KeDebug::error("Controller:'{$this->KE->controllerName}' not exists.", __FILE__, __LINE__);
		
		}

        $this->KE->keApplication = new $this->controllerName();

        $methodAll = get_class_methods($this->KE->keApplication);


        //检查控制器中方法是否存在
		
		if(!method_exists($this->KE->keApplication, $this->KE->actionName))
        {
		
			KeDebug::error("Action:'{$this->KE->actionName}' not found in Controller {$this->KE->controllerName}", __FILE__, __LINE__);
		
		}

    }

	
	/***********************************
			对APP应用配置路径数据
	 ***********************************/
	
	public function initPath()
    {
		
		$this->KE->rootPath=ROOTPATH;

		$this->KE->appPath=APPLICATION_PATH;

		$this->KE->viewPath=APPLICATION_PATH.'views/';

		$this->KE->uploadPath=ROOTPATH.'uploads/';
		
	}
	
	
	/***********************************
			APP响应
	 ***********************************/
     
	public function response()
    {
		
		$this->KE->keApplication->_initKE($this->KE);


        //项目级的预执行方法：__initApplication 则执行此方法。
		
		$this->KE->keApplication->__initApplication();
	
	
		//控制器级的执行方法__init方法，则执行。
		
		$this->KE->keApplication->__init();
		
		
	    

        //调用控制器方法

		$this->KE->keApplication->__response($this->KE->keApplication, $this->actionName);


        //每个控制器级如有__afterRequest方法，则执行重写的方法。
		
		$this->KE->keApplication->__afterRequest();


        //日志记录及展示调试信息

        $this->KE->KeDebug->showDebug();
		
	}
	
}