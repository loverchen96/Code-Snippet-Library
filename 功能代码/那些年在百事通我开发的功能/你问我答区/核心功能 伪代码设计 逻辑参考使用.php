<?php
//你问我答程序设计
	private $admin_id_list=array(//小白们的用户ID列表 下面发送信息将要使用到
		'小白一号',
		'小白二号',
		'小白三号'
	)
	/**
	**主程序代码
	**/
	public function main(){
		$message=I('message');//获取用户发来的消息
		$keyword_list=M('关键词数据库')->select();//获取到全部关键词列表
		$num=count($keyword_list);//关键词计数
		for($i=0;$i<$num;$i++){
			if($keyword_list[$i] in $message){//关键词匹配到 生成返回答案列表
			//组合成所有符合的关键词
				$this->answer_return($keyword_list[$i])
			}else{//关键词并没有匹配到 问题保存到待解决的数据库并将解答连接发送到小白中
				$data['user_id']=*;
				$data['time']=*;
				$data['message']=$message;
				$ret=M('代解决问题数据库')->save($data);//保存问题到待解决问题数据库中
				if($ret){
					$problem_id=M('代解决问题数据库')->where('user_id'=$data['user_id'] AND 'time'=$data['time'] AND 'message'=$data['message'])->getFiled('id');
					$url="http://www.ahu114.me/********?id=".$problem_id;//获取问题id并生成直接回答该问题的URL
					//将该问题内容发送给小白们的微信 让小白们点击链接直接回答问题
				}else{//数据库保存失败 可能由于服务器压力问题或者是其他未知情况 这时进行错误信息的发送
					$content="Sorry，你的问题小白暂时回答不了，由于某些错误的发生小白也无法及时获取到你的问题。请你重新发送提问或者等候稍后后台小白的解答。";
					$this->error_message_send($content);//发送错误信息给用户
				}
				$this->admin_message_send();
			}
		}
	}
	
	/**
	**成功匹配的结果返回
	**/
	public function answer_return($keyword]){
		
	}
	/**
	**将问题内容及问题解答的URL发送给小白们 注意此处不对身份进行验证 
	**为了方便小白们自己回答问题，也就是说，此处URL一旦被泄露，那么该待解答数据库将被泄露
	**/
	public function admin_message_send(){
		
	}
	/**
	**错误反馈给用户
	**/
	public function error_message_send($content){
		//发送错误信息给用户
		$content->send();
	}
	/**
	**小白问题回答
	**/
	public function solve(){
		$problem_id=I('id');
		$problen_content=M('待解决问题数据库')->where('id'=$problem_id);
		if($problen_content['answer']){
			$this->assign($problen_content);//如果该问题已经回答则把该问题的问题和解答详情显示出来
		}else{//如果该问题没有被回答则
			
		}
	}
?>