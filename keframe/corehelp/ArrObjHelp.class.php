<?php

/***********************************
 *Note:		:数组对象辅助类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
class ArrObjHelp
{

	/***********************************
			数组转为对象
	 ***********************************/	
    
	public static function arrayToObject($e)
    {

        if( gettype($e)!='array' ) return new KeStdclass();
       
        foreach($e as $k=>$v)
        {

            if( gettype($v)=='array' || getType($v)=='object' )
            {
                
                $e[$k]=(object) (self::arrayToObject($v));
            
            }

        }

        return (object)$e;
    
    }


	/***********************************
			对象转为数组
	 ***********************************/
 
    public static function objectToArray($e)
    {

        $e=(array)$e;

        foreach($e as $k=>$v)
        {
            
            if( gettype($v)=='resource' ) return;
            
            if( gettype($v)=='object' || gettype($v)=='array' )
            
            $e[$k]=(array)(self::objectToArray($v));
        }

        return $e;
    
    }
 

 	/***********************************
			取数组键名值为空
	 ***********************************/
 
    public static function arrayValueToEmpty($array)
    {

		$arr = array();

        foreach($array as $value)
		{
				
			$arr[$value] = '';

		}

        return $arr;
    
    }

	/***********************************
			对象转为数组
	 ***********************************/
 
    function object_to_array($e)
    {
        
        $_arr = is_object($e) ? get_object_vars($e) : $e; 
        
        foreach ($_arr as $key => $val)
        {
        
            $val = (is_array($val) || is_object($val)) ? (self::object_to_array($val)) : $val; 
            
            $arr[$key] = $val; 
      
        }
        
        
        return $arr; 
    
    }
	
}