<?php

/***********************************
 *Note:		:字符串处理类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
abstract class KeModelBase
{
	
    //使用的连接表

    protected $table='';
	
		
	//模型属性

	public $Attributes=array();


	//模型取数据时的条件

	protected $Conditions=array();


    /***********************************
		    模型表属性查询
	 ***********************************/
	
	protected function __checkTable()
    {
		
		if(!$this->table)
		{
			
			KeDebug::error("you need assign table attribute in Model.", __FILE__, __LINE__);
		
		}

	}


	/***********************************
		    调用资源时直接连接
	 ***********************************/

	public function __get($key)
	{

		if($key=='db' || KeDaobase::__checkConfigIndex($key))
		{

			return $this->__initDb($key);

		}elseif(KeCurl::__checkConfigIndex($key)){
            
            return $this->__initCurl($key);

        }elseif(KeRedis::__checkConfigIndex($key)){
            
            return $this->__initRedis($key);

        }

        return $this->__getDaodata($key);

	}




    /***********************************
		取相关数据
	 ***********************************/

    private function __getDaodata($key)
    {

        switch($key)
        {

            case 'dbVersion'	:return $this->db->showVersion();

            case 'lastInsertId' :return $this->db->getLastInsertId();

            case 'affectedRows' :return $this->db->getAffectedRows();

            case 'lastSql'		:return $this->db->getLastSql();

            case 'sqlTimes'		:return $this->db->getSqlTimes();
            
            default				:return null;

        }

    }


    /***********************************
		    初始化数据库连接
	 ***********************************/

    private function __initDb($db)
    {

		$db=='db' && $db = KeDao::__getSlientDB();

        $this->$db = KeDao::__getInstance($db);

		if(KeDaobase::__getSlientDB() == $db)
		{
		
			$this->db = KeDao::__getInstance($db);
		
		}

		return $this->$db;

    }


    /***********************************
		    分页数据
	 ***********************************/

	protected function initPageConfig($table, $page, $pageSize, $conditions, $groupHaving)
	{

		$totalNum = $this->db->count($table, $conditions, '', $groupHaving);
	
		KePage::setPageConfig($totalNum, $pageSize, $page, $conditions);

	}


    /***********************************
		    初始化Curl资源连接
	 ***********************************/

    protected function __initCurl($key)
    {

        return $this->$key = KeCurl::__getInstance($key);

    }


    /***********************************
		    初始化Curl资源连接
	 ***********************************/

    protected function __initRedis($key)
    {

        return $this->$key = KeRedis::__getInstance($key);

    }

	
    /***********************************
		    取所有表名
	 ***********************************/ 

	public function showTables()
	{
	 
		return $this->db->showTables();
		 
	}


    /***********************************
		    取表结构
	 ***********************************/ 

	public function showCreateTable($table=null)
	{
		
		if(!$table)
		{

			$table = $this->table;

			$this->__checkTable();

		}

		return $this->db->showCreateTable($table);
		 
	}
	

	/***********************************
		    直接取表各字段名
	 ***********************************/ 

	public function showTableFields($table, $flipkey=false)
	{

		if($flipkey)
		{
			
			return ArrObjHelp::arrayValueToEmpty($this->db->showFields($table));

		}	

		return $this->db->showFields($table);
		 
	}


	/***********************************
		    导出数据表
	 ***********************************/ 

	public function exportTable($table = null)
	{
		
		if(!$table)
		{

			$table = $this->table;

			$this->__checkTable();

		}

		return $this->db->exportTable($table);
	
	}


	/***********************************
		    导出多表或整个数据库
	 ***********************************/ 

	public function exportDatabase($tables=array())
	{
		
		return $this->db->exportDatabase($tables);
	
	}


	/***********************************
		    传入表查询数量
	 ***********************************/

	public function countTable($table, $conditions=array(), $field='', $groupHaving=array())
	{

		return $this->db->count($table, $conditions, $field, $groupHaving);

	}


	/***********************************
		    表字段求和
	 ***********************************/

	public function sumTable($table, $field, $conditions=array())
	{

		return $this->db->sum($table, $field, $conditions);

	}
	

	/***********************************
		    直接从表获取多行数据
	 ***********************************/

	public function selectTable($table, $conditions, $order='', $field='*', $limit='', $groupHaving=array(), $fetchAll = true)
	{

		return $this->db->select($table, $conditions, $order, $field, $limit, $groupHaving, $fetchAll);

	}


	/***********************************
		    直接从表获取一行数据
	 ***********************************/

	public function selectOneTable($table, $conditions, $order='', $fields=array())
	{

		return $this->selectTable($table, $conditions, $order, $fields, '1', array(), false);

	}


	/***********************************
		    直接从表取分页数据
	 ***********************************/

	public function pageTable($table, $page=1, $pageSize=50, $order='', $conditions=array(), $field='', $groupHaving=array())
	{
		
		$start = ($page-1)*$pageSize;

		$limit = "{$start},{$pageSize}";

		$this->initPageConfig($table, $page, $pageSize, $conditions, $groupHaving);

		return $this->selectTable($table, $conditions, $order, $field, $limit, $groupHaving);

	}


	/***********************************
		    直接更新表数据
	 ***********************************/

	public function updateTable($table, $data, $conditions= array())
	{

		if(!$data) return false;

		$conditions || $conditions = $this->Conditions;
		
		return $this->db->update($table, $data, $conditions);

	}


	/***********************************
		    直接插入表数据
	 ***********************************/

	public function insertTable($table, $data = array())
	{

		if(!$data) return false;
		
		return $this->db->insert($table, $data);

	}


	/***********************************
		    直接删除数据
	 ***********************************/

	public function deleteTable($table, $conditions= array())
	{

		return $this->db->delete($table, $conditions);

	}


}