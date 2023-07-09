<?php
    $channel = empty($_GET['id']) ? "CCTV1HD_6000" : trim($_GET['id']);
    $stream = "http://liveyfs.yun.gehua.net.cn:8088/live/ipcdn,{$channel}K/";
    $timestamp = intval((time()-60)/6);
    $current = "#EXTM3U"."\r\n";
    $current.= "#EXT-X-VERSION:3"."\r\n";
    $current.= "#EXT-X-TARGETDURATION:6"."\r\n";
    $current.= "#EXT-X-MEDIA-SEQUENCE:{$timestamp}"."\r\n";
    for ($i=0; $i<6; $i++)
    {
        $current.= "#EXTINF:6,"."\r\n";
        $current.= $stream.rtrim(chunk_split($timestamp, 3, "/"), "/").".ts"."\r\n";
        $timestamp = $timestamp + 1;
    }
    header("Content-Disposition: attachment; filename=index.m3u8");
    echo $current;