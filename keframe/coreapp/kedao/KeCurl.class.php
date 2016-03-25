<?php

/***********************************
 *Note:		:字符串处理类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
final class KeCurl extends KeCurlbase implements KeData
{
    
    static $__curlAgent;
    
    static $__interFace;
    
    static $__curlReferer;

    /***********************************
		    初始化CURL配置
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
		    取得CURL实例
	 ***********************************/

    public static function __getInstance($inter)
    {

        if(isset(self::$__Instance[$inter])) return self::$__Instance[$inter];

        if(!isset(self::$__config->$inter))
        {
            
            trigger_error("no interface config:{$inter} in dbconfig!");
            
            exit;

        }

        self::$__Instance[$inter] = new self($inter, self::$__config->$inter);

        return self::$__Instance[$inter];

    }


    /***********************************
		    外部检查配置
	 ***********************************/

    public static function __checkConfigIndex($key)
    {
  
        return isset(self::$__config->$key);

    }
    

    /***********************************
		    初始化Curl资源
	 ***********************************/

	private function __construct($inter, $interconfig)
    {
		
        $this->__interName = $inter;

        $this->initCurlHandle();
        
        $this->__curlUrl = $interconfig->host.($interconfig->port=='80'?'/':":{$interconfig->port}/").ltrim($interconfig->uri, '/');

        return;

	}

    /***********************************
		    设置抓取时的agent
	 ***********************************/

    public static function setCurlAgent($agent)
    {
        
        self::$__curlAgent = $agent;
    
    }


    /***********************************
		    设置抓取时的URL资源
	 ***********************************/

    public static function setCurlInterface($interface)
    {
    
        self::$__interFace = $interface;

    }
    

    /***********************************
		    公共实例化curl对象
	 ***********************************/
    
	private function initCurlHandle()
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
		    Get抓取数据
	 ***********************************/

	public function curlGet($url)
    {
		
        $this->initTime();

		curl_setopt(self::$__curlHandle, CURLOPT_URL, $url);
        
        curl_setopt(self::$__curlHandle, CURLOPT_POST, 0);

		$result = curl_exec(self::$__curlHandle);
		
		$curl_errno = curl_errno(self::$__curlHandle);

        KeDebug::curlLog($url, $this->calculateTime(), $this->__interName);
		
		//超时返回false
		
		if($curl_errno > 0){
            
            print_r( curl_error());
            return false;

        }
		
		return $result;
		
	}
	

	
}