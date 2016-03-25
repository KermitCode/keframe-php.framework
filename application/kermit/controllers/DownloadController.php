<?php

/***********************************
 *Note:		:下载资源控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2015-12
 ***********************************/

class DownloadController extends BaseController
{

	//应用全局加载
	public function __init()
	{
		//权限检查
		$this->checkAdmin();

		//基本设置
		$this->setbasicData();

	}

	//下载资源列表
	public function actionIndex()
	{
		
		$DownloadModel = new DownloadModel();
		$this->downData = $DownloadModel->page($this->page, 12, 'id desc');
		$this->view();
		
	}
	
	//添加资源
	public function actionAdd()
	{
		
		$this->checkAdmin(true);
		$id=intval($this->get('id'));

		$DownloadModel = new DownloadModel();
		if($id) $this->downData = $DownloadModel->selectOne(array('id'=>$id));
		if(!$this->downData){
			$this->downData = $DownloadModel->showFields(true);
			$id=0;
		}
		
		//取出文章标题
		$this->titleArr=array();
		if($this->downData['relatepage'])
		{
			
			$pages=explode(',',$this->downData['relatepage']);
			foreach($pages as $k=>$v){if(!$v) unset($pages[$k]);}
			
			//查询标题
			$ArticleModel = new ArticleModel();
			$titles = $ArticleModel->select(array('id in'=>$pages));
			foreach($titles as $k=>$row)
			{
				$this->titleArr[$row['id']]=$row['ar_title'];
			}

		}
		
		$this->view();

	}
	

	//删除资源
	public function actionDelete()
	{
		
		$this->checkAdmin(true);
		$id = $this->get('id');
		if(!$id) $this->redirect('home/index');

		//取得资源路径并删除资源
		$DownloadModel = new DownloadModel();
		$source = $DownloadModel->selectOne(array('id'=>$id));
		$file=$this->uploadPath.$source['filepath'];
		if(file_exists($file)) unlink($file);
		$DownloadModel->delete();
		
		RedirectHelp::alertGo('删除成功');

	}


	//文件上传接口程序
	public function actionUpfile()
	{
		
		$this->checkAdmin(true);
	
		//定义上传文件路径
		$targetFolder = 'source';
		$tempFile = $_FILES['Filedata']['tmp_name'];
		$targetPath = $this->uploadPath. $targetFolder;
		$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
		if(move_uploaded_file($tempFile,$targetFile)){
			echo $targetFolder.'/'.$_FILES['Filedata']['name'];
		}else{
			echo '0';
		}
		exit;
	}
	
	//修改数据记录
	public function actionFileadd()
	{
		
		$this->checkAdmin(true);
		
		$id=$this->post('id');
		$data = $this->post();
		unset($data['id']);

		//修改资源
		$DownloadModel = new DownloadModel();
		if($id) $DownloadModel->update($data, array('id'=>$id));
		else{
			$data['addtime']=time();
			$DownloadModel->insert($data);
		}
		
		//清除推荐文章缓存
		RedirectHelp::alertGo($id?'修改成功':'新增成功',$this->makeUrl('download/index'));

	}
			
}