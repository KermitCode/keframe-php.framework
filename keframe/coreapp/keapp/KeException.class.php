<?php

/***********************************
 *Note:		:字符串处理类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
abstract class KeException
{
	

	/***********************************
			异常抛出
	 ***********************************/

	protected static function __getExtension($extension)
    {

         if (!class_exists($extension)){

            throw new Exception("no {$extension} extension in php.ini！");
         
         }

         return new $extension();
     
    }


	/***********************************
			错误处理
	 ***********************************/

	public static function errorHandle( $errno ,  $errstr ,  $errfile ,  $errline )
	{
	
		//终止执行的错误

		if (!( error_reporting () &  $errno ))
		{
			 
			 KeDebug::error('[EXCEPTION]'.$errstr, $errfile, $errline, $errno);

		}
		

		//其它错误处理

		switch($errno)
		{

			case	E_USER_WARNING : KeDebug::warning('[EXCEPTION:WARNING]'.$errstr, $errfile, $errline, $errno);
						
					break;

			case	E_USER_NOTICE  : KeDebug::notice('[EXCEPTION:NOTICE]'.$errstr, $errfile, $errline, $errno);

					break;

			default	: KeDebug::error('[EXCEPTION:ERROR]'.$errstr, $errfile, $errline, $errno);

					break;

		}

	}


}