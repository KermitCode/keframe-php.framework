<?php

/***********************************
 *Note:		:模型核心文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
abstract class KeDaobase
{

    /***********************************
		    MYSQL连接配置
	 ***********************************/

	private static $db_dsn;						                      //dsn
	
	private static $db_username;		                              //database username
	
	private static $db_password;                                	  //database password
	
	private static $db_dotype=array(PDO::ATTR_PERSISTENT => false);    //link type if true is long link
	
	private static $db_querychar;			                          //the char type of query
	
	private static $errmode='PDO::ERRMODE_WARNING';					  //the grade of error handling:ERRMODE_WARNING;  ERRMODE_EXCEPTION; ERRMODE_SILENT

    protected $initTime;


    /***********************************
		    核心成员
	 ***********************************/

    protected $__dbResource;

	protected $__dbResourceName;

    protected static $__config = NULL;

	protected $__affectedRows;


   	/***********************************
		    资源连接数据
	 ***********************************/

	protected function init($db, $dbconfig)
    {

	    self::$db_dsn=sprintf("mysql:host=%s;port=%s;dbname=%s", @$dbconfig->host, @$dbconfig->port, @$dbconfig->database);

		self::$db_username=@$dbconfig->username;
		
		self::$db_password=@$dbconfig->password;
		
		self::$db_querychar=sprintf("set names %s;", @$dbconfig->charset);

        return $this->initDb();
	
	}


   	/***********************************
		    资源连接
	 ***********************************/

    private function initDb()
    {
        
        $this->initTime();

		$db = new PDO(self::$db_dsn, self::$db_username, self::$db_password, self::$db_dotype);

		$db->query(self::$db_querychar);
		
		$db->setAttribute(PDO::ATTR_ERRMODE, self::$errmode);

        KeDebug::dblog("Link Database {$this->__dbResourceName}.", $this->calculateTime(), $this->__dbResourceName);
		
		return $db;
    
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
		    销毁资源
	 ***********************************/

    public function destructDao($db='')
    {
        
        self::$__dbResource = NULL;

        self::$__Instance = NULL;

    }


	/***********************************
		    外部检查配置
	 ***********************************/

    public static function __checkConfigIndex($key)
    {
     
		if($key == 'db' && self::$__config)
		{
			
			return true;

		}

        return isset(self::$__config->$key);

    }
	

	/***********************************
		    外部检查配置
	 ***********************************/

    public static function __getSlientDB()
    {
        
        return key(self::$__config);

    }


    /***********************************
		底层查询
	 ***********************************/
    
	public function query($sql, $fetchAll = true)
    {
		
		$this->initTime();

	    $result = @$this->__dbResource->query($sql, PDO::FETCH_ASSOC);

		if($this->__dbResource->errorCode() != '00000')
        {
			
			$error = $this->__dbResource->errorInfo();

			KeDebug::error($error[2]. ', IN SQL:'.$sql, __FILE__, __LINE__, $error[1]);

		}

        KeDebug::dblog($sql, $this->calculateTime(), $this->__dbResourceName);
		
		if(!$fetchAll) return $result->fetch();

		$this->__affectedRows = 0;

		return $result->fetchAll();
		
	}


	/***********************************
		底层增/删/改
	 ***********************************/

	public function execute($sql)
    {
		
		$this->initTime();

	    $result = $this->__dbResource->exec($sql);

		if($this->__dbResource->errorCode() != '00000')
        {
			
			$error = $this->__dbResource->errorInfo();

			KeDebug::error($error[2]. ', IN SQL:'.$sql, __FILE__, __LINE__, $error[1]);

		}

        KeDebug::dblog($sql, $this->calculateTime(), $this->__dbResourceName);

		return $this->__affectedRows = $result;
	
	}
	

    /***********************************
		取最后插入操作的自增ID
	 ***********************************/	
	
    public function getLastInsertId()
    {
		
		return $this->__dbResource->lastInsertId();
	
	}


    /***********************************
		取得影响行数
	 ***********************************/	
	
    public function getAffectedRows()
    {
		
		return $this->__affectedRows;
	
	}


	/***********************************
		    获取表列表
	 ***********************************/

    public function showTables()
    {
        
		$tempTables = $this->query("show tables;");

		$tables = array();

		foreach($tempTables as $row)
		{
			
			$tables[]= current($row);
		
		}

		$tempTables = NULL;

		return $tables;

    }


    /***********************************
		MYSQL类获取表结构
	 ***********************************/

	public function showCreateTable($table)
    {

		return $this->query("show create table {$table};", false);
		
	}


    /***********************************
		取得MYSQL的版本号
	 ***********************************/
	
	public function showVersion()
    {
		
		$rs = $this->query("select VERSION() as version", false);
	
		return $rs['version'];
		
	}


    /***********************************
		取得表所有字段
	 ***********************************/

	public function showFields($table)
    {

		$result = $this->query("select COLUMN_NAME from information_schema.COLUMNS where table_name = '{$table}';");

		$columns = array();

		foreach($result as $row)
		{
			
			$columns[]= current($row);
		
		}

		$result = NULL;

		return $columns;
		
	}


    /***********************************
		MYSQL类获取表结构
	 ***********************************/

	protected function buildCondition($conditions = array())
    {
		
		//传入字符串或者空数据、空字符串均直接返回空字符串

		if(!$conditions) return '';

		if(is_string($conditions)) return ' where '.$conditions;

	
		//传入数组时进行处理

		$arrCondition =array();
		
		foreach($conditions as $key=>$value)
		{
			
			$key=rtrim($key);

            $value = $this->dbslash($value);

			if(strpbrk($key, '<=>') !== false)
			{
	
				$arrCondition[] = "{$key}'{$value}'";
			
			}elseif(strpos($key, ' like') !== false){
			
				$arrCondition[] = "{$key} '%{$value}%'";

			}elseif(strpos($key, ' in') !== false){

				$value = is_array($value)?implode("','", $value):$value;
			
				$arrCondition[] = "{$key} ('{$value}')";

			}else{
			
				$arrCondition[] = "{$key}='{$value}'";

			}

		}
		
		return ' where '.implode(' and ', $arrCondition);
		
	}


	/***********************************
		MYSQL字段组合
	 ***********************************/

	protected function buildField($field = '')
    {
		
		//传入字符串或者空数据、空字符串均直接返回空字符串

		if(!$field) return '*';

		if(is_string($field)) return $field;

	
		//传入数组时进行处理

		if(is_array($field))
		{
		
			return implode(',', $field);
		
		}
		
		return '*';

	}


	/***********************************
		MYSQL自增长字段组合
	 ***********************************/

	protected function buildIncrement($field=array())
    {
		
		//传入字符串或者空数据、空字符串均直接返回空字符串

		if(!$field) return '';

		if(is_string($field)) return $field;

	
		//传入数组时进行处理

		if(is_array($field))
		{

			$sql = '';

			foreach($field as $key => $value)
			{

				$sql.="{$key}={$key} + {$value},";
			
			}
			
			return rtrim($sql, ',');

		}

		return '';
		
	}



	/***********************************
		MYSQL增加修改字段组合
	 ***********************************/

	protected function buildArray($data = array())
    {

		if(!$data) return '';

		$sql_array = array();
		
		foreach($data AS $key=>$value)
        {

            $value = $this->dbslash($value);
            
            $sql_array[] = "{$key} = '{$value}'";
            
        }
        
		return implode(',',$sql_array);
		
	}


	/***********************************
		取最后执行的MYSQL
	 ***********************************/

	public function getLastSql()
    {
		
		$sqls = $this->getAllSql();

		return array_pop($sqls);

	}


	/***********************************
		取得SQL查询次数
	 ***********************************/

	public function getSqlTimes()
    {

		return count($this->getAllSql());

	}


	/***********************************
		取所有执行的MYSQL语句
	 ***********************************/

	public function getAllSql()
    {
		
		$debugSqls = KeDebug::$__debugs['db_query'];

		$sqls = array();

		foreach($debugSqls as $row)
		{
			
			strpos($row[1], 'Link Database') === false && $sqls[]=$row[1];
		
		}
		
		return $sqls;

	}


    /***********************************
		将表结构导出
	 ***********************************/	
	
	protected function getTableStruct($table)
	{
		 
         $tabledump = "DROP TABLE IF EXISTS $table;\r\n";
         
		 $createtable = $this->showCreateTable($table);

		 return $tabledump.$createtable['Create Table'].";\r\n";
	  
	}
	

    /***********************************
		对入库的数据外部转义作处理。
	 ***********************************/

    protected function dbslash($data)
    {
		
        if(is_array($data) or is_object($data))
        {
            foreach($data as $key=>$value)
            {
                return $this->dbslash($value);
            }
        }elseif(is_string($data)){
            
            return addslashes(stripslashes($data));

        }else{
        
            return $data;
        }
	
	}
		
}