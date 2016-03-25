<?php

/***********************************
 *Note:		:框架核心文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
final class KeUrl extends KeBase implements KeKe
{
	
	/***********************************
		生成Url方法
	 ***********************************/

	public function makeUrl($ca='', $params=array())
    {

		$char='';


        //子系统路径判断

        $controllAction = trim($ca, '/');

		if(substr($ca, 0, 1) == '/')
        {
            
            $ca = $controllAction?$controllAction:($this->KE->controller.'/'.$this->KE->action);
		
        }else{
        
            $ca = ($this->appName?$this->appName.'/':'').($controllAction?$controllAction:($this->KE->controller.'/'.$this->KE->action));

        }


        //根据是否开启urlRewrite进行URL生成

		if(!$this->config->url_rewrite->rewrite_open)
        {
			
		    $char.="index.php";
			
			if($ca) $char.="?_ke={$ca}";
			
			if($params)
            {
				
				foreach($params as $k=>$v){$char.="&{$k}={$v}";}
			
			}
			
		}else{
			
			$char.="{$ca}";
		
			if($params)
            {
				
				foreach($params as $k=>$v){$char.="/{$k}/{$v}";}
			
			}
	
			//控制器URL生成处理
			
			$char=$this->userRewrite($char);
			
			$char.=$this->config->url_rewrite->rewrite_suffix;

		}
		
		return $this->KE->baseUrl.$char;
		
	}
	

	/***********************************
		    控制器URL生成处理
	 ***********************************/
	
	public function userRewrite($ac)
    {
		
		$ac_arr=explode('/',$ac);
		
		foreach($this->config->url_rewrite->rewrite_rule as $url=>$rurl)
        {
			
			$s=preg_match('/<(.*)>/i',$rurl,$match);

			if(!$s) continue;

			$others=rtrim(str_replace("<{$match[1]}>",'',$rurl),'/');
			
			$others=str_replace('/','\/',$others);

			if(!$rule = $this->KE->KeRoute->getRule($match[1],$others,false)) continue;

			if($rs=preg_match($rule,$ac,$matchs))
            {

				$real=str_replace("<{$match[1]}>",$matchs[1],$url);
			
				$ac=str_replace("{$matchs[0]}",$real,$ac);
				
				break;

			}

		}
		
		return $ac;
		
	}


	/***********************************
		    直接跳至某个路由
	 ***********************************/
	
	public function redirect($ca='', $params=array())
	{
	
		RedirectHelp::toUrl($this->makeUrl($ca, $params));
	
	}


	/***********************************
		    直接跳至某个URL
	 ***********************************/
	
	public function redirectUrl($url)
	{
	
		RedirectHelp::toUrl($url);
	
	}


}