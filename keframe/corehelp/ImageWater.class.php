<?php

/*
 *图片上传类-并执行按位置加图片水印
 *kermit 2012-6-12
 */


class ImageWater{
	
	public $imgpath;								//得到的图片的目标存储路径
	
	private $maxsize=512000;						//上传文件大小限制, 默认为500KB
	
	private $watermark=1;      						//是否加水印(1为加水印,其他为不加)
	
	private $waterpos=4;   			    			//水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);
	
	private $wateralpha=60;   			    		//水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);

	private $waterimg="2.gif";  				    //水印图片
		
	private $uptypes=array('image/jpg', 'image/jpeg','image/png','image/pjpeg','image/gif','image/bmp','image/x-png');
	
	//上传图片的类型

public function __construct($watermark='',$waterimg='',$waterpos='',$maxsize='',$wateralpha='',$uptypes=''){
	
	$args_arr=func_get_args();
	
	$args_array=array('watermark','waterimg','waterpos','maxsize','wateralpha','uptypes');
	
	foreach($args_arr as $key=>$value){
		
		if($value!='') $this->$args_array[$key]=$value;
	
		}//end foreach
		
	unset($args_arr,$args_array,$key,$value);
	
}//end function--1


public function getimg_savepath(){
	
	$monthnum=date("n")>6?'02':'01';

	$this->imgpath=ROOT_PATH."upload_img/".date("Y").$monthnum.'/';
	
	if(!file_exists($this->imgpath)) mkdir($this->imgpath);

	return $this->imgpath;
		
}//end function--2


public function upload_imgfile($name){
	
	//传入(文章类别,图片表单name)-上传图片-返回图片路径
	
	if($name=='' || !is_uploaded_file($_FILES[$name]['tmp_name'])) return;
		
	//$_SERVER['REQUEST_METHOD']!='POST' && exit('hack!');

	$imagefile=$_FILES[$name];
	
	if($this->maxsize<$imagefile["size"]) exit("文件大小超过限制!");

  	if(!in_array($imagefile["type"],$this->uptypes)) exit("文件类型{$imagefile['type']}不符!");
        
	$img_path=$this->getimg_savepath();

	$file_name=$imagefile["name"];
	
	if(file_exists($img_path.$file_name)){//文件名存在需要更名
		
		$return_back=$img_path.date("mdHis").rand(1,99).substr($file_name,strrpos('.',$file_name));
		
	}else $return_back=$img_path.$file_name;
	
	//执行图片上传程序
	
	if(!move_uploaded_file($imagefile["tmp_name"],$return_back)) exit("图片上传出错");
	
	if($this->watermark && is_file($this->waterimg)){//给上传的图片上水印

		$this->make_water($return_back);
			
		}
		
	return $return_back;

}//end function--3


public function create_imgfile($imgname,$imgtype,$class=1,$imgfile=''){
	
	//按$class值：1返回由imgname创建出来的图像 0将imgfile图像流输出至浏览器
	
	switch($imgtype){
		
		case 1:if($class) return imagecreatefromgif($imgname);
			   else imagejpeg($imgfile,$imgname);break;
			   
		case 2:if($class) return imagecreatefromjpeg($imgname);
			   else imagejpeg($imgfile,$imgname);break;
			   
		case 3:if($class) return imagecreatefrompng($imgname);
			   else imagepng($imgfile,$imgname);break;
			   
		case 6:if($class) return imagecreatefromwbmp($imgname);
			   else imagewbmp($imgfile,$imgname);break;
			   
		default:exit("不支持的文件类型");

		}

}//end function 4
	
	
public function make_water($img){

	list($width,$height,$type, $attr)=getimagesize($img);
	
	$nimage=imagecreatetruecolor($width,$height);
    
	$white=imagecolorallocate($nimage,255,255,255);
    
	$black=imagecolorallocate($nimage,0,0,0);
    
	$red=imagecolorallocate($nimage,255,0,0);
    
	imagefill($nimage,0,0,$white);
	
	$simage=$this->create_imgfile($img,$type,1);

    imagecopy($nimage,$simage,0,0,0,0,$width,$height);
	
    imagefilledrectangle($nimage,1,$width-15,80,$height,$white);

    $simage1=imagecreatefromgif($this->waterimg);
	
	list($width_sy,$height_sy,$type_sy,$attr)=getimagesize($this->waterimg);
	
	$waterxy=$this->getPosxy($width,$height,$width_sy,$height_sy);
    
	//imagecopy($nimage,$simage1,$waterxy['x'],$waterxy['y'],0,0,$width_sy,$height_sy);
	imagecopymerge($nimage,$simage1,$waterxy['x'],$waterxy['y'],0,0,$width_sy,$height_sy,$this->wateralpha);
    
	imagedestroy($simage1);

    $this->create_imgfile($img,$type,0,$nimage);
      
    imagedestroy($nimage);
    
	imagedestroy($simage);
	
}//end function--4 


public function getPosxy($wd1,$hd1,$wd2,$hd2){
	
	$this->waterpos==5 && $this->waterpos=rand(1,4);
	
	//返回水印的初始XY座标值
	
	 switch($this->waterpos){
		  
			case 1://1为左上角 
				$pos['x']=0;$pos['y']=0;break; 
				
			case 2://2为右上角 
				$pos['x']=$wd1-$wd2;$pos['y']=0;break; 
				
			case 3://3为左下角 
				$pos['x']=0; $pos['y']=$hd1-$hd2;break;
				 
			case 4://4为右下角 
				$pos['x']=$wd1-$wd2;$pos['y']=$hd1-$hd2;break;
				
			case 6://随机位置 
				$pos['x']= rand(0,($wd1-$wd2));$pos['y']=rand(0,($hd1-$hd2));break;
				
			default:$pos['x']=0;$pos['y']=0;break;
    	
		}
	
	return $pos;
		
}//end function--5


public function create_slt($img,$maxwidth=200,$maxheight=150,$ratio=0){
	
		list($width,$height,$type,$attr)=getimagesize($img);

		$im=$this->create_imgfile($img,$type,1);
		
		$newpic=$this->getslv_name($img);
	
		if($ratio!=0){//比率不为0则按比率缩小图片
		
			$newwidth=$width*$ratio;
			
			$newheight=$height*$ratio;
			
		}else{//按合适高宽选取
				
				if(($maxwidth && $width > $maxwidth) || ($maxheight && $height > $maxheight)){
				
						if($maxwidth && $width>$maxwidth){$widthratio=round(($maxwidth/$width),3);$RESIZEWIDTH=true;}
						
						if($maxheight && $height>$maxheight){$heightratio=round(($maxheight/$height),3);$RESIZEHEIGHT=true;}

						if($RESIZEWIDTH && $RESIZEHEIGHT){
							
							if($widthratio<$heightratio) $ratio = $widthratio;
							
							else $ratio=$heightratio;
							
						}elseif($RESIZEWIDTH){$ratio = $widthratio;
					
						}elseif($RESIZEHEIGHT){$ratio = $heightratio;
						
						}
				
				}else{//大小无变化
	
						$ratio=1;
						
				}
				
		}//得出新图片高/宽的缩小比例
		
		$newwidth=$width*$ratio; $newheight=$height*$ratio;
				
	   if(function_exists("imagecopyresampled")){
	
	  		   $newim = imagecreatetruecolor($newwidth,$newheight);
	  
	  		   imagecopyresampled($newim,$im, 0, 0, 0, 0,$newwidth,$newheight,$width,$height);
  
	   }else{

			   $newim = imagecreate($newwidth,$newheight);
		
			   imagecopyresized($newim,$im, 0, 0, 0, 0,$newwidth,$newheight,$width,$height);

	   }
						
		ImageJpeg($newim,$newpic);

		ImageDestroy($newim);

	return $newpic;
	
}//end function--6


//获取缩略图名称

public function getslv_name($imgname){
	
	$pos=strrpos($imgname,'.');
	
	return substr($imgname,0,$pos).'_slt'.substr($imgname,$pos);
	
	}//end function--7


//将图片大小全部做成400*300px大小,并且图片不变形	
	
public function change_size($img,$maxwidth=400,$maxheight=300,$rgb=array(150,220,180)){

		list($width,$height,$type,$attr)=getimagesize($img);
		
		list($red,$green,$blue)=$rgb;
	
		$widthratio=$heightratio=1;
		
		if($width>$maxwidth){$widthratio=($maxwidth/$width);}
				
		if($height>$maxheight){$heightratio=($maxheight/$height);}
	
		$ratio=$widthratio<$heightratio?$widthratio:$heightratio;
		
		$newwidth=$width*$ratio; $newheight=$height*$ratio;
		
		$dst_x=($maxwidth-$newwidth)/2;
		
		$dst_y=($maxheight-$newheight)/2;
		
		$im=$this->create_imgfile($img,$type,1);
				
	    if(function_exists("imagecopyresampled")){
	
	  		   $newim=imagecreatetruecolor($maxwidth,$maxheight);
			   
			   $color=imagecolorallocate($newim,$red,$green,$blue);
			   
			   imagefill($newim,0,0,$color);
	  
	  		   imagecopyresampled($newim,$im,$dst_x,$dst_y,0,0,$newwidth,$newheight,$width,$height);
  
	    }else{

			   $newim = imagecreate($maxwidth,$maxheight);
			   
			   $color=imagecolorallocate($newim,$red,$green,$blue);

			   imagefill($newim,0,0,$color);
		
			   imagecopyresized($newim,$im,$dst_x,$dst_y,0,0,$newwidth,$newheight,$width,$height);

	    }
						
		ImageJpeg($newim,$img);

		ImageDestroy($newim);

	return $img;
	
}	

	
}//end class


/*/接收
$action=isset($_GET['action'])?$_GET['action']:'';
if($action=='upimg'){//上传	
$upimg_water=new upimg_water();
$newimg=$upimg_water->upload_imgfile("upfile");
echo "<img src='{$newimg}'>";

<form enctype="multipart/form-data" method="post" name="upform" action="kermit_image_water.php?action=upimg">
  上传文件:
  <input name="upfile" type="file">
  <input type="submit" value="上传">
</form>
}
*/


?>