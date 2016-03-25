<?php

/***********************************
 *Note:		:评论管理控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2015-12
 ***********************************/

class CommentController extends BaseController
{

	//应用全局加载
	public function __init()
	{
		//权限检查
		$this->checkAdmin();

		//基本设置
		$this->setbasicData();

	}

	//评论列表
	public function actionIndex()
	{
		
		//取出评论列表内容
		$CommentModel = new CommentModel();
		$this->comData = $CommentModel->page($this->page, 8, "id desc");
		
		//IN查询文章标题
		$pageids=array();
		foreach($this->comData as $row) $pageids[]=$row['com_arid'];
		$pageids=array_unique($pageids);
		$titles = array();
		
		//取出文章标题
		$ArticleModel = new ArticleModel();
		if($pageids) $titles = $ArticleModel->select(array('id in'=>$pageids), '', array('id','ar_title') );
		$titleArr=array();
		foreach($titles as $k=>$row)
		{
			$titleArr[$row['id']]=$row['ar_title'];
		}
		$this->titleArr=$titleArr;
		$this->view();
	
	}
	
	//删除评论
	public function actionDelete($id)
	{
		//参数处理及权限判断
		$id = intval($id);
		if(!$id) $this->redirect('home/index');
		$this->checkAdmin(true);
		
		//数据操作
		$CommentModel = new CommentModel();
		$CommentModel->delete(array('id' => $id));	
		RedirectHelp::alertGo('删除成功');

	}
	
}