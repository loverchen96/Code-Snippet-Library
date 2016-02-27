<?php
//发送邮件
	Vendor('Anda.Send_mail');//Send_mail.php放在thinkPHP Library中的vendor文件夹中 通过此代码引用该文件
	$content="Hello~".$nickname."!
	您正在使用 *** 邮箱验证码功能。您的验证码是：
	【".$checkcode."】
	请在当天输入到需要邮箱验证的界面！使用后或过期失效。";
	$ret=send_mail_quick($user_info['email'],'选课助手.WEB版|验证码邮件',$content);//调用Send_mail.php中的send_mail_quick()函数来发送邮件
	if($ret==""){//邮件发送情况反馈判断
		$this->show("邮件发送成功，请到邮箱查询邮件，并到所需页面填写验证码。");
		$this->redirect('Index/index');
	}else {
		$data['state']=2;
		$data['extra']="【邮件发送失败：】".$ret;
		$user_verify->where("user_id='{$user_info['id']}' AND checkcode='{$checkcode}' AND up_time='{$time}'")->save($data);
		$this->error('邮件发送失败。');
	}
?>