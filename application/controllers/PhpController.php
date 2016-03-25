<?php

/***********************************
 *Note:		:文章详情控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2016-02
 ***********************************/
 
class PhpController extends BaseController
{
	
	//文章列表页面
	public function actionList($type)
	{

		//取当前文章类别ID
		$cid = $this->getTypeid($type);
		$arr = $this->categoryArr;
		if(!$cid) $cid = key($arr);
		$this->type=$this->categoryArr[$cid]['cn'];
		$this->web_name=$this->categoryArr[$cid]['cfn'].'-'.$this->web_name;
		
		#取当前页文章
		$ArticleModel = new ArticleModel();
		$this->pageData = $ArticleModel->page($this->page, 10, 'id desc', array('ar_cid'=>$cid));
		$this->view('home/index');
	
	}
	
	//得到文章所属类别
	public function getTypeid($type)
	{
	
		foreach($this->categoryArr as $cid=>$crow)
		{
			if(strtolower($crow['cn']) == strtolower($type)) return $cid;	
		}
		
		return false;
			
	}

	
		
}