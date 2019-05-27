<?php
date_default_timezone_set('PRC');
function smkdir($dir)
{
    return is_dir($dir) ||(smkdir(dirname($dir)) && mkdir($dir, 0777));
}
function fileext($filename)
{
    $stemp=strrchr($filename,".");
    return substr($stemp,1);
}
function fileext2($filename){
    $stemp=explode(".",$filename);
    return $stemp[count($temp)-1];
}
function random($length){
    $source="0123456789abcdefghijklmnopqrstuvwxyz";
    $len=strlen($source);
    $res="";
    for($i=0;$i<$length;$i++){
        $n=rand(0,$len-1);
        $res.=substr($source,$n,1);
    }
    return $res;
}
function get_openid($weixin){
    if(!isset($weixin['appid']))$weixin['appid']="wx890f194b0e74ddc0";
    if(!isset($weixin['secret']))$weixin['secret']="d95bb0210b7a2663917592c1b59c15dc";
    if(isset($weixin['appid'])&&isset($weixin['secret'])&&isset($weixin['jscode']))
    {
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$weixin['appid']."&secret=".$weixin['secret']."&js_code=".$weixin['jscode']."&grant_type=authorization_code";
        $array=get_object_vars(json_decode(file_get_contents($url)));
        return $array['openid'];
    }else return -1;
}
?>