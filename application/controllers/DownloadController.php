<?php

/***********************************
 *Note:		:文章详情控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2016-02
 ***********************************/
 
class DownloadController extends BaseController
{
	
	//下载文件列表
	public function actionIndex()
	{
		
		$this->web_name='04007资源下载-'.$this->web_name;
		$DownloadModel = new DownloadModel();
		$this->pageData = $DownloadModel->page($this->page, 30, 'sortchar desc');
		$this->view();
	
	}

	//文件下载链接
	public function actionDown($id)
	{
        $id = intval($id);

		//判断资源是否存在
        $DownloadModel = new DownloadModel();
		$this->downData = $DownloadModel->selectOne(array("id"=>$id));
		if(!$this->downData)
		{
			RedirectHelp::toUrl($this->makeUrl('home/index'));
		}
		
		//判断是否从详情页进入
        $relateID = current(explode(',',$this->downData['relatepage']));
		if(!isset($_SESSION['irt_yes_'.$relateID]) || $_SESSION['irt_yes_'.$relateID] !=1 ){
			RedirectHelp::toUrl($this->makeUrl('article/view',array('id'=>$relateID)));
            exit;
		}
		
		//下载资源
		if(!file_exists($fpath = $this->uploadPath.$this->downData['filepath']))
        {
			RedirectHelp::toUrl($this->makeUrl('home/index'));
		}
			
		$file_size = filesize($fpath);
		$url=$this->uploadUrl.$this->downData['filepath'];
		
		#下载次数加1
		$Download->increment(array('downloads'=>1));
		FileHelp::outputFile($file_size, $url);
		
	}
	
	
	
		
}