<?php

/***********************************
 *Note:		:文章详情控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2016-02
 ***********************************/
 
class ArticleController extends BaseController
{
	
	//文章详情页
	public function actionView($id=0)
	{
        $id = intval($id);

		//取数据
		$ArticleModel = new ArticleModel();
		$this->pageData = $ArticleModel->selectOne(array('id'=>$id));

		if(!$this->pageData)
		{
			RedirectHelp::toUrl($this->makeUrl('home/index'));
		}

		//数据展现处理
		$this->pageData['ar_title']=stripslashes($this->pageData['ar_title']);
		$this->pageData['ar_text']=stripslashes($this->pageData['ar_text']);
		
		//当前页面参数
		$this->web_name=$this->pageData['ar_title'].'-'.$this->web_name;
		$this->web_keyword=$this->pageData['ar_tags'].'-'.$this->web_keyword;
		$this->web_description=trim(StrHelp::substr_zh(StrHelp::DeleteHtml(strip_tags($this->pageData['ar_text'])),200));
		
		//页面代码展现：
		$this->pageData['ar_text']=$this->phpDo($this->pageData['ar_text']);
		
		//浏览次数增
		$ArticleModel->increment(array('ar_view'=>rand(1,3), 'ar_views'=>1));

		//取出相关文章、本栏目最新文章
		$this->pageData['related']=$this->getRelated($this->pageData['ar_tags'], $id);
		$this->pageData['newclass']=$this->getNewclass($this->pageData['ar_cid'], $id);

		#进入详情页标记
		$_SESSION['irt_yes_'.$id]=1;

		#类目ID
		$this->type=$this->categoryArr[$this->pageData['ar_cid']]['cn'];

		$this->view();
	
	}
	
	
	//PHP代码处理
	private function phpDo($text)
	{
		
		$rs=preg_match_all('/<p>\s*phpcode-\s*<\/p>(.*?)<p>\s*-phpcode\s*<\/p>/is',$text,$match);
		if(!$rs) return $text;
		list($withphp,$nophp)=$match;
		
		foreach($nophp as $k=>$string)
		{
			$char=highlight_string(trim(html_entity_decode(strip_tags($string))),true);
			$text=preg_replace("/<p>\s*phpcode-\s*<\/p>(.*?)<p>\s*-phpcode\s*<\/p>(\s*)/is",'<pre><code class="php5">'.$char.'</code></pre>',$text,1);
		}
		
		return $text;
		
	}

	//文章归档
	public function actionMonth()
	{

		//取年月参数并初始化
		$yd = $this->Get->yd;
		if(!$yd)
		{
			$yd=date('Y-m');
		}

		//日期验证
		if(strpos($yd, '-') !== false){
			list($year,$month) = explode('-',$yd);
			if(!checkdate ($month , 1 , $year)) $yd=date('Y-m');
		}else{
			$yd=date('Y-m');
		}

		//取当前页文章
		$this->web_name=$yd.'月PHP技术文章-PHP框架技术文章-列表-'.$this->web_name;
		$ArticleModel = new ArticleModel();
		$this->pageData = $ArticleModel->page($this->page, 10, 'id desc', array('ar_yd'=>$yd),array('id','ar_time','ar_title'));
		$this->view();
	
	}

	//文章评论加载
	public function actionLoadcom($id)
	{

		$id=intval($id);
		if(!$id) exit();
		$this->layout = false;
		
		$CommentModel = new CommentModel;
		$this->comment = $CommentModel->page($this->page, 12, 'id asc', array('com_arid'=>$id));
	
		$commentChar='';
		if($this->comment)
		{
			$i=1;
			foreach($this->comment as $k=>$row)
			{
				$commentChar.='<div class="pcomment"><div class="entry-meta">';
				$commentChar.="\r\nLevel : {$i}.&nbsp;&nbsp;&nbsp;&nbsp;".date('Y-m-d H:i:s',$row['com_time'])."\r\n";
				$commentChar.='</div><div class="entry-content">';
				$commentChar.=stripcslashes($row['com_text']);
				$commentChar.='</div></div>';
				$i++;
			}
			$pageChar = $this->kePage->makeBlogPage(8, array('id'));
			if($pageChar)$commentChar.="<div class='pagination'><ul>{$pageChar}</ul></div>";
		}

		exit($commentChar);
		
	}


