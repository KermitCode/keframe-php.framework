<?php

/***********************************
 *Note:		:字符串处理类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
final class RedirectHelp
{
	
	/***********************************
	    alert信息后返回
	 ***********************************/
	
	public static function alertGo($msg='', $url='')
	{
		
		//$msg:要弹出显示的信息  $url:要跳转至的页面
		
		$url=$url?"window.location.href='{$url}';":"window.history.go(-1);";
		
		if (!empty($msg))
		{
			
			die("<script language=\"javascript\">alert('{$msg}');{$url}</script>");
		
		}else{
			
			die("<script language=\"javascript\">{$url}</script>");
		
		}
	
	}
	
	
	/***********************************
	    框架顶层alert信息后返回
	 ***********************************/
	
	public function alertTopgo($msg='',$url='')
	{
		
		//$msg:要弹出显示的信息  $url:要跳转至的页面
		
		$url=$url?"top.location.href='{$url}';":"window.history.go(-1);";
		
		if (!empty($msg))
		{
			
			die("<script language=\"javascript\">alert('{$msg}');{$url}</script>");
		
		}else{
			
			die("<script language=\"javascript\">{$url}</script>");
		
		}

	}
	

	/***********************************
	    301跳转
	 ***********************************/
	
	public static function toUrl($url='', $refresh=0)
	{
		
		//$url:要跳转至的页面; $refresh:等待的秒数
		
		$refresh = intval($refresh);

		header(($refresh?"refresh:{$refresh};":'')."Location:{$url}");

		exit;

	}
	

	/***********************************
	 页面信息反馈 $refresh为0则为alert警告框
	 ***********************************/
	
	public function pageTogo($message,$url='',$refresh='',$image='mes_gx.gif')
	{
		
		/*
		 *页面信息显示函数
		 *$message:将要显示给用户的信息
		 *$url:信息显示后将要跳转的页面
		 *$refresh:如为页面刷新的方式请填此项表示信息页显示的秒数
		 *$refresh为0则会以js弹出窗口提示；不为0则以页面显示
		 *当前显示信息的模板页面：ROOT_PATH/inc/message.html
		 */
		
		require(ROOT_PATH."inc/message.html");
		
		$content=ob_get_contents();
		
		@ob_end_clean();
	
		@ob_start();
		
		$change_char=array('{{refresh}}','{{url}}','{{message}}','{{image}}');
		
		$changeto_char=array($refresh,$url,$message,$image);
		
		$content=str_replace($change_char,$changeto_char,$content);
		
		echo $content;exit;

		
	}//end show message	
	
	
	
		
}