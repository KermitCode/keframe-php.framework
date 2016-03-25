<?php

/***********************************
 *Note:		:类目管理控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2015-12
 ***********************************/

class ClassController extends BaseController
{

	//应用全局加载
	public function __init()
	{
		//权限检查
		$this->checkAdmin();

		//基本设置
		$this->setbasicData();

	}

	//类目列表
	public function actionIndex()
	{

		//查看各类文章总数
		$this->classAll = $this->NormalModel->selectTable('ke_class', '','class_sort asc');
		$rs = $this->NormalModel->selectTable('ke_article', '', '', array('ar_cid','count(ar_cid) as cnum'), '', array('groupby'=>'ar_cid'));
		$this->classNum=array();
		foreach($rs as $k=>$row)
		{
			$this->classNum[$row['ar_cid']]=$row['cnum'];	
		}
		
		$this->view();
	
	}
	
	//类目修改新增
	public function actionModify($id = 0)
	{

		$id = intval($id);
		$this->classData = array();
		$id && $this->classData = $this->NormalModel->selectOneTable('ke_class', array('id' => $id));			
		$this->view();
		
	}
	
	//类目修改提交
	public function actionPostclass()
	{
		
		$this->checkAdmin(true);
		
		//参数处理
		$id = intval($this->post('id'));
		$data = (array)$this->Post();
		if(isset($data['id'])) unset($data['id']);
		
		//执行修改、新增  
		if($id) $this->NormalModel->updateTable('ke_class', $data, array('id'=>$id) );
		else $this->NormalModel->insertTable('ke_class', $data);
		
		//清除缓存并跳转
		$this->KeCache->remove('categoryCache');
		RedirectHelp::alertGo($id?'修改成功':'新增成功', $this->makeUrl('class/index'));
	
	}
		
}