	//文章评论处理
	public function actionComment()
	{
		$this->layout = false;
		$result=array('rs'=>0,'message'=>'');
		$mess=htmlspecialchars(trim($this->Post->mess));
		$arid = intval($this->Post->id);
		
		if(!$mess){$result['message']='评论不能为空!';exit(json_encode($result));}
		if(!$arid){$result['message']='非法操作!';exit(json_encode($result));}

        #评论过滤-是否有效
        if(!FilterHelp::isValidData($mess))
        {
            $result['message']='评论失败-无效评论!';
			exit(json_encode($result));
        }
        
        #评论过滤-敏感词检查
        /*if(FilterHelp::filterSensitiveString($mess))
        {
            $result['message']='评论失败-评论中有敏感字符!';
			exit(json_encode($result));
        }*/
		
		$insert_arr=array(
			'com_uid'=>$this->visitor,
			'com_arid'=>$arid,
			'com_text'=>$mess,
			'com_time'=>time(),
			'com_ip'=>$this->clientIp
		);

		#查询用户是否评论过快
		$stime=time() - 60;
		$CommentModel = new CommentModel;
		$count = $CommentModel->count(array('com_uid'=>$this->visitor, 'com_time>'=> $stime));
		if($count >= 2)
		{
			$result['message']='请不要评论过快!';
			exit(json_encode($result));
		}

		#插入评论及记录评论数量
		$saveRs = $CommentModel->insert($insert_arr);
		if($saveRs)
		{
			$ArticleModel = new ArticleModel();
			$ArticleModel->increment(array('ar_comments'=>1), array("id"=>$arid));
		}
		
		#返回JS结果
		$result['rs']=1;
		$result['message']='<div class="pcomment"><div class="entry-meta">'."\r\n".date('Y-m-d H:i:s',$insert_arr['com_time'])."\r\n"
            .'</div><div class="entry-content">'.stripcslashes($mess).'</div></div>';
		$this->KeCache->remove('commentCache');
		exit(json_encode($result));
		
	}

	//提取弹幕数据
	public function actionBarrager($id = 0)
	{
		$id=intval($id);
		$this->layout = false;
		$CommentModel = new CommentModel;

		
		$conditions = array();
		if($id)
		{
			$conditions = array('com_arid'=>$id);
		}
		$this->comment = $CommentModel->select($conditions, 'id desc','', 30);
		
		$barrages= array();
		$imgArr = array('cute.png', 'haha.gif', 'heisenberg.png', 'mj.gif', 'yaseng.png');
		if($this->comment)
		{
			foreach($this->comment as $k=>$row)
			{
				$random_keys = array_rand($imgArr, 1);
				$barrages[] = array(
							'info'   => StrHelp::substr_zh(stripcslashes($row['com_text']), 60),
							'img'    => $this->imagesUrl.'frontdir/barrager/img/'.$imgArr[$random_keys],
							'href'   => $this->makeUrl('article/view', array('id' =>$row['com_arid'])),
							);
			}
		}
		//$this->debug($barrages);exit;
		exit(json_encode($barrages));
	}

	//给每个关键词添加KEY
	public static function addkey($n)
	{
		return("ar_title like '%".$n."%'");
	}

	//取出相关文章
	public function getRelated($tags, $id)
	{
		if(!$tags)
		{
			return array();
		}

		$Related=$this->KeCache->read('relate/RelatedCache_'.$id);
		if($Related) return $Related;
	
		//拼接SQL语句
		$tags = explode(',', $tags);
		$tags = array_map("ArticleController::addkey", $tags);
		$tag_sql = implode(' or ', $tags);

		//执行查询
		$ArticleModel = new ArticleModel();
		$temp = $ArticleModel->select($tag_sql, 'id desc', 'id,ar_title', 10);
		$Related = array();

		foreach($temp as $row)
		{
			$Related[$row['id']] = $row['ar_title'];
		}

		$this->KeCache->write('relate/RelatedCache_'.$id, $Related, 86400*5);
		return $Related;

	}

	//取出本栏目最新文章
	public function getNewclass($classid, $id)
	{
		if(!$classid)
		{
			return array();
		}
	
		$Newclass=$this->KeCache->read('newclass/NewclassCache_'.$id);
		if($Newclass) return $Newclass;

		//拼接SQL语句
		$tag_sql = " ar_cid = {$classid} and id != {$id} ";

		//执行查询
		$ArticleModel = new ArticleModel();
		$temp = $ArticleModel->select($tag_sql, 'id desc', 'id,ar_title', 10);
		$Newclass = array();

		foreach($temp as $row)
		{
			$Newclass[$row['id']] = $row['ar_title'];
		}

		$this->KeCache->write('newclass/NewclassCache_'.$id, $Newclass, 86400*5);
		return $Newclass;

	}


}