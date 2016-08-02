<?php

/***********************************
 *Note:		:框架核心文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
final class KeRoute extends KeBase implements KeKe
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
		    获取appName
	 ***********************************/
     
	private function init()
    {

		$keArr = explode('/', $this->KeHttp->initKe());
        
        $childApplication = strtolower(array_shift($keArr));

        if(!is_dir(APPPATH.$childApplication))
        {

            $childApplication = '';
        
        }
        
        $this->KE->appName = $childApplication;

	}

    
	/***********************************
		    初始化app相关路径
	 ***********************************/

    public function initAppName()
    {

        define('APPLICATION_NAME', $this->KE->appName);

        define('APPLICATION_PATH', $this->appName?(APPPATH."{$this->appName}/") : APPPATH);

        define('CONPATH', APPLICATION_PATH.'controllers/');		#项目控制器目录

		define('LIBPATH', APPLICATION_PATH.'libraries/');		#项目自定义类文件目录

		define('MODPATH', APPLICATION_PATH.'models/');			#项目模型类文件目录

        define('MODELPATH', APPPATH.'models/');			        #子系统时顶级模型类文件目录

        define('LIBRARYPATH', APPPATH.'libraries/');		    #子系统时顶级自定义类文件目录

        $loadMap = array(CONPATH);

        is_dir(MODPATH) && $loadMap[] = MODPATH;

        is_dir(LIBPATH) && $loadMap[] = LIBPATH;

		array_push($loadMap, MODELPATH, LIBRARYPATH);
        
        return $loadMap;
       
    }


	/***********************************
		    路由控制器方法处理
	 ***********************************/

	public function initRoute()
    {

        $this->resolveRewrite($this->checkRoute());

		if(isset($this->KE->Get->_ke)) unset($this->KE->Get->_ke);


		//初始化基础分页参数

		$this->KE->page = isset($this->KE->Get->{$this->KE->config->pageParam})?$this->KE->Get->{$this->KE->config->pageParam}:1;

		$this->KE->page = intval($this->KE->page);

		$this->KE->page <1 && $this->KE->page = 1;

	}

	
	/***********************************
		    Route检查
	 ***********************************/
     
	private function checkRoute()
    {
        
        $_ke = $this->KeHttp->initKe();

		if(preg_match('/(.*?).*/s', $_ke, $match))
		{
			
			$_ke=$match[0];
		
		}


        //如果开启了伪静态对URL的后缀进行处理

        if($this->config->url_rewrite->rewrite_open)
        {
			
			if( strtolower(substr($_ke,-strlen($this->config->url_rewrite->rewrite_suffix))) == strtolower($this->config->url_rewrite->rewrite_suffix) )
            {

                $_ke=trim(substr($_ke,0,-strlen($this->config->url_rewrite->rewrite_suffix)),'/');

            }
		
		}

        $keArr=explode('/', $_ke);

        if(APPLICATION_NAME)
        {
            
            array_shift($keArr);
            
            $_ke = implode('/', $keArr);

        }

        
        //如果使用了urlRewrite，则需将URL恢复成原样再进行处理

        if($this->config->url_rewrite->rewrite_open)
        {

            list($_ke, $keArr) = $this->checkUrlrule($_ke, $keArr);
		
		}

		
		//取控制器和方法

		$this->initControllerAction($keArr);


        //返回路由数据以供GET参数获取

		return $keArr;

	}


	/***********************************
		   初始化Controller/Action
	 ***********************************/

    private function initControllerAction($keArr)
    {
 
        $controllerName = strtolower(array_shift($keArr));

        $actionName = strtolower(array_shift($keArr));
        

        //调用默认配置控制器和方法

		!$controllerName && $controllerName = $this->config->defaultController;
			
		!$actionName && $actionName = $this->config->defaultAction;

        $this->KE->controller = $controllerName;

		$this->KE->controllerName = $this->formatAc($controllerName,false);

        $this->KE->action = $actionName;

        $this->KE->actionName = $this->formatAc($actionName);

		return true;
	
	}


	/***********************************
		    Rewrite解析
	 ***********************************/

    public function resolveRewrite($keArr)
    {

        if(!$this->config->url_rewrite->rewrite_open) return;

        $_ke = implode('/', $keArr);

		$getArr = array();
      
        for($i=2; $i>=0; $i+=2)
        {
			
			if(isset($keArr[$i]) && !empty($keArr[$i]))
			{

				$getArr[$keArr[$i]] = isset($keArr[$i+1])?$keArr[$i+1]:'';
        
			}else{

				break;
			
			}

        }

        $Get = array_merge($getArr, (array)$this->KE->Get);
		
		$this->KE->Get = ArrObjHelp::arrayToObject($Get);

        return true;
	
	}
	
	
	/***********************************
		    控制器URL规则解析
	 ***********************************/

    public function checkUrlrule($_ke,$keArr)
    {
        
        if(!$_ke) return array('', array());

		foreach($this->config->url_rewrite->rewrite_rule as $url=>$rurl)
        {
			
			$s = preg_match('/<(.*)>/i', $url, $match);

			if(!$s) continue;

			$others=rtrim(str_replace("<{$match[1]}>", '', $url), '/');
			
			$others=str_replace('/','\/',$others);
			
			if(!$rule = $this->getRule($match[1], $others)) continue;


            //如果匹配规则则替换成urlRewrite之前的数据
            
			if(isset($keArr[0]) && isset($keArr[1]) && $rs = @preg_match($rule, $keArr[0].'/'.$keArr[1], $matchs))
            {

				$real=str_replace("<{$match[1]}>",$matchs[1],$rurl);
			
				$_ke=str_replace("{$keArr[0]}/{$keArr[1]}",$real,$_ke);
			
				$keArr=explode('/',$_ke);
				
				break;

			}

		}
		
		return array($_ke, $keArr);
		
	}	
	

	/***********************************
		    控制器URL规则正则
	 ***********************************/

	public function getRule($type,$s,$end=true)
    {
    
		switch($type)
        {

			case 'string' :$r= "/^{$s}\/([a-zA-Z\-_]*)".($end?'$':'')."/i";break;

			case 'id'	  :$r= "/^{$s}\/(\d*)".($end?'$':'')."/i";break;

			default		  :$r='';break;

		}
		
		return $r;
		
	}
	

	/***********************************
		控制器方法名拼接
	 ***********************************/

	public function formatAc($param,$a=true)
    {
		
		return $a?'Action'.ucfirst($param):ucfirst($param.'Controller');		
		
	}


	/***********************************
		控制器文件名
	 ***********************************/

	public function formatController($param)
    {
		
		return $this->formatAc($param,false).'.php';		
		
	}


}