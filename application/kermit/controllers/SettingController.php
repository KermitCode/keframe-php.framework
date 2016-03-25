<?php

/***********************************
 *Note:		:平台设置控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2015-12
 ***********************************/
 
class SettingController extends BaseController
{

	//应用全局加载
	public function __init()
	{
		//权限检查
		$this->checkAdmin();

		//基本设置
		$this->setbasicData();

	}
	
	//设置显示界面
	public function actionIndex()
	{
		
		//取出设置数据
		$this->setting = $this->NormalModel->selectOneTable('ke_config', array('id'=>1));
		$this->view();
	
	}
	
	//保存平台设置
	public function actionSave()
	{
		
		//执行数据保存
		$this->checkAdmin(true);
		$data=$this->post();
		$this->NormalModel->updateTable('ke_config', $data, array('id'=>1));

		//删除缓存
		$this->KeCache->remove('websetCache');
		RedirectHelp::alertGo('保存成功');

	}
	
	//友情链接
	public function actionFriend()
	{

		//修改链接时的处理
		if($link = $this->post('link'))
		{
			$save['data'] = $link;	
			$this->NormalModel->updateTable('ke_data', $save, array('id'=>1));
            $this->KeCache->remove('linkCache');
			RedirectHelp::alertGo('修改成功');
		}
		
		//取出设置数据
		$this->link = $this->NormalModel->selectOneTable('ke_data', array('id'=>'1'));
		$this->link = $this->link['data'];
		
		//加载视图
		$this->view();
	}
	
		
}