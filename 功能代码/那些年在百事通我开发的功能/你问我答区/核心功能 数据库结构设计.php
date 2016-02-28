那些和你问我答功能相关的数据库结构设计

DATABASE 1 =》 回答者的数据库 
* 数据库命名：wenda_user
* 数据库结构
	** user_id	
	** answer_times	
	** answer_lasttime	
	** state
* 数据库说明
	** 用于保存所有可以回答用户提出问题的小白列表

DATABASE 2 =》 问题核心数据库
*数据库命名：wenda_problem
*数据库结构
	** id
	** post_id
	** post_time
	** problem
	** answer
	** keyword
	** answer_id
	** answer_time
	** state
* 数据库说明
	** 保存问题和答案的核心数据库 放在里面的问题都有关键字且确保正确

DATABASE 3 =》待解决问题数据库
*数据库命名：wenda_tobesolved
*数据库结构
	** id
	** post_id
	** post_time
	** problem
	** answer
	** answer_id
	** answer_time
	** state
* 数据库说明
	** 保存那些提出的问题不在数据库的问题 
	**放在里面的问题待解决
	**以及state为未归类的待分类保存到和谐数据库中