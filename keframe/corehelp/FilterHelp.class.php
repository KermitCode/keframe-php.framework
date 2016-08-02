<?php

/***********************************
 *Note:		:垃圾评论过滤
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
class FilterHelp
{

	/***********************************
			判断是否有意义评论
	 ***********************************/	
    
	public static function isValidData($s)
    {
        
        if(preg_match("/([\x{4e00}-\x{9fa5}].+)\\1{4,}/u",$s))
        {
            return false;//同字重复５次以上

        }elseif(preg_match("/^[0-9a-zA-Z]*$/",$s)){

            return false;//全数字，全英文或全数字英文混合的
        
        }elseif(strlen($s)<10){

            return false;//输入字符长度过短
        }

        return true;
    }


    /***********************************
	   过滤敏感词汇
       true 包含敏感词汇  false不包含
	 ***********************************/
   
    public static function filterSensitiveString($string)
    {
        mb_internal_encoding("UTF-8");
    
        $string = trim(mb_strtolower($string));
    
        //精确匹配
        $filepath = ASSETPATH.'filterwords/filter_whole_words.txt';
        $content = file_get_contents($filepath);
        $fn_list = explode("\n", $content);
        $forbidword_arr = array();
        foreach($fn_list as $fn)
        {
            $fn = trim($fn);
            if (strlen($fn) == 0)
            {
                continue;
            }
            $forbidword_arr[] = $fn;
        }
        foreach ($forbidword_arr as $forbidword)
        {
            if ($string == mb_strtolower($forbidword))
            {
                return true;
            }
        }
    
        //模糊匹配
        $filepath = ASSETPATH.'filterwords/filter_words.txt';
        $content = file_get_contents($filepath);
        $fn_list = explode("\n", $content);
        $forbidword_arr = array();
        foreach($fn_list as $fn)
        {
            $fn = trim($fn);
            if (strlen($fn) == 0)
            {
                continue;
            }
            $forbidword_arr[] = $fn;
        }
        foreach ($forbidword_arr as $forbidword)
        {
            if (false !== mb_strpos($string, mb_strtolower($forbidword)))
            {
                return true;
            }
        }
        return false;
    }

    
    /***********************************
	   过滤字符串中包含的特殊字符(标点符号)
       true 含有非法符号  false不含
	 ***********************************/

    public static function filterSpecialString($string)
    {
        // 包含以下符号
        $regex = '/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\"|\`|\-|\=|\\\|\|/';
    
        if(preg_match($regex, htmlspecialchars_decode($string)))
        {
            return true;
        }
        return false;
    }







	





}