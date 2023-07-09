<?php
$url = isset($_GET['url'])?$_GET['url']:'http://106.59.3.167:55555/udp/239.200.200.178:8884';
$a=explode("/",$url); 
$b=explode('.',$a[2]);
$c=explode(':',$b[3]);
$ips=$b[0].'.'.$b[1];
$port=$c[1];
$public='/'.$a[3].'/';
$back='/'.$a[5];
$s= intval($b[2]);
$e= intval($c[0]);
for ($o=$s;$o<=$e;$o++){
    for ($i=1;$i<255;$i++){
    $ip = 'http://'.$ips.'.'.$o.'.'.$i.':'.$port;
    $d=check_ip($ip);
    if ($d == 200) {
    $ipw=$o.'.'.$i;
    break 2;
        }
        }
    }

$playurl='http://'.$ips.'.'.$ipw.':'.$port.$public.$a[4].$back;
echo $playurl;
header('location:'.$playurl);

function check_ip($ip){
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $ip);
   curl_setopt($ch, CURLOPT_TIMEOUT_MS, 120);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_exec($ch); 
   $curl_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
   curl_close($ch);
   return $curl_code;
}
?> 
