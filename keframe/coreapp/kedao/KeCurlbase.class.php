<?php

/***********************************
 *Note:		:curl底层类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
abstract class KeCurlbase
{
    
    protected static $__Instance = array();

    protected static $__config = NULL;

    protected static $__curlHandle = NULL;
    
    private $initTime;

	protected static $__curlAgent;

	protected static $__curlReferer;

    /***********************************
		    初始化CURL配置
	 ***********************************/

	protected function init()
    {


	}


    /***********************************
		    公共实例化curl对象
	 ***********************************/
    
	protected function initCurlHandle()
    {
		
        //只实例化一次curl

		if(self::$__curlHandle) return;


        //执行init curl
		
		self::$__curlHandle = curl_init();
		
		curl_setopt(self::$__curlHandle, CURLOPT_RETURNTRANSFER ,1); 
		
		curl_setopt(self::$__curlHandle, CURLOPT_HEADER,false);
		
		curl_setopt(self::$__curlHandle, CURLOPT_CONNECTTIMEOUT, 15);

		curl_setopt(self::$__curlHandle, CURLOPT_TIMEOUT,15);
		
		curl_setopt(self::$__curlHandle, CURLOPT_USERAGENT, self::$__curlAgent);

		curl_setopt(self::$__curlHandle, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt(self::$__curlHandle, CURLOPT_SSL_VERIFYHOST, false);
		
		curl_setopt(self::$__curlHandle, CURLOPT_REFERER, self::$__curlReferer);
		

		//跳转-非安全模式下可用
		
		curl_setopt(self::$__curlHandle, CURLOPT_FOLLOWLOCATION, 0);
		
		curl_setopt(self::$__curlHandle, CURLOPT_MAXREDIRS, 20);
		
		return;

	}


	/***********************************
		    Post抓取数据
	 ***********************************/
    
	public function curlPost($url, $array=array())
    {
		
        $this->initTime();

		curl_setopt(self::$__curlHandle, CURLOPT_URL,$url);
		
		curl_setopt(self::$__curlHandle, CURLOPT_POST,1);
		
		curl_setopt(self::$__curlHandle, CURLOPT_POSTFIELDS, $array);

		$result = curl_exec(self::$__curlHandle);
		
		$curl_errno = curl_errno(self::$__curlHandle);

        KeDebug::curlLog($url.'  ,postData:'.print_r($array, true), $this->calculateTime(), $this->__interName);

		//超时返回false
		
		if($curl_errno>0) return false;
		
		return $result;
		
	}


   	/***********************************
		    资源连接
	 ***********************************/

    private function initDb()
    {
        

        KeDebug::dblog("Link Database {$this->__dbResourceName}.", $this->calculateTime(), $this->__dbResourceName);
		

    
    }


    /***********************************
		    初始查询时间
	 ***********************************/
    
    protected function initTime()
    {
        
        $this->initTime = microtime(true);

    }


   	/***********************************
		    sql耗时统计
	 ***********************************/
    
    protected function calculateTime()
    {
        
        return MathHelp::roundMilliSecond(microtime(true) - $this->initTime, 4);

    }


   	/***********************************
		    资源所有销毁
	 ***********************************/

    public function destructDao($db='')
    {
        
       

    }


	/***********************************
		    外部检查配置
	 ***********************************/

    public static function __checkConfigIndex($key)
    {
        
        return isset(self::$__config->$key);

    }
	
}