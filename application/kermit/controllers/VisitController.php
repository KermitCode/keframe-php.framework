<?php

/***********************************
 *Note:		:访问记录控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2015-12
 ***********************************/

class VisitController extends BaseController
{
	
	//应用全局加载
	public function __init()
	{
		//权限检查
		$this->checkAdmin();

		//基本设置
		$this->setbasicData();

	}

	//用户访问记录
	public function actionUser()
	{
		
		$this->checkAdmin(true);
		
		//取用户UID
		$conditions = array();
		if($uid = $this->get('uid'))
		{
			$conditions['uid'] = $uid;
		}

		$this->visitData = $this->NormalModel->pageTable('ke_uservisit', $this->page, 12, 'id desc', $conditions);
		$this->view();
		
	}
	
	//搜索引擎记录控制器
	public function actionEngine()
	{
		
		$this->checkAdmin(true);
		
		//取用户查询的搜索引擎
		$conditions = array();
		if($sprider = $this->get('sprider'))
		{
			$conditions['sprider'] = $sprider;
		}

		$this->visitData = $this->NormalModel->pageTable('ke_enginevisit', $this->page, 12, 'id desc', $conditions);
		$this->view();

	}
		
}