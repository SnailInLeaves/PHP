<?php
$id = $_GET['id']??'sxws';
$n = [
   "sxws" => 'q8RVWgs',//山西卫视
   "sxjj" => '4j01KWX',//山西经济
   "sxys" => 'Md571Kv',//山西影视
   "sxshfz" => 'p4y5do9',//山西社会与法治
   "sxwtsh" => 'Y00Xezi',//山西文体生活
   "sxhh" => 'ce1mC4',//山西黄河
   ];
$url = "http://dyhhplus.sxrtv.com/apiv3.8/m3u8_notoken.php?channelid=".$n[$id];
$m3u8 = json_decode(file_get_contents($url),1)['address'];
header('Location:'.$m3u8);
?>