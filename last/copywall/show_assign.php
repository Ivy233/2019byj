<?php
$_POST=array(
    "endid"=>$_POST['endid']?$_POST['endid']:0x3f3f3f3f,
    "size"=>$_POST['size']?$_POST['size']:128,
    "userid"=>$_POST['userid'],
);
//if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    require_once("../db_mysqli.php");
    $db=new DB();
    $books=$db->getAll("select * from assignment where id<".$_POST['endid']." order by id desc limit ".$_POST['size']);
    $res=array();
    $tmp=$db->getRow("select * from assignment_user 
    where userid='".$_POST['userid']."'");
    $flag=isset($tmp);
    foreach($books as $book){
        array_push($res,array(
            "assignId"=>$book['id'],
            "bookName"=>$book['bookname'],
            "maxNumber"=>$book['maxsize'],
            "nowNumber"=>$book['nowsize'],
            "minNumber"=>$book['minsize'],
            "writer"=>$book['writer'],
            "introduce"=>$book['introduce'],
            "demand"=>$book['demand'],
            "show"=>true,
            "picPath"=>$book['picpath'],
            "is_group"=>$book['is_group'],
            "ismine"=>($flag!=0&&($book['id']==$tmp['assignmentid'])),
        ));
    }
    echo json_encode($res);
}
?>