<?php
if(isset($_POST['jscode'])&&isset($_POST['userid'])){
    require_once("function/function.php");
    require_once("function/db_mysqli.php");
    $openid=get_openid($_POST);
    $db=new DB();
    $user=$db->getRow("select * from user where id='".$_POST['userid']."'");
    if(!empty($user)){
        $db->update("user",array(
            "openid"=>$openid,
        ),"id='".$_POST['userid']."'");
        echo $user['stuid'];
    }else echo -1;
}
?>