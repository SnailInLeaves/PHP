<?php
$id=$_GET[id];
$ids = array(
"hnws"=>"145",//��������
"dspd"=>"141",//����Ƶ��
"mspd"=>"146",//����Ƶ��
"fzpd"=>"147",//����Ƶ��
"dsjpd"=>"148",//���Ӿ�Ƶ��
"xwpd"=>"149",//����Ƶ��
"htgw"=>"150",//���ڹ���
"ggpd"=>"151",//����Ƶ��
"hnxc"=>"152",//�������Ƶ��
"hngj"=>"153",//���Ϲ���
"lypd"=>"154",//��԰Ƶ��
"wwbk"=>"155",//���ﱦ��
"wspd"=>"156",//����Ƶ��
"qczy"=>"157",//������ԭ
"ydxj"=>"163",//�ƶ�Ϸ��Ƶ��
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