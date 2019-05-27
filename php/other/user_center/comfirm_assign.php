<?php
if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    require_once("../function/db_mysqli.php");
    $db=new DB();
    $assign_user=$db->getRow("select * from queue_f where userid='".$_POST['userid']."'");
    $assign=$db->getRow("select * from assignment where id='".$assign_user['assignmentid']."'");
    $assign_users=$db->getAll("select * from assignment_user where assignmentid='".$assign_user['assignmentid']."' order by writeid desc");
    if(!empty($assign_user)){
        $db->insert("assignment_user",array(
            "assignmentid"=>$assign['id'],
            "userid"=>$_POST['userid'],
            "writeid"=>$assign_users[0]['writeid']+1,
        ));
        $db->update("assignment",array(
            "is_group"=>1,
        ),"id='".$assign['id']."'");
        $db->deleteOne("queue_f",array(
            "assignmentid"=>$assign['id'],
            "userid"=>$_POST['userid'],
        ));
        echo $assign['bookname'];
    }
}
?>