<?php

/***********************************
 *Note:		:项目基础控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2016-02
 ***********************************/
 
class HomeController extends BaseController
{
	
	//网站首页
	public function actionIndex()
	{

		$this->type='homeindex';
		$this->web_name = $this->web_name.'___一名PHP猿的个人php技术博客';

		//取得主体文章内容
		$ArticleModel = new ArticleModel();

		$this->pageData = $ArticleModel->page($this->page, 10, 'id desc');

		//取得友情链接数据
		$this->getLink();
		$this->view();
	
	}
	
	
	//取出友情链接
	public function getLink()
	{

		//取缓存
		$data = $this->KeCache->read('linkCache');
		if($data)
		{
			$this->link=$data;
			return;
		}

		#取出友链数据
		$OthersModel = new OthersModel();
		$link = $OthersModel->selectOne(array('id'=>1));
		$link = $link['data'];
		$link = explode("\n",$link);
		
		$this->link=array();
		if($link)
		{
			foreach($link as $value)
			{
				if(!$value) continue;
				list($name,$url)=explode('<=>',$value);
				$this->link[$name]=$url;
			}
		}
		$link= null;

		//写缓存
		$this->KeCache->write('linkCache', $this->link);
		return;
	}

}