<?php
//你问我答程序设计
	private $admin_id_list=array(//小白们的用户ID列表 下面发送信息将要使用到
		'小白一号',
		'小白二号',
		'小白三号'
	)
	
	private $key=NULL;
	/**
	**主程序代码
	**/
	public function main(){
		$message=I('message');//获取用户发来的消息
		$keyword_list=M('关键词数据库')->select();//获取到全部关键词列表
		$num=count($keyword_list);//关键词计数
		for($i=0;$i<$num;$i++){
			if($keyword_list[$i] in $message){//关键词匹配到
				//组合成所有符合的关键词
				$this->answer_return($keyword_list[$i]);//把答案发送回用户 若有多个匹配结果返回多次答案
			}else{//关键词并没有匹配到 问题保存到待解决的数据库并将解答连接发送到小白中
				$data['user_id']=*;
				$data['time']=*;
				$data['message']=$message;
				$ret=M('代解决问题数据库')->save($data);//保存问题到待解决问题数据库中
				if($ret){
					$problem_id=M('代解决问题数据库')->where('user_id'=$data['user_id'] AND 'time'=$data['time'] AND 'message'=$data['message'])->getFiled('id');
					$url="http://www.ahu114.me/********?id=".$problem_id;//获取问题id并生成直接回答该问题的URL
					//将该问题内容发送给小白们的微信 让小白们点击链接直接回答问题
					$this->admin_message_send($message,$url);
					//返回要用户等待的信息。
					$content="你问的问题已经发送给小白们，小白看到后将为你解答，详情在解答后将自动反馈给你，请等待哦~"
					$this->message_send($content);//发送等待信息给用户
				}else{//数据库保存失败 可能由于服务器压力问题或者是其他未知情况 这时进行错误信息的发送
					$content="Sorry，你的问题小白暂时回答不了，由于某些错误的发生小白也无法及时获取到你的问题。请你重新发送提问或者等候稍后后台小白的解答。";
					$this->message_send($content);//发送错误信息给用户
				}
			}
		}
	}
	/**
	**返回成功匹配问题的答案
	**/
	public function answer_return($keyword]){
		$answer_list=M('问题数据库')->where('keyword="{$keyword}"')->select();
		$num=count($answer_list);
		//组织返回消息格式
		//将答案发送给用户
		$url="http://www.ahu114.me/********?key=".$keyword;
		//仅提供前八条回答。若有多的让用户点击消息URL查看
		$content->send();
	}
	/**
	**将问题内容及问题解答的URL发送给小白们 注意此处不对身份进行验证 
	**为了方便小白们自己回答问题，也就是说，此处URL一旦被泄露，那么该待解答数据库将被泄露
	**/
	public function admin_message_send($content,$url){
		//通过客服接口将消息依次发送给小白们
		$num=count($admin_id_list);
		for($i=0;$i<$num;$i++){
			//发送信息代码
			$content->send();
		}
	}
	/**
	**错误反馈给用户
	**/
	public function message_send($content){
		//发送错误信息给用户
		$content->send();
	}
	/**
	**小白问题回答
	**/
	public function solve(){
		$problem_id=I('id');
		$problen_content=M('待解决问题数据库')->where('id'=$problem_id)->find();
		if($problen_content['answer']){
			$this->assign($problen_content);//如果该问题已经回答则把该问题的问题和解答详情显示出来
		}else{//如果该问题没有被回答则
			$answer=I('answer');
			$user_id=I('user_id');
			$data=**;
			if($answer && $user_id){
				$ret=**;//保存数据库操作
			}else{
				$this->error("请在微信中打开链接或请提交合法信息。");
			}
		}
	}
	/**
	**更多问题答案的显示
	**/
	public function answer_show(){
		$problem_id=I('keyword');
		$answer_list=M('问题数据库')->where('keyword'=$keyword)->select();
		if($answer_list){
			$this->assign($answer_list);
		}else{
			$this->error("请不要对该链接进行测试。");
		}
	}
?>