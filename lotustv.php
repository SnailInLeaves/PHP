<?php
    $bstrURL = 'http://live-hls.macaulotustv.com/lotustv/macaulotustv.m3u8';
    $headers = array(
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.77 Safari/537.36',
        'Referer: http://www.lotustv.cc/'

    );

    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$bstrURL);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $data = curl_exec($ch);
    $bstrURL = preg_replace('/#.*?\n/i','',$data);
    header('location: '.$bstrURL);

?>