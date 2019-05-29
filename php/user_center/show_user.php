<?php
function object_to_array($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource')
            return;
        if (gettype($v) == 'object' || gettype($v) == 'array')
            $obj[$k] = (array)object_to_array($v);
    }
    return $obj;
}
if(isset($_POST['userid'])&&intval($_POST['userid']))
{
    require_once("../function/db_mysqli.php");
    require_once("../function/function_whulib.php");
    $db=new DB();

    $user=$db->getRow("select * from user where id='".$_POST['userid']."'");
    $loan_history=object_to_array(get_all_loan_history($user['stuid']));
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
    array_push($loan_history, array(
        "booktitle"=>"小布情书",
        "author"=>"武汉大学图书馆",
        "callno"=>"none",
        "bookisbn"=>"none",
        "loandate"=>"20190603"
    ));
    usort($loan_history, function($a, $b) {
        $al = intval($a['loandate']);
        $bl = intval($b['loandate']);
        if ($al == $bl)
            return 0;
        return ($al > $bl) ? -1 : 1;
    });
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