<?php

/***********************************
 *Note:		:数学处理类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
class MathHelp
{

    public static function roundFloat($value, $dec=3)
    {
        
        return round($value, $dec);
    
    }


    public static function roundMilliSecond($value, $dec=3)
    {
        
        return self::roundFloat($value*1000, $dec);
    
    }

	public static function roundSize($size)
	{
	
		$kb=1024;
		
		$mb=$kb*1024;
		
		$gb=$mb*1024;
		
		$tb=$gb*1024;
		
		if($size<$kb)	return $size." byte";
		
		if($size>=$kb and $size<$mb)	return round($size/$kb,2)." KB";
		
		if($size>=$mb and $size<$gb)	return round($size/$mb,2)." MB";
		
		if($size>=$gb and $size<$tb)	return round($size/$gb,2)." GB";
		
		if($size>=$tb)	return round($size/$tb,2)."TB";

	}

	public static function roundMemory($value)
    {
        
        return self::roundSize($value);
    
    }

	
}