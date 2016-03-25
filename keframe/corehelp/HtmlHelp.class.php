<?php

/***********************************
 *Note:		:框架核心文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
class HtmlHelp
{

    /***********************************
		    将数组展示成下拉菜单
	 ***********************************/	

	public static function select($name,$array,$select,$attributes=array())
    {
		
		$html="<select name='{$name}' >";
		
		foreach($array as $key=>$value)
        {
			
			$select_char=$select==$key?"selected":'';
			
			$html.="<option {$select_char} value='{$key}'>{$value}</option>\r\n";
			
		}
			
		$html.="</select>";
		
		return $html;
	
	}


    /***********************************
		    展示多个单选按钮
	 ***********************************/	

	public static function radio($name,$array,$select=0,$attributes=array())
    {
		
		$html='';
		
		foreach($array as $key=>$value)
        {
			
			$checked=$key==$select?'checked':'';
			
			$html.="<input type='radio' name='{$name}' value='{$key}' {$checked}>&nbsp;{$value}&nbsp;&nbsp;";
				
		}
		
		return $html;

	}

	
	public static function headerCharset($charSet)
	{
		
		!headers_sent() && header("Content-type:text/html;charset={$charSet}");
		
	}


    /***********************************
		    生成表格头部
	 ***********************************/

    public static function tableHead($value, $backgroundColor='#fff', $color='#999')
    {
        
        $background = $backgroundColor?"style='background-color:{$backgroundColor};font-size:13px;color:{$color};'":'';

        return "<thead><tr><td {$background}>{$value}</td></tr></thead>";
    
    }


    /***********************************
		    生成表格中部
	 ***********************************/    

    public static function tableBody($array)
    {
        
        if(!$array) return '';

        $bodyChar = '';
        
        foreach($array as $value)
        {
        
            $bodyChar.="<tr><td>{$value}</td><tr>";

        }

        return "<tbody>{$bodyChar}</tbody>";
    
    }

    /***********************************
		    生成表格中部
	 ***********************************/    

    public static function tableDbBody($array, $pre)
    {

        if(!$array) return '';

        $bodyChar = '';
        
        foreach($array as $sql=>$row)
        {

            $bodyChar.="<tr><td>[{$pre}:{$row[0]}-CostTime:{$row[2]} ms]:{$row[1]}</td><tr>";

        }

        return "<tbody>{$bodyChar}</tbody>";

    }


    /***********************************
		    生成调试表格
	 ***********************************/

    public static function debugTable($tableBody)
    {
        
        $css = '<style type="text/css">'
               .'.debugTable{border-right:1px solid #ccc;border-bottom:1px solid #ccc;font-size:12px;width:100%;margin:0px;color:#666;} '
               .'.debugTable td{padding:1px;border-left:1px solid #ccc;border-top:1px solid #ccc}'
               .'.debugTable thead td{padding:3px;font-weight:bolder;color:#999;}'
			   .'.debugTable thead td em{color:yellow;font-style:normal;}'
               .'</style>';

        return $css.'<div style="clear:both;"><table class="debugTable" cellpadding="0" cellspacing="0">'.$tableBody.'</table></div>';
    
    }
	

    /***********************************
		    去掉空格和换行
	 ***********************************/

	public static function trimAll($str)
	{

		$replace = array(" ","　","\t","\n","\r");
		
		return str_replace($replace, '', $str);   
	
	}

}