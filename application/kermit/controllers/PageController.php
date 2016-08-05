<?php

/***********************************
 *Note:		:管理后台首页控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2015-12
 ***********************************/
 
class PageController extends BaseController
{
	
	//应用全局加载
	public function __init()
	{
		//权限检查
		$this->checkAdmin();

		//基本设置
		$this->setbasicData();

	}


	//文章列表
	public function actionindex()
	{

		//取文章列表
		$this->cate=$this->getCategory();
		$ArticleModel = new ArticleModel();
		$this->pageData = $ArticleModel->page($this->page, 11, 'id desc', '', array('id,ar_tui,ar_cid,ar_title,ar_tags,ar_time,ar_yd,ar_view,ar_views,ar_comments'));
		$this->view();
		
	}
	

	//删除文章
	public function actionDelete()
	{
	
		$this->checkAdmin(true);
		$id = intval($this->get('id'));
		
		//删除文章
		$ArticleModel = new ArticleModel();
		$rs=$ArticleModel->delete(array('id'=>$id));	
		
		//结果展示
		$show=$rs?'操作成功!':'操作失败!';		
		RedirectHelp::alertGo($show);
		
	}
	
	//发表新文章及文章修改
	public function actionCreate()
	{
		
		$this->pageData=array();		
		$id=intval($this->get('id'));
		$ArticleModel = new ArticleModel();
		if($id) $this->pageData = $ArticleModel->selectOne(array('id'=>$id));
		
		if(!$this->pageData)
		{
			$this->pageData = $ArticleModel->showFields(true);
			$id=0;
		}
		
		//取文章类别数据
		$this->category=$this->getCategory();
		foreach($this->category as $key=>$value)
		{
			$this->category[$key]=$value['cn'];
		}

		$this->view();

	}
	
	//修改下载资源对应的文章
	public function changeSource($pageid,$arr)
    {
		
		//$arr为文章中对应的下载资源ID数组
		if(!$arr) return;
		
		//取出资源集合
        $DownloadModel = new DownloadModel();
		$source = $DownloadModel->select(array("id in"=>$arr));

		if(!$source) return;
		
		//修改资源对应文章
		foreach($source as $row)
        {
			$ids=array();
			if($row['relatepage']) $ids=explode(',', $row['relatepage']);
			$ids[]=$pageid;
			$ids=array_unique($ids);
			foreach($ids as $k=>$v)
            {
                if(!$v) unset($ids[$k]);
            }
			sort($ids);
			if($ids)
            {
				$DownloadModel->update(array('relatepage'=>implode(',',$ids)), array('id'=> $row['id']));
			}	
		}
		
		return true;	
		
	}
	
	//发表新文章及文章修改的处理程序
	public function actionPagesub()
	{

		//取文章ID以确定是新增还是修改
		$id=$this->post('id');
		$sid=$id;
		$data = $this->post();
		unset($data['id']);
		
		//权限管理:修改需管理员权限
		if($id) $this->checkAdmin(true);
		else $this->checkAdmin();

		//修改文章
		//$data['ar_text'] = str_replace(' style="line-height:1.5;"','',$data['ar_text']);
		$data['ar_title'] = htmlspecialchars($data['ar_title']);
		$data['ar_tags'] = str_replace('，',',',$data['ar_tags']);

		$ArticleModel = new ArticleModel();
		if($id) $ArticleModel->update($data, array('id'=>$id));
		else{
			$data['ar_time']=time();
			
			//上班时间进行时间处理
			/*$week=date('N');$hour=date('G');
			if($week<6 && ($hour>8 && $hour<18))
			{
				$data['ar_time']=time()+3600*8;
			}*/
			
			$data['ar_yd'] = date('Y-m',$data['ar_time']);
			$id = $ArticleModel->insert($data);
		}
//echo '<pre>';print_r($data);echo '<pre>';exit;	
		//取出文章中的资源ID
		//$rs=preg_match_all('/<a.*\/download\/(.*?)\.html.*<\/a>/i', $data['ar_text'], $source);
        $rs=preg_match_all('/<a[^>]*\/download\/([\d]*?)\.html[^>)]*>[^>]*a>/i', $data['ar_text'], $source);

		if($rs)
		{
			$keys=array_values($source[1]);
			$this->changeSource($id, array_unique($keys));
		}
	
		//清除推荐文章缓存
		if($data['ar_tui']) $this->KeCache->remove('tuiArticel');
		RedirectHelp::alertGo(($sid?'修改成功':'新增成功'),$this->makeUrl('page/index'));

	}
	
	//文章中的图片上传
	public function actionUpload()
	{
		
		$this->checkAdmin();

		$save_path = $this->uploadPath.'pageimg/';
		$save_url=$this->baseUrl.'uploads/pageimg/';
		header('Content-type: text/html; charset=UTF-8');
		
		//定义允许上传的文件扩展名
		$ext_arr = array(
			'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
			'flash' => array('swf', 'flv'),
			'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
			'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
		);
		//最大文件大小
		$max_size = 1000000;

		//PHP上传失败
		if (!empty($_FILES['imgFile']['error']))
		{
			switch($_FILES['imgFile']['error'])
			{
				case '1':$error = '超过php.ini允许的大小。';break;
				case '2':$error = '超过表单允许的大小。';break;
				case '3':$error = '图片只有部分被上传。';break;
				case '4':$error = '请选择图片。';break;
				case '6':$error = '找不到临时目录。';break;
				case '7':$error = '写文件到硬盘出错。';break;
				case '8':$error = 'File upload stopped by extension。';break;
				case '999':
				default:$error = '未知错误。';
			}
			exit(json_encode(array('error' => 1, 'message' => $error)));
		}

		//有上传文件时
		if (empty($_FILES) === false)
		{
			$file_name = $_FILES['imgFile']['name'];
			$tmp_name = $_FILES['imgFile']['tmp_name'];
			$file_size = $_FILES['imgFile']['size'];

			if (!$file_name) exit(json_encode(array('error' => 1,'message' => "请选择文件。")));
			if (@is_dir($save_path) === false) exit(json_encode(array('error' => 1,'message' => "上传目录不存在。")));
			if (@is_writable($save_path) === false) exit(json_encode(array('error' => 1,'message' => "上传目录没有写权限。")));
			if (@is_uploaded_file($tmp_name) === false) exit(json_encode(array('error' => 1,'message' => "上传失败。")));
			if ($file_size > $max_size) exit(json_encode(array('error' => 1,'message' => "上传文件大小超过限制。")));
			$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
			if (empty($ext_arr[$dir_name])) exit(json_encode(array('error' => 1,'message' => "目录名不正确。")));

			//获得文件扩展名
			$temp_arr = explode(".", $file_name);
			$file_ext = array_pop($temp_arr);
			$file_ext = trim($file_ext);
			$file_ext = strtolower($file_ext);
			//检查扩展名
			if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
				$message="上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。";
				exit(json_encode(array('error' => 1,'message' => $message)));
			}

			//新文件名
			$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
			//移动文件
			$file_path = $save_path . $new_file_name;
			if (move_uploaded_file($tmp_name, $file_path) === false) {
				exit(json_encode(array('error' => 1,'message' => "上传文件失败。")));
			}
			@chmod($file_path, 0777);
			$file_url = $save_url . $new_file_name;
			exit(json_encode(array('error' => 0, 'url' => 'http://www.04007.cn'.$file_url)));
			
		}
		
	}
	
	
	
		
}