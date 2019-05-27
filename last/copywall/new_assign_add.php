<?php
$i=0;
foreach($_GET as $get){
    $_GET[$i]=json_decode($get,1);
    $i++;
}
if(isset($_GET[0])){
    require_once("../db_mysqli.php");
    $db=new DB();
    $assign=$db->getRow("select * from assignment where id='".$_GET[0]['assignId']."'");

    $flag=0;
    $users=array();
    foreach($_GET as $assignment_user){
        $user=$db->getRow("select * from user where stuid='".$assignment_user['stuId']."'");
        if(isset($user)&&$user['address'])
        {
            array_push($users,$user);
            $tmp1=$db->getRow("select * from queue_f where userid='".$user['id']."'");
            $tmp2=$db->getRow("select * from assignment_user where userid='".$user['id']."'");
            if(isset($tmp1)||isset($tmp2))$flag=1;
        }
        else die("1");
    }

    if($flag==0)
    {
        if(isset($_GET[1])){
            if($assign['is_group']==1&&$assign['nowsize']==0&&$assign['maxsize']>=count($_GET)&&$assign['minsize']<=count($_GET))
            {
                $db->update("assignment",array(
                    "nowsize"=>count($_GET),
                ),"id='".$assign['id']."'");
                $db->insert("assignment_user",array(
                    "assignmentid"=>$_GET[0]['assignId'],
                    "userid"=>$users[0]['id'],
                    "writeid"=>1,
                ));
                for($i=1;$i<count($_GET);$i++){
                    $tmp=$db->getRow("select * from queue_f where userid='".$users[$i]['id']."'");
                    if(count($tmp)!=0)continue;
                    $db->insert("queue_f",array(
                        "assignmentid"=>$_GET[$i]['assignId'],
                        "userid"=>$users[$i]['id'],
                    ));
                    $db->insert("message",array(
                        "type"=>1,
                        "info"=>$assign['bookname'],
                        "userid"=>$users[$i]['id'],
                        "fromid"=>$users[0]['id'],
                        "time"=>time(),
                        "readed"=>0,
                    ));
                }
                echo 0;
            }
            else if($assign['nowsize']!=0||$assign['is_group']!=1)echo 2;
            else if($assign['maxsize']<count($_GET)||$assign['minsize']>count($_GET))echo 3;
            else echo 4;
        }
        else{
            if($assign['maxsize']>$assign['nowsize']&&$assign['is_group']==0){
                $db->insert("assignment_user",array(
                    "assignmentid"=>$_GET[0]['assignId'],
                    "userid"=>$users[0]['id'],
                    "writeid"=>($assign['nowsize']+1),
                ));
                $db->update("assignment",array(
                    "nowsize"=>($assign['nowsize']+1),
                ),"id='".$assign['id']."'");
                echo 0;
            }
            else if($assign['maxsize']==$assign['nowsize'])echo 3;
            else if($assign['is_group']!=0)echo 2;
            else echo 4;
        };
    }
    else echo 5;
    unset($users);
}
?>