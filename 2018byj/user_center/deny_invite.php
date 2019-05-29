<?php
if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    require_once("../db_mysqli.php");
    $db=new DB();
    $assign_user=$db->getRow("select * from queue_f where userid='".$_POST['userid']."'");
    if(empty($assign_user))die("1");
    $assign=$db->getRow("select * from assignment where id='".$assign_user['assignmentid']."'");
    if($assign['nowsize']==$assign['maxsize'])
    {
        $db->deleteAll("queue_f",array(
            "assignmentid"=>$assign['id'],
        ));
        $db->deleteAll("assignment_user",array(
            "assignmentid"=>$assign['id'],
        ));
	$db->update("assignment",array(
	    "nowsize"=>0,
	    "onway"=>1,
	    "is_group"=>0,
	    "nowwrite"=>0,
	),"id='".$assign['id']."'");
	echo $assign['nowsize'];
    }else{
        $db->update("assignment",array(
            "nowsize"=>$assign['nowsize']-1,
        ),"id='".$assign['id']."'");
        $db->deleteOne("queue_f",array(
            "assignmentid"=>$assign['id'],
            "userid"=>$_POST['userid'],
        ));
	echo $assign['nowsize'];
    }
}
?>