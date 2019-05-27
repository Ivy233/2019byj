<?php
if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    $const_type=array(
        3=>"发送书籍提醒",
        2=>"地址修改提醒",
        1=>"抄书邀请",
        0=>"收到书籍提醒",
    );
    require_once("../db_mysqli.php");
    $db=new DB();
    $messages=$db->getAll("select * from message where userid='".$_POST['userid']."' order by id desc");
    $res_messages=array();
    foreach($messages as $message)
    {
        $from_user=$db->getRow("select * from user where id='".$message['fromid']."'");
        $this_user=$db->getRow("select * from user where id='".$_POST['userid']."'");
        if($message['type']==3)
        {
            array_push($res_messages,array(
                "messageid"=>$message['id'],
                "type"=>$message['type'],
                "bookname"=>$message['info'],
                "from_tel"=>$from_user['tel'],
                "from_name"=>$from_user['name'],
                "time"=>$message['time'],
                "readed"=>$message['readed'],
            ));
        }
        if($message['type']==2)
        {
            array_push($res_messages,array(
                "messageid"=>$message['id'],
                "type"=>$message['type'],
                "bookname"=>$message['info'],
                "new_address"=>$from_user['address'],
                "from_tel"=>$from_user['tel'],
                "from_name"=>$from_user['name'],
                "time"=>$message['time'],
                "readed"=>$message['readed'],
            ));
        }
        else if($message['type']==1)
        {
            array_push($res_messages,array(
                "messageid"=>$message['id'],
                "type"=>$message['type'],
                "bookname"=>$message['info'],
                "from_name"=>$from_user['name'],
                "my_address"=>$this_user['address'],
                "myname"=>$this_user['name'],
                "mytel"=>$this_user['tel'],
                "time"=>$message['time'],
                "readed"=>$message['readed'],
            ));
        }
        else if($message['type']==0)
        {
            array_push($res_messages,array(
                "messageid"=>$message['id'],
                "type"=>$message['type'],
                "bookname"=>$message['info'],
                "time"=>$message['time'],
                "readed"=>$message['readed'],
            ));
        }
    }
    echo json_encode($res_messages);
}
?>