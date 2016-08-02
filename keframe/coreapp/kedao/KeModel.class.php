<?php

/***********************************
 *Note:		:模型核心文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
class KeModel extends KeModelBase
{

	/***********************************
		    直接执行原始查询SQL
	 ***********************************/

	public function query($sql)
	{

		return $this->db->query($sql);

	}


	/***********************************
		    直接执行原始增改SQL
	 ***********************************/

	public function execute($sql)
	{

		return $this->db->execute($sql);

	}


	/***********************************
		    获取一行数据
	 ***********************************/

	public function selectOne($conditions, $order='', $fields=array())
	{

		$this->Attributes = $this->select($conditions, $order, $fields, '1', array(), false);

        $this->Conditions = $conditions;

		return $this->Attributes;

	}


	/***********************************
		    获取多行数据
	 ***********************************/

	public function select($conditions, $order='', $fields='*', $limit='', $groupHaving=array(), $fetchAll=true)
	{

		$this->__checkTable();

		$this->Conditions = $conditions;

		$this->Attributes = $this->db->select($this->table, $conditions, $order, $fields, $limit, $groupHaving, $fetchAll);

		return $this->Attributes;

	}


	/***********************************
		    更新模型数据
	 ***********************************/

	public function update($data = array(), $conditions= array())
	{

		$this->__checkTable();

		$data || $data = $this->Attributes;

		if(!$data) return false;

		$conditions || $conditions = $this->Conditions;
		
		$result = $this->db->update($this->table, $data, $conditions);

		if($result)	
		{
			
			//更新模型数据属性值

			$this->Attributes = array_merge($this->Attributes, $data);

			return true;
		
		}

		return false;

	}


	/***********************************
		    删除模型数据
	 ***********************************/

	public function delete($conditions= array())
	{

		$this->__checkTable();

		$conditions || $conditions = $this->Conditions;

		if(!$conditions) return false;
		
		$result = $this->db->delete($this->table, $conditions);

		if($result)	
		{
			
			//更新模型数据属性值

			$this->Attributes = array();

			return true;
		
		}

		return false;

	}


	/***********************************
		    保存模型数据
	 ***********************************/

	public function save()
	{

		if(!$this->Attributes) return false;

		if($this->Conditions) return $this->update();

		else return $this->insert();

	}


	/***********************************
		    取表各字段名
	 ***********************************/ 

	public function showFields($flipkey=false)
	{

		$this->__checkTable();
		
		if($flipkey)
		{
			
			return ArrObjHelp::arrayValueToEmpty($this->db->showFields($this->table));

		}	

		return $this->db->showFields($this->table);
		 
	}


	/***********************************
		    模型插入数据
	 ***********************************/

	public function insert($data = array())
	{

		$this->__checkTable();

		$data || $data = $this->Attributes;

		if(!$data) return false;
		
		$result = $this->db->insert($this->table, $data);

		if($result)	
		{
			
			//更新模型数据属性值

			$this->Attributes = $data;

			return $result;
		
		}

		return false;

	}
	

	/***********************************
		    获取分页数据
	 ***********************************/

	public function page($page=1, $pageSize=50, $order='', $conditions=array(), $field='', $groupHaving=array())
	{

		$this->__checkTable();
		
		$start = ($page-1)*$pageSize;

		$limit = "{$start},{$pageSize}";

		$this->initPageConfig($this->table, $page, $pageSize, $conditions, $groupHaving);

		return $this->select($conditions, $order, $field, $limit, $groupHaving);

	}


	/***********************************
		    数据自增
	 ***********************************/

	public function increment($data, $conditions=array())
	{

		$this->__checkTable();

		$conditions || $conditions = $this->Conditions;

		if(!$data) return false;

		return $this->db->increment($this->table, $data, $conditions);

	}


	/***********************************
		    查询数量
	 ***********************************/

	public function count($conditions=array(), $field='', $groupHaving=array())
	{

		$this->__checkTable();

		return $this->db->count($this->table, $conditions, $field, $groupHaving);

	}


    /***********************************
		    表字段求和
	 ***********************************/

	public function sum($field, $conditions=array())
	{

        $this->__checkTable();

		return $this->db->sum($this->table, $field, $conditions);

	}

	
}