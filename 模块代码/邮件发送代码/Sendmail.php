<?php
//�����ʼ�
	Vendor('Anda.Send_mail');//Send_mail.php����thinkPHP Library�е�vendor�ļ����� ͨ���˴������ø��ļ�
	$content="Hello~".$nickname."!
	������ʹ�� *** ������֤�빦�ܡ�������֤���ǣ�
	��".$checkcode."��
	���ڵ������뵽��Ҫ������֤�Ľ��棡ʹ�ú�����ʧЧ��";
	$ret=send_mail_quick($user_info['email'],'ѡ������.WEB��|��֤���ʼ�',$content);//����Send_mail.php�е�send_mail_quick()�����������ʼ�
	if($ret==""){//�ʼ�������������ж�
		$this->show("�ʼ����ͳɹ����뵽�����ѯ�ʼ�����������ҳ����д��֤�롣");
		$this->redirect('Index/index');
	}else {
		$data['state']=2;
		$data['extra']="���ʼ�����ʧ�ܣ���".$ret;
		$user_verify->where("user_id='{$user_info['id']}' AND checkcode='{$checkcode}' AND up_time='{$time}'")->save($data);
		$this->error('�ʼ�����ʧ�ܡ�');
	}
?>