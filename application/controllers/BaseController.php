<?php

/***********************************
 *Note:		:项目基础控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2016-02
 ***********************************/
 
class BaseController extends KeController
{

	//项目全局公共加载
	public function __init()
    {

		//取平台设置数据,如网站关闭则显示关闭信息
		$this->webset = $this->getWebset();
		if(!$this->webset['web_open'])
		{
			exit($this->webset['web_close_words']);
		}

		#设置网站信息
		$this->web_name=$this->webset['web_name'];
		$this->web_keyword=$this->webset['web_keyword'];
		$this->web_description=$this->webset['web_description'];

		//取类目数据
		$this->categoryArr = $this->getCategory();

		//取得推荐文章
		$this->ArticleTui = $this->getTuiarticle();
		
		//得到月份归档
		$this->monthArr=$this->getMonthfrom();

		//得到最新评论
		$this->commentArr=$this->getComment();
		
		#判断当前搜索引擎名称
		$this->sprider = $this->initSprider();

		//全局设置数据加载
		$this->showArr = $this->loadConfig('showarr');

		//全局菜单加载
		$this->menuArr = $this->loadConfig('menu');

		//全局菜单加载
		$this->commonArr = $this->loadConfig('common');

	}


	//用户唯一标记
	public function initSprider()
	{

		$sprider = WapHelp::checkSprider();

		//非搜索蜘蛛进行唯一性标记
		if($sprider === false)
		{
			if(!isset($this->Cookie->visiter))
			{
				$user='us'.date('YmdHis').'-'.rand(111,999);
				setcookie("visiter", $user, time()+86400*3650, '/'); //, '.04007.cn'
			}else{
				$user = $this->Cookie->visiter;
			}

		}else $user='';
			
		$this->visitor = $user;
		define('UID', $this->visitor);
		$this->url='http://'.$this->webUrl.$this->userUri;
		return $sprider;
	
	}


	//读取平台设置数据
	public function getWebset()
	{

		//取缓存
		$data=$this->KeCache->read('websetCache');
		if($data) return $data;

		//无缓存时读取数据库
		$ConfigModel = new ConfigModel();
		$data = $ConfigModel->selectOne(array('id' => 1));

		//写缓存
		$this->KeCache->write('websetCache', $data);
		return $data;
		
	}

	
	//读取类目数据
	public function getCategory()
	{
		//取缓存
		$data=$this->KeCache->read('categoryCache');
		if($data) return $data;
		
		//无缓存时读取数据库
		$CategoryModel = new CategoryModel();
		$rs=$CategoryModel->select('', 'class_sort asc');
		
		$returnArr=array();
		foreach($rs as $k=>$row){	
			$returnArr[$row['id']]=array('cn'=>$row['class_name'],'cfn'=>$row['class_fname']);
		}

		//写缓存
		$this->KeCache->write('categoryCache', $returnArr);
		return $returnArr;
	
	}

	//得到推荐文章
	public function getTuiarticle()
	{
		
		//取缓存数据
		$returnArr=$this->KeCache->read('tuiArticel');
		if($returnArr) return $returnArr;
		
		//无缓存时读取数据库
		$returnArr=array();
		$ArticleModel = new ArticleModel();
		$rs = $ArticleModel->select(array('ar_tui'=>1), 'id desc', array('id','ar_title'), 20);
		foreach($rs as $k=>$row)
		{
			$returnArr[$row['id']]=$row['ar_title'];
		}
		
		//写缓存
		$this->KeCache->write('tuiArticel', $returnArr, 1440);
		return $returnArr;
		
	}
	
	//得到归档列表
	public function getMonthfrom()
	{

		$ArticleModel = new ArticleModel();
		return $ArticleModel->getMonthfrom();

	}

	//取最新评论缓存
	public function getComment($limit=15)
	{
		
		//取缓存
		$data = $this->KeCache->read('commentCache');
		if($data) return $data;
		
		//无缓存时读取数据库
		$CommentModel = new CommentModel();
		$rs = $CommentModel->select('', 'id desc', '', $limit);
		$returnArr=array();
		foreach($rs as $k=>$row){
			$returnArr[$row['id']]=array('id'=>$row['com_arid'],'text'=>$row['com_text']);
		}

		//写缓存
		$this->KeCache->write('commentCache', $returnArr, 30);
		return $returnArr;
		
	}


	//记录用户浏览记录
	public function recordVisit()
	{

		$saveArr=array(
			'uid'=>$this->visitor,
			'ip'=>$this->clientIp,
			'title'=>str_replace('-'.$this->webset['web_name'],'',$this->web_name),
			'cometime'=>time(),
			'content'=>$this->userAgent,
			'url'=>$this->url,
			'fromurl'=>$this->userReferer
			);


		$this->NormalModel->insertTable('ke_uservisit', $saveArr);

		#记入访问统计
		$tday=date('Y-m-d');
		$sql="INSERT INTO ke_userday(uid,date) VALUES('{$this->visitor}','{$tday}') ON DUPLICATE KEY UPDATE nums=nums+1";
		$affectNum = $this->NormalModel->execute($sql);
		//var_dump($affectNum);exit;
		//if($affectNum==2)
		//{
		//	$num = $this->KE('keMysql')->db_select("SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'ke_userday'")->fetch();
		//	$num=$num['AUTO_INCREMENT']-1;
		//	$this->KE('keMysql')->db_exec("alter table `ke_userday` auto_increment='{$num}';");
		//}
		
		return true;
		
	}
	
	//记录搜索引擎抓取记录
	public function recordEngine(){

		$saveArr=array(
			'sprider'=>$this->sprider,
			'ip'=>$this->clientIp,
			'title'=>str_replace('-'.$this->webset['web_name'],'',$this->web_name),
			'cometime'=>time(),
			'content'=>$this->userAgent,
			'url'=>$this->url,
			'fromurl'=>$this->userReferer
		);
		
		$this->NormalModel->insertTable('ke_enginevisit', $saveArr);

		#记入访问统计
		$tday=date('Y-m-d');
		$sql="INSERT INTO ke_engineday(sprider,date) VALUES('{$this->sprider}','{$tday}') ON DUPLICATE KEY UPDATE nums=nums+1";
		$affectNum = $this->NormalModel->execute($sql);
		
		return true;
		
	}


	//页面加载完毕执行
	public function __afterRequest()
	{

		#记录访问日志
		$this->sprider?$this->recordEngine():$this->recordVisit();
		
	}

}