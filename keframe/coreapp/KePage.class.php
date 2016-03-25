<?php

/***********************************
 *Note:		:分页文件
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2014-12

  keframe:可以做语言上的矮子，但要争做行动上的巨人。
 ***********************************/
 
final class KePage extends KeBase implements KeKe
{
	
	static $__pageArr;

	private $pagination;
	

    /***********************************
           实例化Page类
     ***********************************/

	public function __construct(&$KE=NULL)
    {

		parent::__construct($KE);

		$this->pagination = new stdClass();

	}


    /***********************************
            传入分页数据
     ***********************************/

    public static function setPageConfig($totalNum, $pageSize, $pageNow, $conditions)
    {
		
		//初始化分页数据

		self::$__pageArr=array(
			'totalNum' => $totalNum,
			'pageSize' => $pageSize,
			'pageNow' => $pageNow,
			'conditions' => $conditions,
		);
    
    }


    /***********************************
            初始化分页
     ***********************************/

	private function init()
	{
	
		$this->pagination->totalAll = self::$__pageArr['totalNum'];
		
		$this->pagination->pageAll = ceil($this->pagination->totalAll/self::$__pageArr['pageSize']);
		
		$this->pagination->pageNow = self::$__pageArr['pageNow'];

		$this->pagination->pageSize = self::$__pageArr['pageSize'];
		
		
	}


    /***********************************
            设置分页参数
     ***********************************/

	public static function setPageParam($pageParam)
	{
		
		self::$__pageParam = $pageParam;

	}
	


	/***********************************
            设置分页参数
     ***********************************/

	private function getParams($params=array())
	{

		//取页面要传递的参数值
		
		$paramsArr=array();
		
		foreach($params as $key)
		{
			
			if(isset($this->Get->$key) && $this->Get->$key) $paramsArr[$key]=$this->Get->$key;

		}

		return $paramsArr;

	}


    /***********************************
            取分页字符串bootStrap
     ***********************************/
	
	public function makeBootpage($showNum=8, $params=array())
	{

		$this->init();

		if($this->pagination->pageAll < 2) return '';
		
		$side = ceil($showNum/2);
		
		$pageParams = $this->getParams($params);

		$pageParams[$this->config->pageParam] = 1;


		//拼接分页字符串
		
		if($this->pagination->pageNow == 1) $pagechar ='<li class="disabled"><a href="#">&laquo;</a></li>'."\r\n";
		
		else $pagechar="<li><a href='".$this->KeUrl->makeUrl('', $pageParams)."'>&laquo;</a></li>\r\n";

		$start = $this->pagination->pageNow - $side;
		
		$end=$this->pagination->pageNow + $side;
		
		if($start<1) $start=1;
		
		if($end > $this->pagination->pageAll) $end = $this->pagination->pageAll;
	
		for($i = $start; $i<=$end; $i++)
		{
		
			$pageParams[$this->config->pageParam] = $i;

			$class = '';

			if($i==$this->pagination->pageNow)
			{
			
				$pagechar.="<li class='disabled active'><a>{$i}</a></li>\r\n";
			
			}else{
			
				$pagechar.="<li><a href='".$this->KeUrl->makeUrl('', $pageParams)."'>{$i}</a></li>\r\n";
			
			}
		
		}
		
		$pageParams[$this->config->pageParam]=$this->pagination->pageAll;
		
		if($this->pagination->pageNow == $this->pagination->pageAll) $pagechar.='<li class="disabled"><a href="#">&raquo;</a></li>'."\r\n";
		
		else $pagechar.="<li><a href='".$this->KeUrl->makeUrl('', $pageParams)."'>&raquo;</a></li>\r\n";
	

		//加上总条数
		
		$pagechar.="<li><a>All(".$this->pagination->totalAll.")</a></li>\r\n";
		
		return $pagechar;
		
	}
	

    /***********************************
            取分页字符串当前模板
     ***********************************/

	public function makeBlogPage($showNum=8, $params=array())
	{		

		$this->init();

		if($this->pagination->pageAll < 2) return '';
		
		$side = ceil($showNum/2);
		
		$pageParams = $this->getParams($params);

		$pageParams[$this->config->pageParam] = 1;

		
		if($this->pagination->pageNow==1) $pagechar='<span class="page-numbers current"><<</span>'."\r\n";
		
		else $pagechar="<a class='page-numbers' href='".$this->KeUrl->makeUrl('', $pageParams)."'><<</a>\r\n";
		
		$start = $this->pagination->pageNow - $side;
		
		$end = $this->pagination->pageNow + $side;
		
		if($start<1) $start=1;
		
		if($end-$start < $showNum) $end = $start+$showNum-1;
		
		if($end>$this->pagination->pageAll) $end=$this->pagination->pageAll;
		
		for($i=$start;$i<=$end;$i++)
		{
		
			if($i==$this->pagination->pageNow){
		
				$pagechar.="<span class='page-numbers current'>{$i}</span>\r\n";
			
			}else{
				
				$pageParams[$this->config->pageParam] = $i;
				
				$pagechar.="<a class='page-numbers' href='".$this->KeUrl->makeUrl('', $pageParams)."'>{$i}</a>\r\n";
				
			}
		
		}
		
		$pageParams[$this->config->pageParam] = $this->pagination->pageAll;
		
		if($this->pagination->pageNow == $this->pagination->pageAll) $pagechar.='<span class="page-numbers current">>></span>'."\r\n";
		
		else $pagechar.="<a class='page-numbers' href='".$this->KeUrl->makeUrl('', $pageParams)."'>>></a>\r\n";
		

		//加上总条数
		
		$pagechar.="<span class='page-numbers'>All(".$this->pagination->totalAll.")</span>\r\n";

		return '<nav class="pagination loop-pagination">'.$pagechar.'</nav>';   
		
	}

	
}