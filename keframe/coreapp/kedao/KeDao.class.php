<?php

/***********************************
 *Note:		:框架核心文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/

final class KeDao extends KeDaobase implements KeData
{

	protected static $__Instance = array();


	/***********************************
		配置数据初始化
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
		取得连接资源
	 ***********************************/

    public static function __getInstance($db)
    {

        if(isset(self::$__Instance[$db])) return self::$__Instance[$db];

        if(!isset(self::$__config->$db))
        {
            
            KeDebug::error("no dblink:{$db} in dbconfig!", __FILE__, __LINE__);

        }

        self::$__Instance[$db] = new self($db, self::$__config->$db);

        return self::$__Instance[$db];

    }


    /***********************************
		连接MYSQL
	 ***********************************/

	private function __construct($db, $dbconfig)
    {
		
        $this->__dbResourceName = $db;

		$this->__dbResource = $this->init($db, $dbconfig);

        if(!is_object($this->__dbResource))
        {
            
	        KeDebug::error("Connection db:{$db} failed!", __FILE__, __LINE__);

        }

        return;

	}


    /***********************************
		数据查询
	 ***********************************/

	public function select($table, $conditions=array(), $order='', $field='', $limit='', $groupHaving=array(), $fetchAll = true)
	{

		$conditions=$this->buildCondition($conditions);

		$order = $order?" order by {$order} ":'';

		$limit = $limit?" limit {$limit} ":'';

		$field = $this->buildField($field);

		$groupby = '';
		
		if(!empty($groupHaving['groupby']))
		{
		
			$groupby = " group by {$groupHaving['groupby']} ";

			!empty($groupHaving['having']) && $groupby .= " having {$groupHaving['having']} ";
		
		}

		$sql="select {$field} from {$table} {$conditions} {$groupby} {$order} {$limit} ";

		return $this->query($sql, $fetchAll);
	
	}


    /***********************************
		数据更新
	 ***********************************/

	public function update($table, $data, $conditions=array())
	{
	
		$conditions = $this->buildCondition($conditions);
        
        $sql="update {$table} set ".$this->buildArray($data)." {$conditions}";

		$sql_array = NULL;

		return $this->execute($sql);
	
	}


    /***********************************
		删除表中所据
	 ***********************************/

	public function delete($table, $conditions=array())
    {
		
		$conditions = $this->buildCondition($conditions);

		$sql="delete from {$table} {$conditions}";

		return $this->execute($sql);
		
	}


    /***********************************
		MYSQL表插入数组
	 ***********************************/
    
	public function insert($table, $data)
    { 
        
        $sql="insert into {$table} set ".$this->buildArray($data);
        
        $sql_array = NULL;

        $this->execute($sql);

        return $this->getLastInsertId();

    }
	

    /***********************************
		取得记录总数
	 ***********************************/

	public function count($table, $conditions=array(), $field='', $groupHaving=array())
    {
        
		$condition = $this->buildCondition($conditions);
		
		$field == '' && $field = '*';

		$groupby = '';
		
		if(!empty($groupHaving['groupby']))
		{
		
			$groupby = " group by {$groupHaving['groupby']} ";

			!empty($groupHaving['having']) && $groupby .= " having {$groupHaving['having']} ";
		
		}
	
		$sql = "select count({$field}) as allnum from {$table} {$condition} {$groupby}";

	    $result = $this->query($sql, false);
		
		return $result['allnum'];
		
	}

	
	/***********************************
		取得记录总数
	 ***********************************/

	public function sum($table, $field, $conditions=array(), $groupHaving=array())
    {
        
		$condition = $this->buildCondition($conditions);

		$groupby = '';
		
		if(!empty($groupHaving['groupby']))
		{
		
			$groupby = " group by {$groupHaving['groupby']} ";

			!empty($groupHaving['having']) && $groupby .= " having {$groupHaving['having']} ";
		
		}
	
		$sql = "select sum({$field}) as alsum from {$table} {$condition} {$groupby}";

	    $result = $this->query($sql, false);
		
		return $result['alsum'];
		
	}


    /***********************************
		字段增加
	 ***********************************/
	
	public function increment($table, $data, $conditions)
    {
		
		$condition = $this->buildCondition($conditions);

		$update = $this->buildIncrement($data);

		$sql="update {$table} set {$update} {$condition}";

		return $this->execute($sql);
		
	}
	

    /***********************************
		导出数据表
	 ***********************************/
	
    public function exportTable($table)
	{
		 
        $tabledump = $this->getTableStruct($table);

        $rows = $this->select($table);

		if($rows)
		{

			foreach($rows as $row)
			{

				$tabledump.= "INSERT INTO {$table} VALUES('". implode("','", $row) ."'" . ");\r\n\r\n";
	  
			}

		}
	 
		return $tabledump;

	}


    /***********************************
		导出多个表或整个数据库
	 ***********************************/
	
    public function exportDatabase($tables = array(), $filename='')
	{

		//备份文件保存路径
				
		!defined('BACKUP_PATH') && define('BACKUP_PATH', APPLICATION_PATH.'backup/');

		$filename = date('Y-m-d-H_').($tables?"{$tables}.sql":'alldatabase.sql');

		$filepath = BACKUP_PATH.$filename;


		//文件写权限检测

		if(!FileHelp::checkWrite($dir = dirname($filepath)))
        {

            KeDebug::error("cann't write database backup directory:{$dir},please check the right.", __FILE__, __LINE__);
        
        }


		//tables为空则导出整个数据库

		$tables ||  $tables = $this->showTables();
 
		$databaseSql = '';
		 
		foreach($tables as $table)
		{
			
			$databaseSql .= $this->exportTable($table);	 
			 
		}  
         
		FileHelp::writeNew($filepath, $databaseSql);
		 
		return $filepath;

	}


    /***********************************
		导入SQL文件.未调试
	 ***********************************/
	
	public function importSql($filename, $replace='')
	{

		//备份文件保存路径
				
		!defined('BACKUP_PATH') && define('BACKUP_PATH', APPLICATION_PATH.'backup/');

		$filepath = BACKUP_PATH.$filename;
		
		$readfiles = file_get_contents($filepath);
		
		$replace && $readfiles=str_replace('$timestamp', "$timestamp", $readfiles);
		
		$detail=explode("\n",$readfiles);
		
		$count=count($detail);
		
		for($j=0;$j<$count;$j++)
		{
			
			$ck=substr($detail[$j],0,4);
			
			if(ereg("#",$ck)||ereg("--",$ck) ) continue;
	
			$array[]=$detail[$j];
		
		}
	
		$read=implode("\n",$array); 
		
		$sql=str_replace("\r",'',$read);
	
		$detail=explode(";\n",$sql);
	
		$count=count($detail);
		
		for($i=0;$i<$count;$i++)
		{
			
			$sql=str_replace("\r",'',$detail[$i]);
			
			$sql=str_replace("\n",'',$sql);
			
			$sql=trim($sql);
			
			if($sql){
				
				if(eregi("CREATE TABLE",$sql))
				{
					
					$mysqlV=$this->showVersion();
					
					$sql=preg_replace("/DEFAULT CHARSET=([a-z0-9]+)/is","",$sql);
					
					$sql=preg_replace("/TYPE=MyISAM/is","ENGINE=MyISAM",$sql);
					
					if($mysqlV>'4.1')
					{
						
						$sql=str_replace("ENGINE=MyISAM"," ENGINE=MyISAM DEFAULT CHARSET=".$this->dnsarray['charset'],$sql);
					
					}
						
				}
				
				$query=$this->execute($sql);
				
				if (!$query) die("数据库出错:$sql");
				
				$check++;
			
			}
				
		}
		
		return $check;
	
	}
    

}