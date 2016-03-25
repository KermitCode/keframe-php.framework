<?php

/***********************************
 *Note:		:每日统计控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2015-12
 ***********************************/

class DayController extends BaseController
{

	//应用全局加载
	public function __init()
	{
		//权限检查
		$this->checkAdmin();

		//基本设置
		$this->setbasicData();

	}

	//用户按日访问记录
	public function actionUser()
	{

		$this->checkAdmin(true);
		$UserdayModel = new UserdayModel();
		$this->pageData = $UserdayModel->page($this->page, 12, 'id desc');
		$this->view();
	
	}
	
	//蜘蛛按日访问记录
	public function actionEngine()
	{
		
		$this->checkAdmin(true);
		$this->pageData = $this->NormalModel->pageTable('ke_engineday', $this->page, 12, 'id desc');
		$this->view();
		
	}
		
}