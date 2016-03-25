<?php

/***********************************
 *Note:		:文章模型
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2016-02
 ***********************************/
 
class ArticleModel extends KeModel
{
	
	protected $table = 'ke_article';
	

	public function getMonthfrom()
	{

		//取出所有文件的归档数据
		$rs=$this->query("select FROM_UNIXTIME(ar_time,'%Y-%m') as atime,count(*) as anum  from ke_article group by atime");
		
		//数据初始化
		$start = date("2015-03");
		$end=date('Y-m');
		$monthArr=array();
		while ($start <= $end)
		{
			$monthArr[$start] =0 ;
			$start = date("Y-m",strtotime("$start +1month"));
		}
		
		#将统计数据归入
		foreach($rs as $row)
		{
			 $monthArr[$row['atime']]=$row['anum'];
		}

		return $monthArr;
	
	}


}