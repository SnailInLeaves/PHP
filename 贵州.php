<?php
$id = isset($_GET['id'])?$_GET['id']:'gzws';
$n = [
    "gzws" => "ch01",//贵州卫视
    "gzgg" => "ch02",//贵州公共
    "gzwy" => "ch03",//贵州影视
    "gzsh" => "ch04",//贵州生活
    "gzfz" => "ch05",//贵州法制
    "gzkj" => "ch06",//贵州科教
    "gzjj" => "ch09",//贵州经济
    "gzjygw" => "ch10",//贵州家有购物
    "gzyd" => "ch13",//贵州移动
    ];
$m3u8 = json_decode(file_get_contents('https://api.gzstv.com/v1/tv/'.$n[$id].'/?stream_url'))->stream_url;
header('location:'.$m3u8);
//print_r($m3u8);
?>