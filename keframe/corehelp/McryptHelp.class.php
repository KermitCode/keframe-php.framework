<?php

/***********************************
 *Note:		:mcrypt加密解密辅助类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
class McryptHelp
{

	/***********************************
			MCRYPT加密创建MCRYPT
	 ***********************************/

	private static function get_iv()
    {
		
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		
		return mcrypt_create_iv($iv_size, MCRYPT_RAND);
		
	}
	

	/***********************************
			MCRYPT加密
	 ***********************************/

	public static function mcryptEncode($value,$keycode='')
    {
		
		$this->MCRYPT_KEY=$keycode?$keycode:'KE_MCRYPT';
		
		$crypt_text = mcrypt_encrypt(MCRYPT_RIJNDAEL_256,$this->MCRYPT_KEY,$value, MCRYPT_MODE_ECB,$this->get_iv());
		
		$crypt_text=base64_encode($crypt_text);
		
		return $crypt_text;
	
	}
	

	/***********************************
			MCRYPT解密
	 ***********************************/
     
	public static function mcryptDecode($value,$type=0)
    {
		
		//浏览器解密替换

		$type && $value=str_replace("%2B","+",$value);
		
		$value=base64_decode($value);

		$value=mcrypt_decrypt(MCRYPT_RIJNDAEL_256,$this->MCRYPT_KEY,$value,MCRYPT_MODE_ECB,$this->get_iv());
	
		return $value;
	
	}

	
}