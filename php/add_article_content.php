<?php
if(isset($_POST['userid'])&&intval($_POST['userid'])&&isset($_POST['type']))
{
    require_once("function/db_mysqli.php");
    $db=new DB();
    if($_POST['content'])
    {
        $tmp=array(
            "content"=>$_POST['content'],
            "time"=>time(),
            "userid"=>$_POST['userid'],
        );
        if($_POST['type']=='copy')$tmp['assignmentid']=$_POST['assignid'];
        else $tmp['at_top']=0;
        $db->insert($_POST['type']."wall_article",$tmp);
        echo $articleid=$db->getInsertId();
    }else echo 0;
}
?>