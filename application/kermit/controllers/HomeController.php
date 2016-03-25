<?php

/***********************************
 *Note:		:管理后台首页控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2015-12
 ***********************************/

class HomeController extends BaseController
{
	
	//应用全局加载
	public function __init()
	{
		//权限检查
		$this->checkAdmin();

		//基本设置
		$this->setbasicData();

	}

	//后台首页
	public function actionIndex()
	{

		//统计数据
		$this->pagenum = $this->NormalModel->countTable('ke_article');		//计算文章总数
		$this->commentnum = $this->NormalModel->countTable('ke_comment');	//计算评论总数

		//文章总浏览数
		$this->viewnum = $this->NormalModel->sumTable('ke_article', 'ar_views');

		//今日数据
		$d=date('Y-m-d');
		$t=strtotime($d);
		$this->webviewnum = $this->NormalModel->sumTable('ke_userday', 'nums', array('date' => $d));	//今日网站浏览量
		$this->commentday = $this->NormalModel->countTable('ke_comment', array('com_time>'=> $t));		//今日评论数
		$this->usersday = $this->NormalModel->countTable('ke_userday', array('date' => $d));			//今日来访用户数
		$this->spriderday = $this->NormalModel->sumTable('ke_engineday', 'nums', array('date' => $d));	//今日蛛蛛抓取数

		//计算几天未写文章
		$ArticleModel = new ArticleModel();
		$page = $ArticleModel->selectOne('', 'id desc', array('ar_time'));
		$lastday=date('Y-m-d', $page['ar_time']);
		$this->daynum = round((strtotime($d)-strtotime($lastday))/86400);
		
		//近一个月网站浏览量
		$sdate=date("Y-m-d",strtotime('-30day'));
		$rs = $this->NormalModel->selectTable('ke_userday', array('date>='=>$sdate), '', array('date','sum(nums) as daynum'), '', array('groupby' => 'date'));
		$daySata=array();
		foreach($rs as $k=>$row){$daySata[$row['date']]=$row['daynum'];}
		
		//近一个月访问人次
		$rs = $this->NormalModel->selectTable('ke_userday', array('date>='=>$sdate), '', array('date','count(uid) as daynum'), '', array('groupby' => 'date'));
		$dayUser=array();
		foreach($rs as $k=>$row){$dayUser[$row['date']]=$row['daynum'];}

		//近一个月百度抓取数
		$rs = $this->NormalModel->selectTable('ke_engineday', array('sprider'=>'Baidu', 'date>='=>$sdate));
		$dayEngine=array();
		foreach($rs as $k=>$row){$dayEngine[$row['date']]=$row['nums'];}
		
		//近一个月日期列表
		$days=$ym=array();
		for($i=0;$i<=30;$i++)
		{
			$ym[]=date("n.j",strtotime('-'.$i.'day'));
			$days[]=date("Y-m-d",strtotime('-'.$i.'day'));
		}
		$days=array_reverse($days);$ym=array_reverse($ym);
		$this->dayChar="'".implode("','",$ym)."'";

		//近一个月数据
		$this->dayStat=$this->userStat=$this->EngineStat=array();
		foreach($days as $date)
		{
			//网站总访问数
			if(!isset($daySata[$date]))$this->dayStat[]=0;
			else $this->dayStat[]=$daySata[$date];

			//访问人次统计
			if(!isset($dayUser[$date]))$this->userStat[]=0;
			else $this->userStat[]=$dayUser[$date];
			
			//百度抓取数
			if(!isset($dayEngine[$date]))$this->EngineStat[]=0;
			else $this->EngineStat[]=$dayEngine[$date];
		
		}
		
		$this->view();
	
	}
		
}