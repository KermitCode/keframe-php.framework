<?php

/***********************************
 *Note:		:字符串处理类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
class StrHelp
{

	/***********************************
			字符串转义处理
	 ***********************************/	
    
	public static function addslash($data)
    {
		
        return is_array($data)?array_map(array('StrHelp', 'addslash'), $data):addslashes($data);
	
	}

    
	/***********************************
			取得随机字符
	 ***********************************/

	public static function getRandChar($length)
    {
		
	    $char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	
		$max = strlen($char) - 1;
		
		$value='';
		
		for($i = 0; $i < $length; $i++)
        {
			
			$value .= $char[mt_rand(0, $max)];

		}
		
		return $value;
	
	}

    
	/***********************************
			UTF-8中文截取
	 ***********************************/

	public static function substr_zh($str, $len)
    {
		
		$original=$str;
		
		for($i=0;$i<$len;$i++)
        {
			
		    $temp_str=substr($str,0,1);
		   
		    if(ord($temp_str) > 127)
            {

		        $i++;

				if($i<$len)
                {

				    $new_str[]=substr($str,0,3);
				    
                    $str=substr($str,3);
				
                }

		    }else{

				$new_str[]=substr($str,0,1);
				
                $str=substr($str,1);
		    
            }

		}
		
		$returnChar=join($new_str);
		
		if(strlen($returnChar)==strlen($original)) return $returnChar;
		
		else return $returnChar.'...';

	}

    
	/***********************************
	    将gbk编码改为utf8
	 ***********************************/

	public static function gb2utf8($array)
    {
		 
        if(is_array($array))
        {
             
            foreach($array as $key => $value)
            {
                
                $char[self::gb2utf8($key)] = self::gb2utf8($value); 
              
            }
          
        }elseif(is_string($array)){
              
             if(mb_detect_encoding($array)!="UTF-8") return utf8_encode($array); 
             
             else return $array; 
        
        }
         
        return $char; 
	
	}


	/***********************************
	    敏感词处理替换
	 ***********************************/

	public function wordFilter($value,$keyword,$type='1')
    {
	
		/*
		 *敏感词替换函数
		 *$value:要替换的字符串变量
		 *$keyword:敏感词字符串，词间以'|'分开
		 *$type:替换方式
		 *		1，替换成***
		 *		2，去除不留下痕迹
		 *		3，返回数值1表示此变量存在非法字符
		 */
		
		if(!$keyword) exit('the keywords is null or not array');
		
		$keyword=explode('|',$keyword);
		
		if(!is_array($keyword)) exit('keyword is not separate by | char');
		
		if($type!='3')
        {
			
            $goal_char='';
            
            $type=='1' && $goal_char='***';
    
            foreach($keyword as $key=>$val)
            {
        
                $value=str_replace($val,$goal_char,$value);
        
            }
                    
           return $value;
						
		}else{
			
            foreach($keyword as $key=>$val)
            {
        
                if(strpos($value,$val)){return 1;}
        
            }
            
            return 0;
			
		}
	
	}


	/***********************************
			去除空格换行
	 ***********************************/

	public static function DeleteHtml($str)
	{ 

		$str = strip_tags(trim($str),"");

		$str = preg_replace("/[\n| ]{1,}/","",$str); 

		return trim($str);

	}

	/***********************************
	 验证是否为指定长度的字母/数字组合
	 ***********************************/

	public static function checkChar($num1,$num2,$str)
    {
		
		 Return (preg_match("/^[a-zA-Z0-9]{".$num1.",".$num2."}$/",$str))?true:false;
	
	}


	/***********************************
	 验证是否为指定长度数字
	 ***********************************/

	public static function checkNumber($num1,$num2,$str)
    {
		 
		 return (preg_match("/^[0-9]{".$num1.",".$num2."}$/i",$str))?true:false;
	
	}
	

	/***********************************
	 验证是否为指定长度汉字
	 ***********************************/

	public static function checkWords($num1,$num2,$str)
    {
	
		return (preg_match("/^([\x81-\xfe][\x40-\xfe]){".$num1.",".$num2."}$/",$str))?true:false;
	
	}


	/***********************************
	 验证身份证号码
	 ***********************************/

	public static function checkIdentity($str)
    {
		
		 return (preg_match('/(^([\d]{15}|[\d]{18}|[\d]{17}x)$)/',$str))?true:false;
	
	}


	/***********************************
	 验证邮件地址
	 ***********************************/

	public static function checkEmail($str)
    {
		 
		 return (preg_match('/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/',$str))?true:false;
	
	}
	

	/***********************************
	 验证电话号码
	 ***********************************/

	public static function fun_phone($str)
    {
		
	   return (preg_match("/^((\(\d{3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}$/",$str))?true:false;
	
	}


	/***********************************
	 验证邮编
	 ***********************************/

	public function checkZipcode($str)
    {
		
	   return (preg_match("/^[1-9]\d{5}$/",$str))?true:false;
	
	}


	/***********************************
	 验证url地址
	 ***********************************/

	public function checkUrl($str)
    {
	  
	   return (preg_match("/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/",$str))?true:false;
	
	}
	

}