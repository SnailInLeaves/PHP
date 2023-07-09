<?php
$id=$_GET[id];
$ids = array(
"hnws"=>"145",//河南卫视
"dspd"=>"141",//都市频道
"mspd"=>"146",//民生频道
"fzpd"=>"147",//法治频道
"dsjpd"=>"148",//电视剧频道
"xwpd"=>"149",//新闻频道
"htgw"=>"150",//欢腾购物
"ggpd"=>"151",//公共频道
"hnxc"=>"152",//河南乡村频道
"hngj"=>"153",//河南国际
"lypd"=>"154",//梨园频道
"wwbk"=>"155",//文物宝库
"wspd"=>"156",//武术频道
"qczy"=>"157",//睛彩中原
"ydxj"=>"163",//移动戏曲频道
);
$time = time();
$sign = hash('sha256','6ca114a836ac7d73'.$time,'');
$header = array(
"timestamp: $time",
"sign: $sign",
"Connection: Keep-Alive",
"User-Agent: okhttp/3.12.0",
);
$url = "https://prog.dianzhenkeji.com/program/getAuth/live/class/program/11";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$result = curl_exec($ch);
curl_close($ch);
$data = json_decode($result);
for($i=0;$i<100;$i++){
   if($data[$i]->cid==$ids[$id]){
       $playurl=$data[$i]->video_streams;
       $playurl=$playurl[0];
       header('Location:'.$playurl);
    }
}
?>