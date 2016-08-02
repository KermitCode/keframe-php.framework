<?php

/***********************************
 *Note:		:文章搜索控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2016-02
 ***********************************/
 
class SearchController extends BaseController
{
	
	public function actionIndex()
	{
		
		//取搜索参数
		$this->query = isset($this->Get->q)?$this->Get->q:'';
		if(!$this->query) RedirectHelp::toUrl($this->makeUrl('home/index'));
		
		//页面标题
		$this->web_name='搜索:'.$this->query.'-'.$this->web_name;
			
		//取搜索数据
		$ArticleModel = new ArticleModel();
		$this->pageData = $ArticleModel->page($this->page, 18, 'id desc', array('ar_title like'=>$this->query), array('id','ar_time','ar_title'));

        //展示的时候去掉返斜线
        $this->query = stripcslashes($this->query);
		$this->view();
	
	}
	
}