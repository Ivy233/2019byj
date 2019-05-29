<?php
if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    require_once("../function/db_mysqli.php");
    require_once("../function/function_whulib.php");
    $db=new DB();

    $user=$db->getRow("select * from user where id='".$_POST['userid']."'");
    $loan_history=get_all_loan_history($user['stuid']);
    $visit_detail=visit_detail($user['stuid']);
    $len=strlen($user['stuid']);
    $stunum="";
    for($i=0;$i<$len;$i++){
        if($i<5||$i==$len-1)$stunum.=$user['stuid'][$i];
        else $stunum.="*";
    }
    $res_visit_detail=[
        "first_visit_time"=>$visit_detail['fist-visit-time'],
        "most_branch_count"=>$visit_detail['most-branch-count'],
        "most_branch_name"=>$visit_detail['most-branch-name'],
        "visit_count"=>$visit_detail['visit-count']
    ];
    $res_user=array(
        "name"=>$user['name'],
        "stuId"=>$user['stuid'],
        "longitude"=>$user['pos_x'],
        "latitude"=>$user['pos_y'],
        "show_stunum"=>$stunum,
        "address"=>$user['address'],
        "tel"=>$user['tel'],
        "loan_history"=>$loan_history,
        "visit_detail"=>$res_visit_detail
    );
    echo json_encode($res_user);
}
?>