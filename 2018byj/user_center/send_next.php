<?php
if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    require_once("../db_mysqli.php");
    $db=new DB();
    $assign_now=$db->getRow("select * from assignment_user where userid='".$_POST['userid']."'");
    $assign=$db->getRow("select * from assignment where id='".$assign_now['assignmentid']."'");
    if($assign['onway']==0&&$assign_now['writeid']==$assign['nowwrite']){
        $db->update("assignment",array(
            "onway"=>1
        ),"id='".$assign_now['assignmentid']."'");

        $assign_next=$db->getRow("select * from assignment_user 
        where assignmentid='".$assign_now['assignmentid']."'
        and writeid='".($assign_now['writeid']+1)."'");
        if(!empty($assign_next)){
            $next_user=$db->getRow("select * from user where id='".$assign_next['userid']."'");
            $db->insert("message",array(
                "type"=>3,
                "info"=>$assign['bookname'],
                "userid"=>$next_user['id'],
                "fromid"=>$_POST['userid'],
                "time"=>time(),
                "readed"=>0,
            ));
            echo $next_user['name'];
        }
        else echo 0;
    }else echo -1;
}
?>