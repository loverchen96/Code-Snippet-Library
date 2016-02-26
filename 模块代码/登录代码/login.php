<?php
	//代码重要的是思想而不是语法
	//此代码是基于thinkPHP开发 使用时请注意环境 BY 夜雨、loverchen96
	public function login(){
		//检查是否已经登录、
		if($this->check_login()){
			$this->show('<h1>您已登录！</h1>');
			$this->redirect('Index/home');
		}
		
		if(IS_POST){
			//接收前端提交的数据‘name’、‘password’

			$nickname=I('name');
			$password=I('password');
			//登录判断的一系列过程
			//若有验证码需在此处之前进行验证码正确性判断
			if( $nickname && $password ){//非空判断、前端代码部分也要进行判断，一起配合更加稳妥
				$user_info=M('user')->where("nickname='{$nickname}'")->find();//数据库获取用户密码信息
				if($user_info){//获取到了用户信息
					if($user_info['password']==$password){//密码正确性判断
						if($user_info['state']){
							session('user_info',$nickname);//登录后保存登录状态到session中
							$data['last_login_time']=date('Y-m-d H:i:s');
							$result=M('user')->where("nickname='{$nickname}'")->save($data);//将用户登录行为保存到数据库中
							if($result!=false){//下面是各种登录失败的指向结果和原因
								$this->redirect('Index/home');
							}elseif($result==false){
								$this->error('登录失败，请重试~');
							}
						}else{
							$this->error('Sorry,用户已被禁用！！！');
						}
					}else{
						$this->error('请输入正确的密码哦~');
					}
				}else{
					$this->error('用户名错误，请重试！');
				}
			}else{
				$this->error('请输入正确格式的用户名、密码！！');
			}
		}
		
		$this->display();//thinkPHP渲染界面的过程
?>