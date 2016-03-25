<?php

/***********************************
 *Note:		:框架核心HTTP处理类文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
final class KeHttp extends KeBase implements KeKe
{


	/***********************************
			实例化类
	 ***********************************/
	
	public function __construct(&$KE=NULL)
    {
		
		parent::__construct($KE);

        $this->init();

	}


	/***********************************
			初始化HTTP类数据
	 ***********************************/

	private function init()
    {	
        
		$this->__initLogID();	      #日志ID

		$this->__initIP();            #IP数据

		$this->__initReferer();       #用户来源地址

		$this->__initAgent();         #用户终端信息初始化
		
		$this->__initHttp();          #Url数据初始化

        $this->initParams();          #用户参数初始化

		$this->initLogArr();		  #日志参数初始化
		
	}


	/***********************************
			获取_ke数据
	 ***********************************/

    public function initKe()
    {
    
        return isset($this->KE->Get->_ke)?$this->KE->Get->_ke:'';

    }


	/***********************************
			获取用户IP
	 ***********************************/

	private function __initIP()
    {
			
		$this->__initIpClient();

        $this->__initIpRemote();

        $this->__initIpServer();

	}


	/***********************************
			初始化用户参数
	 ***********************************/

    private function initParams()
    {
		
		$this->KE->magicRun=ini_get('magic_quotes_gpc')?1:0;

		$this->configParams($_GET, 'Get');
		
		$this->configParams($_POST, 'Post');
		
		$this->configParams($_COOKIE, 'Cookie');

	}


	/***********************************
			用户或代理IP
	 ***********************************/

    private function __initIpClient()
    {

        if(isset($this->KE->clientIp)) return $this->KE->clientIp;

		if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        {
			
			$ip = getenv("HTTP_CLIENT_IP");

            if(strpos($ip, ',') !==false) $ip = current(explode(',', $uip));
			
		}elseif(getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")){
			
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		
		}elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")){
		
			$ip = getenv("REMOTE_ADDR");
		
		}elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
		
			$ip = $_SERVER['REMOTE_ADDR'];
		
		}else $ip = "unknown";
		
		return $this->KE->clientIp = $ip;

    }


	/***********************************
			用户IP
	 ***********************************/

    private function __initIpRemote()
    {

        if(isset($this->KE->remoteIp))
        {
        
            return $this->KE->remoteIp;
        
        }

        return $this->KE->remoteIp = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'';

    }


	/***********************************
			服务器IP
	 ***********************************/

    private function __initIpServer()
    {

        if(isset($this->KE->serverIp))
        {
        
            return $this->KE->serverIp;
        
        }

        return $this->KE->serverIp = isset($_SERVER['SERVER_ADDR'])?$_SERVER['SERVER_ADDR']:'';

    }


	/***********************************
			获取用户来源地址
	 ***********************************/

   private function __initReferer()
   {
		
		if(isset($this->KE->userReferer)) return $this->KE->userReferer;
		
		$fromUrl=isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:'';
		
		if(!$fromUrl)
        {
			
			$fromUrl=isset($HTTP_SERVER_VARS["HTTP_REFERER"])?$HTTP_SERVER_VARS["HTTP_REFERER"]:'';
		
		}
		
		return $this->KE->userReferer = $fromUrl;
	
    }


	/***********************************
			用户终端信息
	 ***********************************/
     
	private function __initAgent()
    {

        //$this->Server=(object)$_SERVER;
		
		$this->KE->userUri=isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:$_SERVER['QUERY_STRING'];

		$this->KE->userAgent=isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'';


		WapHelp::initAgent($this->KE->userAgent);

		//进行数据抓取时使用当前用户数据

        KeCurl::setCurlAgent($this->KE->userAgent);
	
	}


	/***********************************
			用户变量数据
	 ***********************************/	

    private function configParams($data, $v)
    {

		!$this->KE->magicRun && $data = StrHelp::addslash($data);
		
		$this->KE->$v = new KeStdclass();
		
		foreach($data as $sk=>$sv)
        {
			
			$this->KE->$v->$sk=$sv;
		
		}
		
	}


	/***********************************
			基本URL定义
	 ***********************************/

	private function __initHttp()
    {

        //php_self
		
		$php_self = !empty($_SERVER['PHP_SELF'])?$_SERVER['PHP_SELF']:'';
		
		$script_name = !empty($_SERVER['SCRIPT_NAME'])?$_SERVER['SCRIPT_NAME']:'';
		
		$php_self = $php_self?$php_self:$script_name;

		$this->KE->phpSelf = ltrim(strrchr($php_self, '/'), '/');
		

		//http_host
		
		if(!empty($_SERVER['HTTP_HOST']))
        {
			
			$this->KE->httpHost = $_SERVER['HTTP_HOST'];
			
		}elseif(!empty($HTTP_SERVER_VARS['HTTP_HOST'])){
			
			$this->KE->httpHost = $HTTP_SERVER_VARS['HTTP_HOST'];
			
		}

		
		//web url

		$this->KE->webUrl = 'http://'.$this->KE->httpHost;

		$this->KE->baseUrl = substr($php_self,0,strrpos($php_self,'/')+1);

        $this->KE->fullUrl = $this->KE->webUrl.$this->KE->baseUrl;
		
		$this->KE->uploadUrl = $this->KE->baseUrl.'uploads/';
		
		$this->KE->imagesUrl = $this->KE->baseUrl.'images/';
		
	}


	/***********************************
			初始化日志数据
	 ***********************************/

	private function initLogArr()
	{
		
		KeLogs::initLogArr(array(

			'refer'=>$this->KE->userReferer,

			'get'=>json_encode((array)$this->KE->Get),

			'post'=>json_encode((array)$this->KE->Post),

			'cookie'=>json_encode((array)$this->KE->Cookie),

			'uri'=>$this->KE->userUri,

			'ip'=>'clientIp:'.$this->KE->clientIp.',serverIp:'.$this->KE->serverIp,

		));
	
	}


	/***********************************
			初始化日志logID
	 ***********************************/
	
    private function __initLogID()
    {

		if(defined('LOG_ID')) return LOG_ID;
		
		$arr = gettimeofday();
		
		$t = ($arr['sec']*100000 + $arr['usec']/10) & 0x7FFFFFFF;

		define('LOG_ID', $t);

		return LOG_ID;

	}

		
}