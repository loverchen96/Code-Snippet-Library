<?php
	require dirname(__file__)."/dbconfig.php";//引入配置文件
	
	class db{
		public $conn=null;
		
		public function __construct($config){//构造方法，实例化类时自动调用
			$this->conn=mysql_connect($config['host'],$config['username'],$config['password']) or die(mysql_error());//连接数据库
			mysql_select_db($config['database'],$this->conn) or die(mysql_error());//选择数据库
			mysql_query("set names ".$config['charset']) or die(mysql_error());//设置mysql编码
		}
		/**
		**根据传入sql语句 查询mysql结果集
		**/
		public function getResult($sql){
			$resource=mysql_query($sql,$this->conn) or die(mysql_error());//查询sql语句
			$res=array();
			while(($row=mysql_fetch_assoc($resource))!=false){
				$res[]=$row;
			}
			return $res;
		}
		/**
		**根据传入数据库名称获取全部数据内容
		**/
		public function getData($database){
			$sql="SELECT * FROM ".$database;
			$res=self::getResult($sql);
			return $res;
		}
	}
?>