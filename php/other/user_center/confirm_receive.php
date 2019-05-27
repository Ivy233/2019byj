<?php
if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    require_once("../function/db_mysqli.php");
    $db=new DB();
    $assign_user=$db->getRow("select * from assignment_user where userid='".$_POST['userid']."'");
    $assign=$db->getRow("select * from assignment where id='".$assign_user['assignmentid']."'");
    if($assign['onway']==1&&$assign['nowwrite']+1==$assign_user['writeid'])
    {
        $assign_prev=$db->getRow("select * from assignment_user where assignmentid='".$assign_user['assignmentid']."' and writeid='".($assign_user['writeid']-1)."'");
        $db->update("assignment",array(
            "nowwrite"=>$assign_user['writeid'],
            "onway"=>0,
        ),"id='".$assign_user['assignmentid']."'");
        if(count($assign_prev))
            $db->insert("message",array(
                "type"=>0,
                "info"=>$assign['bookname'],
                "userid"=>$assign_user['userid'],
                "fromid"=>$assign_prev['userid'],
                "time"=>time(),
                "readed"=>0,
            ));
        echo 0;
    }
    else echo 1;
}
?>