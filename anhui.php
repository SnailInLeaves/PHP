<?php
//https://tvzb-hw.ahtv.cn/application/tvradio/h5/detail.html?type=tv
$id = isset($_GET['id'])?$_GET['id']:'ahws';
$n = [
'ahws' => 11,
'ahjjsh' => 12,
'ahys' => 13,
'ahnykj' => 14,
'ahgg' => 16,
'ahzyty' => 17,
'ahgj' => 18,
];
$url = 'https://tvzb-hw.ahtv.cn/tvradio/Tvfront/getTvInfo?loop=1&tv_id='.$n[$id];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
$res = curl_exec($ch);
curl_close($ch);
$m3u8 = str_replace('https://hls','http://hdl',json_decode($res)->data->m3u8);
header('location:'.$m3u8);
//echo $m3u8;
?>