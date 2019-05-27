<?php
if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    require_once("../db_mysqli.php");
    $db=new DB();
    $this_assign_user=$db->getRow("select * from assignment_user where userid='".$_POST['userid']."'");
    if(empty($this_assign_user)){
        $this_assign_user=$db->getRow("select * from queue_f where userid='".$_POST['userid']."'");
        if(empty($this_assign_user))die("1");
        else die("0");
    }
    $assign=$db->getRow("select * from assignment where id='".$this_assign_user['assignmentid']."'");
    $assign_users=$db->getAll("select * from assignment_user where assignmentid='".$this_assign_user['assignmentid']."'");
    $res=array();
    foreach($assign_users as $assign_user){
        $user=$db->getRow("select * from user where id='".$assign_user['userid']."'");
        $tmp=array(
            "name"=>$user['name'],
            "stuid"=>$user['stuid'],
            "color"=>($assign_user['writeid']==$assign['nowwrite'])?"green":"black",
        );
        if($this_assign_user['writeid']+1==$assign_user['writeid'])
        {
            $tmp['address']=$user['address'];
            $tmp['tel']=$user['tel'];
        }
        array_push($res,$tmp);
        unset($tmp);
    }
    echo json_encode($res);
}
?>