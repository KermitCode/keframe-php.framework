<?php

/***********************************
 *Note:		:工具控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2016-07
 ***********************************/

class ToolsController extends BaseController
{
	
	//俄罗斯证to英语工具
	public function actionRussiantoenglish()
	{
        $this->web_name='俄罗斯语转换成英语的工具-'.$this->webset['web_name'];
		$this->web_keyword='俄罗斯语,转换,英语,工具';
		$this->web_description=$this->web_name;
		$this->view();
	}

    //俄罗斯证to英语工具
	public function actionBaidugooglejingweidu()
	{
        $this->web_name='谷歌与百度的经纬度坐标转换-'.$this->webset['web_name'];
		$this->web_keyword='谷歌,百度,坐标转换';
		$this->web_description=$this->web_name;
		$this->view();
	}

}