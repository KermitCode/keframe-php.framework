<?php

/***********************************
 *Note:		:框架核心文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/

final class KeDebug extends KeBase implements KeKe
{
	
	//是否显示页面调试工具条

	private static $__debugShow;

	//调试日志记录

    public static $__debugs;


	/***********************************
			实例化调试类
	 ***********************************/

	public function __construct(&$KE=NULL)
    {
		
		parent::__construct($KE);

	}


	/***********************************
			调试类初始处理
	 ***********************************/

	private static function init()
    {
        
        self::$__debugs= array(
            'page_warning'=>array(),
            'page_notice'=>array(),
			'db_query'=>array(),
			'inter_curl'=>array(),
        );

		self::initErrorReporting();

	}


    /***********************************
			初始化错误显示
	 ***********************************/
	
	private static function initErrorReporting()
	{

		ini_set("display_errors",DEBUG?"On":"Off");
		
		error_reporting(DEBUG?E_ALL:0);

	}


    /***********************************
			调试设置
	 ***********************************/

    public static function setDebugConfig($debug_show)
    {

        self::$__debugShow = $debug_show;

		self::init();

    }
	

	/***********************************
			一般错误处理
	 ***********************************/

    public static function notice($notice, $file, $line, $errno = 'unknown')
    {

        self::$__debugs['page_notice'][] = $notice;

    }


	/***********************************
			警示错误处理
	 ***********************************/

    public static function warning($warning, $file, $line, $errno = 'unknown')
    {

        self::$__debugs['page_warning'][] = $warning;
    
    }

	/***********************************
			SQL查询日志处理
	 ***********************************/

    public static function dblog($sql, $costTime, $db)
    {

        self::$__debugs['db_query'][] = array($db, $sql, $costTime);

    }


	/***********************************
			CURL日志处理
	 ***********************************/

    public static function curlLog($url, $costTime, $inter, $params='')
    {

        self::$__debugs['inter_curl'][] = array($inter, $url, $costTime, $params);

    }


    /***********************************
			错误展示
	 ***********************************/

	private static function constructChar($title, $content, $f, $l, $n)
	{
	
		return "<b>{$title}</b>[$n]:{$content}<br>".
			   "<span style='font-size:12px;line-height:24px;'>in <b>File:</b>{$f} <b>line:</b>{$l}</span>";

	}


	/***********************************
			核心错误处理
	 ***********************************/

	public static function error($error, $file, $line, $errno = 'unknown')
    {

		KeLogs::errorLog($error, $file, $line, $errno);
		
        self::showDebug(self::constructChar('ERROR', $error, $file, $line, $errno));
    
    }


    /***********************************
			SQL错误
	 ***********************************/

    public static function errorSql($sql)
    {
		
        exit("The error happened at the sql statement:{$sql}");
    
    }


	/***********************************
			最终错误处理
	 ***********************************/
    
	public static function showDebug($error='')
    {

        $debugChar = '';
	
		KeLogs::visitLog(strip_tags($error));

        if(self::$__debugShow)
        {

            $costTime = MathHelp::roundMilliSecond(microtime(true) - START_TIME);
         
			$memoryCost = MathHelp::roundMemory(memory_get_usage() - MEMORY_START);

            $debugChar.= HtmlHelp::tableHead("[Debug Toolbar] costTime: <em>{$costTime} ms</em>.  costMemory: <em>{$memoryCost}</em>.", '#999', '#fff');

            self::$__debugs['page_warning'] && $debugChar.= HtmlHelp::tableHead("page_Warning");

            $debugChar.= HtmlHelp::tableBody(self::$__debugs['page_warning']);

            self::$__debugs['page_notice'] && $debugChar.= HtmlHelp::tableHead("page_Notice");

            $debugChar.= HtmlHelp::tableBody(self::$__debugs['page_notice']);

            self::$__debugs['db_query'] && $debugChar.= HtmlHelp::tableHead("Database Query Log");

            $debugChar.= HtmlHelp::tableDbBody(self::$__debugs['db_query'], 'Db');

            self::$__debugs['inter_curl'] && $debugChar.= HtmlHelp::tableHead("Curl Page Log");

            $debugChar.= HtmlHelp::tableDbBody(self::$__debugs['inter_curl'], 'interFace');

            $debugChar = HtmlHelp::debugTable($debugChar);

            exit($debugChar?($error.'<br><hr>'.$debugChar):'<h1>ERROR</h1>');

        }

	}

	
	/***********************************
			测试显示数据
	 ***********************************/
     
	public function showTest($data, $stop=true)
    {
		
        $char = "<br>/".str_repeat('*', 50).'debugShow'.str_repeat('*', 50)."<pre>";
		
		echo $char .=print_r($data, true)."</pre>".str_repeat('*', 110).'/';
		
		if($stop) exit;
	
	}

	
	/***********************************
			平台探针数据
	 ***********************************/

	public function showPhpInfo()
    {

		require(ASSETPATH.'tool/p.php');
		
		exit;
		
	}
	
	

}