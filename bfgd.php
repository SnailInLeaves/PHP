<?php
$head_httplive = 'http://httplive.slave.bfgd.com.cn:14311';
$head_httpstream = 'http://httpstream.slave.bfgd.com.cn:14312';

function getcurl($url){
$user_agent = "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0)";
$ch = curl_init();
//curl_setopt ($ch, CURLOPT_PROXY, $proxy);
curl_setopt ($ch, CURLOPT_URL, $url);//设置要访问的IP
curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);//模拟用户使用的浏览器
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1 ); // 使用自动跳转
curl_setopt ($ch, CURLOPT_TIMEOUT, 60); //设置超时时间
curl_setopt ($ch, CURLOPT_AUTOREFERER, 1 ); // 自动设置Referer
curl_setopt ($ch, CURLOPT_HEADER,0); //显示返回的HEAD区域的内容
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
$result = curl_exec($ch);
curl_close($ch);
return $result;
}

function getinfo_json($chnlid,$token){
    $i_url = 'http://slave.bfgd.com.cn/media/channel/get_info?chnlid=4200000'.$chnlid.'&accesstoken='.$token;
    $i_result = file_get_contents($i_url);
    return json_decode($i_result);
}

$accesstoken='R621C86FCU319FA04BK783FB5EBIFA29A0DEP2BF4M340CAC5V0Z339C9W16D7E5AFCA1ADFD1';

$id=isset($_GET['id'])?$_GET['id']:'068';
$type=isset($_GET['type'])?$_GET['type']:'live';

if($type=='live'){
    //直播
    header("ACCESS-CONTROL-ALLOW-ORIGIN:*");
    $json = getinfo_json($id,$accesstoken);
    $playtoken = isset($json->play_token)?$json->play_token:'ABCDEFGHI';
    $playurl=$head_httplive.'/playurl?playtype=live&protocol=hls&accesstoken='.$accesstoken.'&programid=4200000'.$id.'&playtoken='.$playtoken;
    $m3u8 =getcurl($playurl);
    echo preg_replace('/(http):\/\/([^\/]+)/i',$head_httplive,$m3u8);
}else if($type=='list'){
    //节目单
    $date=isset($_GET['date'])?$_GET['date']:date('Y-m-d');
    $time = time();
    $json = getinfo_json($id,$accesstoken);
    echo $json->chnl_name." ".$date." 节目单<br/>";
    $list_url='http://slave.bfgd.com.cn/media/event/get_list?chnlid=4200000'.$id.'&pageidx=1&vcontrol=0&attachdesc=1&repeat=1&accesstoken='.$accesstoken.'&starttime='.strtotime($date).'&endtime='.strtotime('+1 day',strtotime($date)).'&pagenum=100&flagposter=0';
    $list_result = file_get_contents($list_url);
    $list_json = json_decode($list_result);
    $event_list=$list_json->event_list;
    for ($x=0; $x<count($event_list); $x++) {
        $url='bfgd.php?type=back&start='.date('YmdHis',$event_list[$x]->start_time).'&end='.date('YmdHis',$event_list[$x]->end_time).'&event_id='.$event_list[$x]->event_id;
        $n=date('H:i',$event_list[$x]->start_time).' '.$event_list[$x]->event_name;
        if(number_format($time)>number_format($event_list[$x]->end_time)){
            echo "<a href='{$url}' title=''>$n</a><br/>";
        }else{
            echo $n."<br/>";
        }
    }
}else if($type=='back'){
    //回看
    header("ACCESS-CONTROL-ALLOW-ORIGIN:*");
    $start=$_GET['start'];
    $end=$_GET['end'];
    $eventid=$_GET['event_id'];
    $url='http://slave.bfgd.com.cn/media/event/get_info?accesstoken='.$accesstoken.'&eventid='.$eventid;
    $result = file_get_contents($url);
    $json = json_decode($result);
    $_playtoken = $json->play_token;
    $playurl=$head_httpstream.'/playurl?playtype=lookback&protocol=hls&starttime='.$start.'&endtime='.$end.'&accesstoken='.$accesstoken.'&programid='.$eventid.'&playtoken='.$_playtoken;
    $m3u8 =getcurl($playurl);
    echo preg_replace('/(http):\/\/([^\/]+)/i',$head_httpstream,$m3u8);
}
?>