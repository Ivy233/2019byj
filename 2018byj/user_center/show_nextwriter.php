<?php
if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    require_once("../db_mysqli.php");
    $db=new DB();
    
    $assign_now=$db->getRow("select * from assignment_user where userid='".$_POST['userid']."'");
    if(isset($assign_now)){
        $assign_next=$db->getRow("select * from assignment_user where assignmentid='".$assign_now['assignmentid']."'and writeid='".($assign_now['writeid']+1)."'");
        if(isset($assign_next)){
            $next_user=$db->getRow("select * from user where id='".$assign_next['userid']."'");
            $res=array(
                "name"=>$next_user['name'],
                "tel"=>$next_user['tel'],
                "address"=>$next_user['address'],
            );
            echo json_encode($res);
        }
    }
}
?>