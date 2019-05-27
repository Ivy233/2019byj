<?php
$cnt=0;
if($_GET['articleid'])
{
    require_once("function/db_mysqli.php");
    require_once("function/function.php");
    $db=new DB();
    if(isset($_FILES))
    {
        foreach($_FILES as $pic)
        {
            $cnt++;
            if($pic['size']<=20*1024*1024)
            {
                $fileext=strtolower(fileext($pic['name']));
                $name=random(16);
                $dir="pic/".$_GET['type']."/".date("Y/m/");
                smkdir("../".$dir);
                $dir.=$name.".".$fileext;
                if(is_uploaded_file($pic['tmp_name'])){
                    $flag=move_uploaded_file($pic['tmp_name'],"../".$dir);
                    if($flag)
                        $db->insert($_GET['type']."wall_pic",array(
                            "picpath"=>$dir,
                            "articleid"=>$_GET['articleid'],
                        ));
                    else echo $cnt." ";
                }else echo $cnt." ";
            }else
                echo $cnt." ";
        }
    }
    else echo 0;
}
?>