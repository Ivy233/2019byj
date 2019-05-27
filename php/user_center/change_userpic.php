<?php
print_r($_FILES);
if($_GET['userid'])
{
    require_once("../function/db_mysqli.php");
    require_once("../function/function.php");
    $db=new DB();
    $user=$db->getRow("select * from user where id='".$_GET['userid']."'");
    if(isset($_FILES)&&(($user['userpic_path']&&unlink("../../".$user['userpic_path']))||empty($user['userpic_path'])))
    {
        foreach($_FILES as $pic)
        {
            $fileext=strtolower(fileext($pic['name']));
            $name=random(16);
            $dir="pic/user/".$_GET['userid']."/";
            smkdir("../../".$dir);
            $dir.=$name.".".$fileext;
            if(is_uploaded_file($pic['tmp_name'])){
                $flag=move_uploaded_file($pic['tmp_name'],"../../".$dir);
                if($flag)
                {
                    $db->update("user",array(
                        "userpic_path"=>$dir,
                    ));
                }
            }
        }
        echo 1;
    }
    else echo 0;
}
?>