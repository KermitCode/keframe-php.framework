<?php

/***********************************
 *Note:		:框架核心配置文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
final class KeLogs extends KeBase implements KeKe
{

	//日志格式

    const VISIT_TEMPLATE = "[TRACE:%s] [logid]%s [IP]%s [uri]%s [app]%s [refer][%s] [get]%s [post]%s [cookie]%s [uid]%s [logs]%s \r\n";
    const ERROR_TEMPLATE = "[ERROR:%s] [logid]%s [IP]%s [uri]%s [app]%s [filename=%s line=%s] [errno=%s errmsg=%s] [uid]%s \r\n";
	const SLOW_TEMPLATE = "[SLOW:%s] [logid]%s [IP]%s [uri]%s [app]%s [slowsql][%s] [slowcurl]%s \r\n";
    

	//日志记录路径，在项目应用下logs目录中

    private static $__logPath;


	//日志记录级别

	private static $_fullLevel;

	//访问日志记录文件，根据配置文件中按时、按日得出名称

    private static $__logFile;


	//异常错误日志，记录异常错误

	private static $__wflogFile;


	//慢查询日志

	private static $__slowlogFile;


	//接口慢查询的阈值

	private static $__slowinterquery;


	//数据库慢查询的阈值

	private static $__slowdbquery;


	//初始化一些日志数据

	private static $__logArr = array();


    /***********************************
            实例化类
     ***********************************/

	public function __construct(&$KE=NULL)
    {

		parent::__construct($KE);

	}


    /***********************************
            初始化日志类
     ***********************************/

	public static function initLogArr($arr)
    {
		 
		self::$__logArr = array_merge(self::$__logArr, $arr);
	
	}


    /***********************************
            设置LOGS配置
     ***********************************/

    public static function setLogsConfig($config)
    {

		$split = (date($config->split == 'hour'?'YmdH':'Ymd'));

		self::$__logFile = $split.'.log';

		self::$__wflogFile = $split.'.wf.log';

		self::$__slowlogFile = $split.'.slow.log';

		$folder = @date($config->folder);

		$logPath = APPLICATION_PATH.'logs/'.($folder?($folder.'/'):'');
		
		if(!FileHelp::checkWrite($logPath))
		{
		
			KeDebug::error("Path:{$logPath} does not have permission to write.");

		}
		
		self::$__logPath = $logPath;

		self::$_fullLevel = ($config->level == 'full');

		self::$__slowinterquery = $config->slowinterquery?$config->slowinterquery:1000;

		self::$__slowdbquery = $config->slowinterquery?$config->slowinterquery:1000;

		return;
    
    }

	
	/***********************************
            基础日志理
     ***********************************/

	private static function baseLog()
	{

		return array(date('m-d H:i:s'), LOG_ID, self::$__logArr['ip'], self::$__logArr['uri'], APPLICATION_NAME);
	
	}


    /***********************************
            处理异常日志内容
     ***********************************/

    private static function makeErrorChar($error, $file, $line, $errno='')
    {

		$uid = defined('UID')?UID:'';

		$logArr = array_merge(self::baseLog(), array($file, $line, $errno, $error, $uid));

		return vsprintf(self::ERROR_TEMPLATE, $logArr); 
    
    }


    /***********************************
            处理一般日志内容
     ***********************************/

    private static function makeVisitChar()
    {

		$logArr = array_merge(self::baseLog(), array_values(array_slice(self::$__logArr, 0, 4)));

		$logArr[] = defined('UID') ? UID : '';

		$logArr[] = json_encode(KeDebug::$__debugs);

		return vsprintf(self::VISIT_TEMPLATE, $logArr);
    
    }


    /***********************************
            慢日志记录
     ***********************************/

	private static function makeSlowChar()
	{	

		$slow_db_query = self::getSlowLog('db_query');

		$slow_inter_curl = self::getSlowLog('inter_curl');

		if(!$slow_db_query && !$slow_inter_curl)
		{
		
			return false;
		
		}
		
		$logArr = array_merge(self::baseLog(), array($slow_db_query, $slow_inter_curl));
	
		return vsprintf(self::SLOW_TEMPLATE, $logArr);

	}


    /***********************************
            提取慢日志
     ***********************************/

	private static function getSlowLog($key)
	{
		
		//慢日志记录

		$slowLogArr = array();

		$maxVal = ($key=='db_query')?self::$__slowdbquery:self::$__slowinterquery;

		foreach(KeDebug::$__debugs[$key] as $row)
		{
			
			if($row[2] > self::$__slowdbquery)
			{
				
				$slowLogArr[] = $row;
			
			}
		
		}
		
		if(!$slowLogArr) return null;

		return json_encode($slowLogArr);

	}


    /***********************************
            记录警告日志
     ***********************************/
	
	public function warning($log)
    {

		FileHelp::writeAdd($this->KE->logPath.$this->KE->logFile, self::makeChar($log));
	
	}
	

	/***********************************
            异常日志
     ***********************************/
	
	public static function errorLog($log, $file, $line, $errno='unknown')
    {

		FileHelp::writeAdd(self::$__logPath.self::$__wflogFile, self::makeErrorChar($log, $file, $line, $errno));
	
	}
	
	/***********************************
            访问日志
     ***********************************/
	
	public static function visitLog()
    {

		self::slowLog();

		FileHelp::writeAdd(self::$__logPath.self::$__logFile, self::makeVisitChar());
	
	}


	/***********************************
            慢查询日志
     ***********************************/
	
	public static function slowLog()
    {

		$slowChar = self::makeSlowChar();

		if($slowChar !== false)
		{

			FileHelp::writeAdd(self::$__logPath.self::$__slowlogFile, $slowChar);
		
		}

	}

		
}