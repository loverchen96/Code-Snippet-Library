<?php
	//这个版本注册代码来自之前选课助手注册部分 增加了邮箱验证码和密码自动生成的设计 增加了部分安全性和用户操作的复杂度
	public function regist(){
		//无论是登录还是注册代码 第一步总是免不了对用户是否已经登录进行判断的
		if($this->check_login()){
			$this->show('<h1>您已登录！</h1>');
			$this->redirect('Index/home');
		}
		
		if(IS_POST){//接收用户注册数据
			$email=I('email');
			$xuehao=I('xuehao');
			$nickname=I('nickname');
			//若有验证码需要在此处提前对用户输入的验证码进行正确性判断
			if($email && $xuehao && $nickname){
				$user=M('user');//实例化数据库
				$user_state=$user->where("nickname='{$nickname}'")->find();
				if(!$user_state){
					$email_state=$user->where("email='{$email}'")->find();
					if(!$email_state){
						$xuehao_state=$user->where("xuehao='{$xuehao}'")->find();//前面一段代码分别是对用户注册的‘信息’、‘昵称’、‘邮箱’、‘学号是否正确或者被使用进行验证’
						if(!$xuehao_state){//全部验证通过后就能运行用户进行注册了
							
							//自动生成密码！~ 6位数字 很简单 后期需要强制改密码~~~
							$password=$this->get_password(6);
							$data['nickname']=$nickname;
							$data['password']=$password;
							$data['xuehao']=$xuehao;
							$data['email']=$email;
							$data['registe_time']=date('Y-m-d H:i:s');
							$result=$user->add($data);//注册信息保存到数据库
							
							//邮件发送代码
							$content=
							"Hello!~【".$nickname."】同学~
							欢迎你注册***！
							您的登录密码是：".$password."
							登录后请尽快修改您的登录密码，以免密码泄露~
							点击下面的链接登录：http://***/Home/Index/login
							Enjoy your DAY!~ ";
							
							//更新版 快速 邮件发送代码
							Vendor('Anda.Send_mail');
							send_mail_quick($email,'****|登录密码邮件',$content);
							//如果邮件发送成功的话
							if($result!=false){
								$this->show('注册成功！！~请到邮箱查看密码。');
								$this->redirect('Index/index');
							}else{
								$this->error('邮件发送失败，请重试~');
							}
						} else $this->error('学号已被注册~~');
					} else $this->error('邮箱已被使用~~');
				} else $this->error('昵称已被使用~~');
			}else $this->error('请输入正确格式的邮箱、学号、昵称、密码！！');
		}
		
		$this->display();
	}
	/**
	**和注册代码搭配使用的邮箱验证码和自动数字密码生成的代码
	**/
	private function get_password($length){
		$chars="0123456789";//此处也可扩展字符串添加大小写字母亦或者符号进去增加验证码或者是密码的复杂度
		$password = '';
		for($i=0;$i<$length;$i++){
			$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
		}

		return $password;
	}
?>