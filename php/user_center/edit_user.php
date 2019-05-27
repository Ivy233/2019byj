<?php
if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    require_once("../function/db_mysqli.php");
    $db=new DB();

    $user=$db->getRow("select * from user where id='".$_POST['userid']."'");
    $db->update("user",array(
        "address"=>$_POST['address'],
        "name"=>$_POST['name'],
        "tel"=>$_POST['tel'],
        "pos_x"=>$_POST['longitude'],
        "pos_y"=>$_POST['latitude'],
    ),"id='".$_POST['userid']."'");
}
?>