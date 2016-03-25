<?php

/*************************
 *Note:		:全局FTP操作类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

keframe:仅为自己方便而写,不做为对外应用.
格言：适合自己的就是最好的！我只为自己代言。
************************/



/************************************** 类测试 ********************************
$link_ftp = new Link_Ftp('112.125.192.40',21,'username','password'); // 打开FTP连接
$link_ftp->dir_mkdirs('a/b/c.txt');
$link_ftp->up_file('aa.txt','a/b/c/cc.txt'); // 上传文件
$link_ftp->move_file('a/b/c/cc.txt','a/cc.txt'); // 移动文件
$link_ftp->copy_file('a/cc.txt','a/b/dd.txt'); // 复制文件
$link_ftp->del_file('a/b/dd.txt'); // 删除文件
$link_ftp->close(); // 关闭FTP连接
*****************************************************************************/

class FtpOperate{
	
     public $off; // 返回操作状态(成功/失败)

     public $conn_id; // FTP连接
	 
	 /*************************
		执行FTP连接
	 ************************/
	 
	 public function __construct($FTP_HOST,$FTP_PORT,$FTP_USER,$FTP_PASS){
			
		 $this->conn_id = @ftp_connect($FTP_HOST,$FTP_PORT) or die("FTP服务器连接失败");
		
		 @ftp_login($this->conn_id,$FTP_USER,$FTP_PASS) or die("FTP服务器登陆失败");
		 
		 @ftp_pasv($this->conn_id,1); // 打开被动模拟
	
	 }


	/**
	* 方法：上传文件
	* @path -- 本地路径
	* @newpath -- 上传路径
	* @type -- 若目标目录不存在则新建
	*/
	
	public function up_file($path,$newpath,$type=true){
		
		 if($type) $this->dir_mkdirs($newpath);
		 
		 $this->off = @ftp_put($this->conn_id,$newpath,$path,FTP_BINARY);
		   
		 if(!$this->off) echo "文件上传失败，请检查权限及路径是否正确！";
			 
	}


	/**
	* 方法：移动文件
	* @path -- 原路径
	* @newpath -- 新路径
	* @type -- 若目标目录不存在则新建
	*/
	
	public function move_file($path,$newpath,$type=true){
		
		 if($type) $this->dir_mkdirs($newpath);
		 
		 $this->off = @ftp_rename($this->conn_id,$path,$newpath);
		  
		 if(!$this->off) echo "文件移动失败，请检查权限及原路径是否正确！";
		 
	}

	/**
	* 方法：复制文件
	* 说明：由于FTP无复制命令,本方法变通操作为：下载后再上传到新的路径
	* @path -- 原路径
	* @newpath -- 新路径
	* @type -- 若目标目录不存在则新建
	*/
	
	public function copy_file($path,$newpath,$type=true){
		 
		 $downpath = "c:/tmp.dat";
		 
		 $this->off = @ftp_get($this->conn_id,$downpath,$path,FTP_BINARY);// 下载
	
		 if(!$this->off) echo "文件复制失败，请检查权限及原路径是否正确！";
		 
		 $this->up_file($downpath,$newpath,$type);
	
	}


	/**
	* 方法：删除文件
	* @path -- 路径
	*/
	
	public function del_file($path){
	   
	   $this->off = @ftp_delete($this->conn_id,$path);
	  
	   if(!$this->off) echo "文件删除失败，请检查权限及路径是否正确！";
	
	}


	/**
	* 方法：生成目录
	* @path -- 路径
	*/
	
	function dir_mkdirs($path){
			
			$path_arr = explode('/',$path); // 取目录数组
	
			$file_name = array_pop($path_arr); // 弹出文件名
	
			$path_div = count($path_arr); // 取层数
	
			foreach($path_arr as $val){
				
				 if(@ftp_chdir($this->conn_id,$val) == FALSE){
					
					$tmp = @ftp_mkdir($this->conn_id,$val);
				   
					if($tmp == FALSE){
						 
						 echo "failed!";
						 
						 exit;
					 }
					 
					 @ftp_chdir($this->conn_id,$val);
				 
				 }
			
			}
			 
			for($i=1;$i<=$path_div;$i++){
				
				 @ftp_cdup($this->conn_id);
			 
			 }
		 
	}


	/**
	* 方法：关闭FTP连接
	*/
	
	function close(){
		   
			@ftp_close($this->conn_id);
		 
		 }
	
	}// class class_ftp end

?>
