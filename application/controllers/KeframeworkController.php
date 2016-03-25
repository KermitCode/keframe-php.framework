<?php

/***********************************
 *Note:		:框架页面
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2016-02
 ***********************************/
 
class KeframeworkController extends BaseController
{
	
	
	//文章列表页面
	public function actionIndex()
	{
		$this->layout = false;
		$this->view();
	
	}
	


	
		
}