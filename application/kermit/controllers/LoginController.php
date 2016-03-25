<?php

/***********************************
 *Note:		:登录退出控制器
 *Author	:Kermit
 *QQ		:956952515
 *note		:中国.山东.青岛
 *date		:2015-12
 ***********************************/

class LoginController extends BaseController
{

	//登录界面
	public function actionIndex()
	{

		$this->layout=false;
		$this->view();
	
	}
	
	//登录处理页
	public function actionLogin()
	{
		
		//用户已登录状态
		if($this->session('adminer'))
		{
			$this->redirect('home/index');
		}

		//判断验证码是否正确
		if( strtolower($this->post('code')) != strtolower($this->session('code')) )
		{
			RedirectHelp::alertGo('验证码不正确');
		}
		
		//账号密码
		$adminArr = array(
			'admin'  => 'e10adc3949ba59abbe56e057f20f883e'
		);
		$username = $this->post('username');
		$password = md5($this->post('password'));

		//验证
		if(isset($adminArr[$username]) && $adminArr[$username] == $password)
		{
			$this->session('adminer', $username);
			$this->redirect('home/index');		
		}else{
			RedirectHelp::alertGo('用户名或密码不正确');
		}
		
	}
	
	//获取验证码图片
	public function actionCode()
	{
		
		$this->layout=false;
		$this->KeCode->doimg();
		$this->session('code', $this->KeCode->getCode());
			
	}
	
	//退出登录
	public function actionQuit()
	{
		
		$this->checkAdmin();
		$this->session('adminer', '');
		$this->redirect('login/index');
		
	}

}