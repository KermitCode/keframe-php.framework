<?php

/*************************
 *Note:		:文件处理函数
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

keframe:仅为自己方便而写,不做为对外应用.
格言：适合自己的就是最好的！我只为自己代言。
************************/
 
class FileHelp
{

	
	/***********************************
	        检查是否可写
	 ***********************************/
	
	public static function checkWrite($dirOrFile)
    {

        if(!is_dir($dirOrFile)) @mkdir($dirOrFile, 0777, true);

		$writeable = false;
        
		if (is_dir($dirOrFile))
		{

			if($fp = @fopen("{$dirOrFile}/test_keframe_temp_checkwrite.txt", 'w'))
			{

				@fclose($fp);

			    @unlink("{$dirOrFile}/test_keframe_temp_checkwrite.txt");

				$writeable = true;

			}

		}else{

			if($fp = @fopen($file, 'a+'))
			{

				@fclose($fp);

				$writeable = true;

			}

		}

		return $writeable;
		
	}
	
	
	/***********************************
	        获取文件夹下文件列表
	 ***********************************/

	public static function directory($dir)
    {
		
		$returnFileArr=array();

		if(!$dir || !is_dir($dir)) return false;
		
		$dh=opendir($dir);
		  
		while($file=readdir($dh))
        {

            if($file!="." && $file!="..")
            {
              
                 $fullpath=$dir.$file;
                 
                 if(!is_dir($fullpath))
                 {
                    
                    $returnFileArr[]=$fullpath;						 
                  
                 }
            
            }
			  
		 }
		 
		 closedir($dh);
		 
		 return $returnFileArr;

	}
	

	/***********************************
	        scan获取文件夹下文件列表
	 ***********************************/

	public static function scanDirectory($dir, $directory='all')
    {

		$disFunArr = KePhpini::getIni('disable_functions', ',');

		if($disFunArr !== false && !in_array('scandir', $disFunArr))
		{
			
			return self::useScanDir($dir, $directory); 

		}


		//$directory:all,扫描文件夹和文件；file: 文件 folder:文件夹
		
		$returnFileArr=array();

		if(!$dir || !is_dir($dir)) return false;

		$dir = rtrim($dir , '/').'/';

		$dh=opendir($dir);
		  
		while($file=readdir($dh))
        {
			
			if($file == "." || $file == "..") continue;

			$fullpath = $dir.$file;

			switch($directory)
			{

				case 'folder' : if(is_dir($fullpath)) $returnFileArr[]=$fullpath; 					 
								  
								break;

				case 'file'   : if(is_file($fullpath)) $returnFileArr[]=$fullpath; 					 
								  
								break;	

				case 'all'	  : $returnFileArr[]=$fullpath;
		
			}

		}

		return $returnFileArr;
		
	}


	/***********************************
	        当scandir函数没有被禁用时
	 ***********************************/

	private static function useScanDir($dir, $directory='all')
	{

		$returnFileArr = array();
	
		$tempdir = scandir($dir);
		  
		foreach( $tempdir as $fileChild)
        {

            if($fileChild == "." || $fileChild == "..") continue;
                          
			$fullpath = $dir.$fileChild;
			 
			switch($directory)
			{

				case 'folder' : if(is_dir($fullpath)) $returnFileArr[]=$fullpath; 					 
								  
								break;

				case 'file'   : if(is_file($fullpath)) $returnFileArr[]=$fullpath; 					 
								  
								break;	

				case 'all'	  : $returnFileArr[]=$fullpath;    
		
			}
		  
		 }
		 
		 return $returnFileArr;

	}
	



	/***********************************
	        获取文件夹下所有文件夹
	 ***********************************/

	public static function directorys($dir)
    {
		
		$returnFileArr=array();

		if(!$dir || !is_dir($dir)) return false;
		
		$dh=opendir($dir);
		  
		while($file=readdir($dh))
        {

            if($file!="." && $file!="..")
            {
              
                 $fullpath=$dir.$file.'/';
                 
                 if(is_dir($fullpath))
                 {
                    
                    $returnFileArr[]=$fullpath;						 
                  
                 }
            
            }
			  
		 }
		 
		 closedir($dh);
		 
		 return $returnFileArr;

	}

	/***********************************
	        清空文件夹下所有文件
	 ***********************************/

	public static function clear($dir)
    {
		
		if(!$dir || !is_dir($dir)) return false;

		$dh=opendir($dir);
		  
		while($file=readdir($dh))
        {

            if($file!="." && $file!="..")
            {
              
                $fullpath=$dir.$file;
                 
                if(!is_dir($fullpath))
                {
                    
                    unlink($fullpath);
                  
                }else{
                    
                    $this->clear($fullpath.'/');
                      
                    rmdir($fullpath); 
                  
                }
                
            }
			  
		 }
		 
		 closedir($dh);
		 
		 return true;	
		
	}


	/***********************************
	        增写文件
	 ***********************************/

	public static function writeAdd($path, $text)
    {
		
		$fp=fopen($path,'ab');
		
		fwrite($fp,$text);
		
		fclose($fp);
		
		return true;	
		
	}
	

	/***********************************
	        新写文件
	 ***********************************/

	public static function writeNew($path, $text)
    {
		
		return file_put_contents($path, $text);
		
	}


	/***********************************
	        创建多级目录
	 ***********************************/
     
    public static function makeDir($dir,$mode = "0777" )
    {
  
	   if(!$dir) return false;
	
	   $dir = str_replace( "\\", "/", $dir );
	  
	   $mdir = "";
	   
	   foreach( explode( "/", $dir ) as $val )
       {
		   
			$mdir .= $val."/";
	   
			if( $val == ".." || $val == "." || trim( $val ) == "" ) continue;
	  
			if(!file_exists($mdir))
            {
		   
				if(!@mkdir( $mdir, $mode )) return false;
			
			}
			
	   }
	   
	   return true;
	   
	}
	

	/***********************************
	        输出下载文件
	 ***********************************/
     
	public static function outputFile($filesize,$url)
    {
		
		header("Content-type: application/octet-stream"); 

		header("Accept-Ranges: bytes"); 
		
		header("Accept-Length: {$filesize}");
		
		header("Content-Disposition: attachment; filename=".basename($url)); 
		
		header("location: $url");
		
		exit;
	
	}

		
}