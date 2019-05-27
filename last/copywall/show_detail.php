<?php
if($_POST['ismine']=="false")$_POST['ismine']=0;
else if($_POST['ismine']=="true")$_POST['ismine']=1;
if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    if(!isset($_POST['endid']))$_POST['endid']=0x3f3f3f3f;
    if(!isset($_POST['size']))$_POST['size']=128;
    require_once("../db_mysqli.php");
    $db=new DB();
    $fs=$db->getAll("select * from assignment_user where assignmentid=".$_POST['assignid']);
    $res_users=array();
    foreach($fs as $f){
        $user=$db->getRow("select * from user where id='".$f['userid']."'");
        array_push($res_users,array(
            "name"=>$user['name'],
            "headerPath"=>$user['userpic_path'],
        ));
    }
    echo json_encode($res_users);
}
?>