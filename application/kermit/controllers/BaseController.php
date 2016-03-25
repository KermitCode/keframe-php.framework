<?php

/***********************************
 *Note:		:后台应用基础控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2015-12
 ***********************************/
 
class BaseController extends KeController
{

	public $categoryArr, $tuiArticel, $monthArr, $basicData;

	public $type='';
	
	//检查管理员权限
	public function checkAdmin($super=false)
	{
		
		//必须是管理员身份
		if(!$this->session('adminer'))
		{	
			$this->redirect('login/index');
		}
		
		//需要以超级管理身份操作
		if($super && $this->session('adminer')!='kermit')
		{
			RedirectHelp::alertGo('您不是超级管理员，不能进行此操作!');
		}
		
	}
	
	//设置网站基本数据
	public function setbasicData()
	{
		
		$this->basicData=array('web_name'=>'04007管理后台',);
		
		//菜单数据
		$menu = $this->loadConfig('menu');
		$nowUrl = $this->controller.'/'.$this->action;
		$this->pageName = $this->basicData['web_name'];
		foreach($menu as $k=>$row)
		{
			foreach($row as $sk=>$srow)
			{
				$menu[$k][$sk]['c']=($nowUrl==$srow['u'])?' class="active"':'';
				if($nowUrl==$srow['u']) $this->pageName=$sk;
			}
		}
		$this->menuData=$menu;
		$menu = NULL;

	}
	
	//取类目数据
	public function getCategory()
	{
		
		//取缓存
		$data=$this->KeCache->read('categoryCache');
		if($data) return $data;
		
		//无缓存时读取数据库
		$rs = $this->NormalModel->selectTable('ke_class', '', 'class_sort asc');
		$returnArr=array();		
		foreach($rs as $k=>$row)
		{	
			$returnArr[$row['id']]=array('cn'=>$row['class_name'],'cfn'=>$row['class_fname']);
		}

		//写缓存
		$this->KeCache->write('categoryCache', $returnArr);
		return $returnArr;
		
	}
		
}