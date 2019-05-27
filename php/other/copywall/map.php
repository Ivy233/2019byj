<?php
if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    require_once("../function/db_mysqli.php");
    $db=new DB();
    $assigns=$db->getAll("select * from assignment");
    $res_map=array();
    foreach($assigns as $assign){
        if($assign['nowsize'])
        {
            $assign_users=$db->getAll("select * from assignment_user where assignmentid='".$assign['id']."'");
            $res_pos=array();
            foreach($assign_users as $assign_user)
            {
                $user=$db->getRow("select * from user where id='".$assign_user['userid']."'");
                array_push($res_pos,array(
                    "longitude"=>$user['pos_x'],
                    "latitude"=>$user['pos_y'],
                ));
            }
            array_push($res_map,array(
                "name"=>$assign['bookname'],
                "location"=>$res_pos,
            ));
        }
    }
    echo json_encode($res_map);
}
?>