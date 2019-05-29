<?php
if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    require_once("../db_mysqli.php");
    $db=new DB();

    $user=$db->getRow("select * from user where id='".$_POST['userid']."'");

    $f=$db->getRow("select * from assignment_user where userid='".$_POST['userid']."'");
    $len=strlen($user['stuid']);
    $stunum="";
    for($i=0;$i<$len;$i++){
        if($i<5||$i==$len-1)$stunum.=$user['stuid'][$i];
        else $stunum.="*";
    }
    if(isset($f)){
        $assign=$db->getRow("select * from assignment where id='".$f['assignmentid']."'");
        $tmp=$db->getAll("select id from assignment_user where assignmentid='".$assign['id']."'");
        $res_user=array(
            "name"=>$user['name'],
            "stuId"=>$user['stuid'],
            "show_stunum"=>$stunum,
            "myIndex"=>$f['writeid'],
            "assignid"=>$assign['id'],
            "book"=>$assign['bookname'],
            "nowWrite"=>(count($tmp)==$assign['nowsize']?$assign['nowwrite']:-1),
            "address"=>$user['address'],
            "tel"=>$user['tel'],
            "longitude"=>$user['pos_x'],
            "latitude"=>$user['pos_y'],
            "onway"=>$assign['onway'],
        );
    }
    else{
        $res_user=array(
            "name"=>$user['name'],
            "stuId"=>$user['stuid'],
            "show_stunum"=>$stunum,
            "address"=>$user['address'],
            "tel"=>$user['tel'],
        );
    }
    echo json_encode($res_user);    
}
?>