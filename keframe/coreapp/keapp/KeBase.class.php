<?php

/***********************************
 *Note:		:框架核心文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
abstract class KeBase
{
	
	//核心KE对象
	protected $KE;
	
    const _KE = '_ke';


	/***********************************
			实例化类
	 ***********************************/

	public function __construct(&$KE=NULL)
    {

		$this->KE = &$KE;
	
	}

	/***********************************
			全局设置方法
	 ***********************************/
	 
	public function __set($key, $value)
	{
		
		$this->KE->setKeAttribute($key, $value);

	}
	
	
	/***********************************
			全局调用方法
	 ***********************************/
	 
	public function __get($key)
	{

		if(isset($this->KE->keContainer->$key))
		{

			return $this->KE->keContainer->$key;
		
		}elseif($this->KE->loadKeframe($key, true)){
			
			return $this->KE->init($key);
		
		}else{
			
			return NULL;
		}

	}


	/***********************************
			禁止克隆
	 ***********************************/

	private function __clone()
    {

    }

		
}