<?php
	$dir=dirname(__FILE__);
	require $dir."/db.php";
	$db=new db($web);
	$data=$db->getData('cet_info');
	var_dump($data);
?>