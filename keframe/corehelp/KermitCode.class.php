<?php

/*************************
 *Note:		:生成验证码类
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

keframe:仅为自己方便而写,不做为对外应用.
格言：适合自己的就是最好的！我只为自己代言。
************************/

#控制器中调用示例:$this->KE('kermitCode')->makecode(2,5,50,30)->createcode();

class KermitCode{
	
	private $codetype;					//验证码类别 1，四位数字 2，字母  3，字母加数字 4，汉字验证码
	
	private $area=array(40,18);			//验证码的长宽数组
	
	private $codenum;					//验证码位数
	
	public $code;
	
	
	/*************************
		以前写的程序放此保存
	************************/
	
	public function makecode($codetype=1,$codenum=4,$area_wid=40,$area_heig=18){
		
		$this->codetype=$codetype;
		
		$this->codenum=$codenum;
		
		if($area_wid && $area_heig){$this->area=array($area_wid,$area_heig);}
		
		return $this;
		
	}
	
	/*************************
		验证码检验
	************************/
	
	public function checkCode($code){
		
		if($code==$_SESSION["code"]) return true;
		
		else return false;	
		
	}
	
	/*************************
		创建验证码
	************************/
	
	public function createcode(){
		
		$codetype=$this->codetype;
		
		$codenum=$this->codenum;
	
		switch($codetype){
			
				case 1:$codechar=$this->makechar_num($codenum);break;
				
				case 2:$codechar=$this->makechar_letter($codenum);break;
				
				case 3:$codechar=$this->makechar_mix($codenum);break;
				
				case 4:$codechar=$this->makechar_chinese($codenum);break;
				
				default:$codechar=$this->makechar_num($codenum);break;
			
		}
		
		Header("Content-type: image/png");
		
		$_SESSION["code"]=$codechar;
		
		$area=$this->area;
		
		$im=imagecreate($area[0],$area[1]) or die("Cannot Initialize new GD image stream");//生成一个长40高18的图片
		
		$black=imagecolorallocate($im,255,255,255);
		
		$white=imagecolorallocate($im,0,0,0);
		
		$white1=imagecolorallocate($im,215,55,155);//定义字体颜色
		
		if($codetype=='4'){

			$font=FRAMEPATH.'coreAsset/font/kermitcode.ttf';
	
			imagettftext($im,12,0,2,15,$white1,$font,$codechar);
		
		}else imagestring($im,5,3,2,$codechar,$white1);
		
		$white1=imagecolorallocate($im,200,55,150);//定义干扰颜色
		
		imageline($im,rand(0,10), rand(0,10), rand($area[0]/2,$area[0]), rand($area[1]/2,$area[1]),$white1);
		
		for($i=0;$i<20;$i++){ //加入干扰象素
		
			imagesetpixel($im,(rand(0,100)*$area[0])/100,(rand(0,100)*$area[1])/100,$black); 
			
		}	
		
		imagepng($im);
		
		imagedestroy($im);	
		
	}//end function--2
		
		
	public function makechar_num($codenum){
			
			return substr(rand(1000000,9999999),0,$codenum);
		
	}//end function--3
		
		
	public function makechar_letter($codenum){
		
			$letter='abcdefghijklmnopqrstuvwxyz';
			
			$letter_char='';
			
			for($i=0;$i<$codenum;$i++) $letter_char.=$letter[rand(0,25)];
			
			return $letter_char;
		
	}//end function--4
	
		
	public function makechar_mix($codenum){
		
			$letter='0123456789abcdefghijklmnopqrstuvwxyz';
			
			$letter_char='';
			
			for($i=0;$i<$codenum;$i++) $letter_char.=$letter[rand(0,35)];
			
			return $letter_char;
		
	}//end function--5
	
	
	public function makechar_chinese($codenum){
		
		$letter=array('大','小','多','少','工','人','车','马','左','右','上','下','关','云','太','阳','子','爸','妈','爷','奶',
					  '一','二','三','四','五','六','七','八','九','十','牛','今','天','金','木','水','火','土','红','色','衣',
					  '花','士','失','母','哭','笑','苦','兴','未','来','生','日','月','方','中','后','开','会','内','在','白',
					  '各','国','有','足','手','头','公','共','去','口','心','非','回','东','南','西','北','电','闪','雷','星',
					  '不','过','这','那','什','么','田','用','元','发','又','及','早','出','厂','长','合','女','年','岁','见');
	
		$letter_char='';
		
		for($i=0;$i<$codenum;$i++) $letter_char.=$letter[rand(0,104)];
		
		return $letter_char;
		
	}//end function--6

	



	
}//end class



?>
