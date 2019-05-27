<?php
require_once("db_mysqli.php");
require_once("userModel.php");
require_once("function.php");
$db=new DB();
if(isset($_POST['jscode'])){
	$openid=get_openid($_POST);
	$user=$db->getRow("select * from user where openid='".$openid."'");
	if(!empty($user)&&$openid){
		$db->update("user",array(
			"cnt"=>$user['cnt']+1,
		),"id='".$user['id']."'");
		$messages=$db->getAll("select * from message where userid='".$user['id']."' and readed=0");
		echo json_encode(array(
			"messagecnt"=>count($messages),
			"userid"=>$user['id'],
			"from"=>"weixin",
		));
	}else echo json_encode(array(
		"messagecnt"=>0,
		"userid"=>-1,
	));
}
else if(isset($_POST['stuId'])&&isset($_POST['passWord'])){
	$a=login($_POST['stuId'],$_POST['passWord']);
	if($a['success']!=0){
		$user=$db->getRow("select * from user where stuid='".$_POST['stuId']."'");
		if(!isset($user)){
			$db->insert("user",array(
				"stuid"=>$_POST['stuId'],
				"firstlogin"=>time(),
				"name"=>$a['auth-info']['reader-name'],
				"academy"=>$a['auth-info']['reader-department'],
				"cnt"=>1,
			));
			$userid=$db->getInsertId();
		}
		else 
		{
			$db->update("user",array(
				"cnt"=>$user['cnt']+1,
			),"id='".$user['id']."'");
			$userid=$user['id'];
		}
		$messages=$db->getAll("select * from message where userid='".$userid."' and readed=0");
		echo json_encode(array(
			"messagecnt"=>count($messages),
			"userid"=>$userid,
			"from"=>"pass",
		));
	}
	else echo json_encode(array(
		"messagecnt"=>0,
		"userid"=>-1,
	));
}
?>