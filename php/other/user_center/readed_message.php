<?php
print_r($_POST);
if($_POST['userid']&&isset($_POST['messageid']))
{
    require_once("../function/db_mysqli.php");
    $db=new DB();
    $db->update("message",array(
        "readed"=>1,
    ),"id='".$_POST['messageid']."'");
    echo $_POST['messageid'];
}
?>