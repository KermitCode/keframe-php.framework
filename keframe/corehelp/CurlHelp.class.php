<?php

/***********************************
 *Note:		:字符串处理类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
class CurlHelp
{
    
    static $__curlAgent;
    
    static $__interFace;

    public static function setCurlAgent($agent)
    {
        
        self::$__curlAgent = $agent;
    
    }

    public static function setCurlInterface($interface)
    {
    
        self::$__interFace = $interface;

    }
    
	/*************************
		公共实例化curl对象
	************************/
	
	public static function makeCurlHand()
    {
		
		if($this->KE->CurlHand) return $this->KE->CurlHand;
		
		$CurlHand = curl_init();
		
		
		/*************************
			设置Curl返回
		************************/
		
		curl_setopt($CurlHand, CURLOPT_RETURNTRANSFER ,1); 
		
		curl_setopt($ch, CURLOPT_HEADER,false);
		
		/*************************
			Curl超时设置
		************************/
		
		curl_setopt($CurlHand, CURLOPT_CONNECTTIMEOUT,15);
		
		curl_setopt($CurlHand, CURLOPT_TIMEOUT,15);
		
		curl_setopt($CurlHand, CURLOPT_USERAGENT,$this->Visit->userAgent);

		curl_setopt($CurlHand, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($CurlHand, CURLOPT_SSL_VERIFYHOST, false);
		
		curl_setopt($CurlHand, CURLOPT_REFERER,$this->referer);
		
		/*************************
			跳转-非安全模式下可用
		************************/
		
		curl_setopt($CurlHand, CURLOPT_FOLLOWLOCATION, 0);
		
		curl_setopt($CurlHand, CURLOPT_MAXREDIRS, 20);
		
		return $this->CurlHand=$CurlHand;
		
		
	}
	
	/*************************
			页面Post数据
	************************/
	
	public static function curlPost($url,$array)
    {
		
		$CurlHand = $this->makeCurlHand();
		
		curl_setopt($CurlHand, CURLOPT_URL,$url);
		
		curl_setopt($CurlHand, CURLOPT_POST,1);
		
		curl_setopt($CurlHand, CURLOPT_POSTFIELDS,$array);

		$result = curl_exec ($CurlHand);
		
		$curl_errno = curl_errno($CurlHand);

		/*************************
			超时返回false
		************************/
		
		if($curl_errno>0) return false;
		
		curl_close($CurlHand);

		return $result;
		
	}
	
	
	/*************************
			页面Get数据
	************************/
	
	public static function curlGet($url)
    {
		
		$CurlHand = $this->makeCurlHand();
		
		curl_setopt($CurlHand, CURLOPT_URL,$url);

		$result = curl_exec($CurlHand);
		
		$curl_errno = curl_errno($CurlHand);
		
		/*************************
			超时返回false
		************************/
		
		if($curl_errno>0) return false;
		 
		curl_close($CurlHand);
		
		return $result;
		
	}
	

	
}