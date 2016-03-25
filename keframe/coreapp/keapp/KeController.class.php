<?php

/***********************************
 *Note:		:字符串处理类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2015-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
abstract class KeController extends KeApplication
{
	
	//默认全局布局文件

	protected $layout='layout';


	/***********************************
		生成URL，传递路由+参数
	 ***********************************/

	public function makeUrl($route, $array=array())
    {
		
		return $this->KeUrl->makeUrl($route, $array);
		
	}


	/***********************************
			路由跳转
	 ***********************************/

	public function redirect($route, $array=array())
    {
		
		return $this->KeUrl->redirect($route, $array);
		
	}


	/***********************************
			Url跳转
	 ***********************************/

	public function redirectUrl($url)
    {
		
		return $this->KeUrl->toUrl($url);
		
	}


	/***********************************
			获取Get参数
	 ***********************************/

	public function get($key=null, $value=null)
	{
		
		if($key===null)
		{
			//返回所有GET参数

			return (array)$this->Get;

		}elseif($value !== null){

			//设置GET值
			
			$this->Get->$key = $value;

			return true;
		
		}else{

			//判断是否存在
		
			return isset($this->Get->$key)?$this->Get->$key:null;
		
		}

	}


	/***********************************
			获取Post参数
	 ***********************************/

	public function post($key=null, $value = null)
	{
		
		if($key===null)
		{
			//返回所有GET参数

			return (array)$this->Post;

		}elseif($value !== null){
			
			//设置值

			$this->Post->$key = $value;

			return true;
		
		}else{

			//判断是否存在
		
			return isset($this->Post->$key)?$this->Post->$key:null;
		
		}

	}


	/***********************************
			获取Cookie参数
	 ***********************************/

	public function cookie($key, $value = null)
	{

		if($key === null)
		{
			//返回所有Cookie参数

			return (array)$this->Cookie;

		}elseif($value !== null)
		{

			//设置值

			$this->Cookie->$key = $value;

			return true;
		
		}else{
		
			//判断是否存在

			return isset($this->Cookie->$key)?$this->Cookie->$key:null;
		
		}

	}


	/***********************************
			获取和设置SESSION参数
	 ***********************************/

	public function session($key, $value = null)
	{
		
		//设置值

		if($value !== null)
		{
			
			//如果设置值为空，则销毁此SESSION

			if($value==='') unset($_SESSION[$key]);
			
			else $_SESSION[$key] = $value;

			return true;
		
		}else{
		
			return isset($_SESSION[$key])?$_SESSION[$key]:null;
		
		}

	}

	
	/***********************************
			视图渲染
	 ***********************************/

	protected function view($view='')
    {
		
		$view = $view?$view:$this->controller.'/'.$this->action;

		if(file_exists($viewFile = $this->viewPath.trim($view, '/').SUFFIX))
		{
			
			return require_once($viewFile);
			
		}else{
			
			KeDebug::error("View File:{$viewFile} not found.", __FILE__, __LINE__);	
		
		}
		
	}


	/***********************************
			加载配置
	 ***********************************/

	protected function loadConfig($config)
    {
		
		return $this->KeConfig->loadConfig($config);
		
	}


	/***********************************
			测试显示数组对象数据
	 ***********************************/

	public function debug($data, $stop=true)
	{
	
		$this->KeDebug->showTest($data, $stop);
	
	}


}