<?php
if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    require_once("../db_mysqli.php");
    $db=new DB();
    
    $user=$db->getRow("select * from user where id='".$_POST['userid']."'");
    $assign_now=$db->getRow("select * from assignment_user where userid='".$user['id']."'");
    if(isset($assign_now)&&$_POST['address']!=$user['address']){
        $assign_prev=$db->getRow("select * from assignment_user where 
        assignmentid='".$assign_now['assignmentid']."' and 
        writeid='".($assign_now['writeid']-1)."'");
        if(isset($assign_prev)){
            $assign=$db->getRow("select * from assignment where id='".$assign_now['assignmentid']."'");
            $user_prev=$db->getRow("select * from user where id='".$assign_prev['userid']."'");
            $db->insert("message",array(
                "type"=>2,
                "info"=>$assign['bookname'],
                "userid"=>$assign_prev['userid'],
                "fromid"=>$_POST['userid'],
                "time"=>time(),
                "readed"=>0,
            ));
        }
    }
    $db->update("user",array(
        "address"=>$_POST['address'],
        "name"=>$_POST['name'],
        "tel"=>$_POST['tel'],
        "pos_x"=>$_POST['longitude'],
        "pos_y"=>$_POST['latitude'],
    ),"id='".$_POST['userid']."'");
}
?>