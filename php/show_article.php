<?php
require_once("function/db_mysqli.php");
$db=new DB();
$res_articles=array();
if($_POST['type']=="copy"){
    $articles=$db->getAll("select * from copywall_article
        where id<".$_POST['endid']." and assignmentid='".$_POST['assignid']."'
        order by id desc limit ".$_POST['size']);
    foreach($articles as $article){
        $student=$db->getRow("select * from user where id='".$article['userid']."'");
        $pics=$db->getAll("select * from copywall_pic where articleid='".$article['id']."'");
        $res_pics=array();
        foreach($pics as $pic){
            array_push($res_pics,array(
                "picPath"=>$pic['picpath'],
                "articleid"=>$pic['articleid'],
            ));
        }
        array_push($res_articles,array(
            "articleid"=>$article['id'],
            "userid"=>$article['userid'],
            "stuId"=>$student['stuid'],
            "name"=>$student['name'],
            "time"=>$article['time'],
            "content"=>$article['content'],
            "pics"=>$res_pics,
        ));
    }
    echo json_encode($res_articles);
}
else{
    $articles=$db->getAll("select * from ".$_POST['type']."wall_article
            where id<".$_POST['endid']."
            order by at_top asc, id desc limit ".$_POST['size']);
    foreach($articles as $article){
        $student=$db->getRow("select * from user where id='".$article['userid']."'");
        $pics=$db->getAll("select * from ".$_POST['type']."wall_pic where articleid='".$article['id']."'");
        $res_pics=array();
        foreach($pics as $pic){
            array_push($res_pics,array(
                "picPath"=>$pic['picpath'],
                "articleid"=>$pic['articleid'],
            ));
        }
        array_push($res_articles,array(
            "articleid"=>$article['id'],
            "userid"=>$article['userid'],
            "stuId"=>$student['stuid'],
            "name"=>$student['name'],
            "time"=>$article['time'],
            "content"=>$article['content'],
            "pics"=>$res_pics,
        ));
    }
    echo json_encode($res_articles);
}
?>