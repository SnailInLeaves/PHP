<?php
//Rewrite by absentfriend
$cityId = '5A';
$playId= isset($_GET['id']) ? $_GET['id'] : '';
$relativeId = $playId;
$type='1';
$appId = "kdds-chongqingdemo";
$url ='http://portal.centre.bo.cbnbn.cn/others/common/playUrlNoAuth?cityId=5A&playId='.$playId.'&relativeId='.$relativeId.'&type=1';
$curl = curl_init();
$timestamps = round(microtime(true) * 1000);
$sign =md5('aIErXY1rYjSpjQs7pq2Gp5P8k2W7P^Y@appId' . $appId . "cityId" . $cityId. "playId" . $playId . "relativeId" . $relativeId . "timestamps" . $timestamps . "type" . $type);
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'appId: kdds-chongqingdemo',
    'sign: '.$sign,
    'timestamps:'.$timestamps,
    'Content-Type: application/json;charset=utf-8'
  ),
));

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo 'Curl error: ' . curl_error($curl);
}

curl_close($curl);

if (!$response) {
    echo 'Error: No response received from server';
}

$url = (json_decode($response));

if (!$url) {
    echo 'Error: Failed to parse JSON response';
}

$codes = isset($url->data->result->protocol[0]->transcode[0]->url) ? $url->data->result->protocol[0]->transcode[0]->url : '';

if (!$codes) {
    echo 'Error: No video URL found in response';
}

header('location:'.$codes);
exit;
?>