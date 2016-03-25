<?php
/*************************
 *Note:		:Access数据库连接，用得少，放此保存
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

keframe:仅为自己方便而写,不做为对外应用.
格言：适合自己的就是最好的！我只为自己代言。
************************/

class AccessData{
	
	public $Access=NULL;
	
	public function __construct(){
		
		
		
	}

	public function php_access($dbpath){
		
		if($this->Access) return $this->Access;
	
		if(strtolower(end(explode('.',$dbpath)))!='mdb') exit('please use .mdb file');
	
		try{
		
			$db = new PDO("odbc:driver={microsoft access driver (*.mdb)};dbq={$dbpath}");
		
			$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		} catch (Exception $e) {
			
			echo "Failed:".$e->getMessage();
		
		}
		
		$this->Access=$db;
		
		return $this->Access;
	
	}

}

















?>