<?php
$id=$_GET['id'];
$url="http://[2409:8087:6a01:1020::c]/cdnrrs.gz.chinamobile.com/PLTV/88888888/224/".$id."/1/index.m3u8?fmt=ts2hls/";
header('location:'.urldecode($url));
?>