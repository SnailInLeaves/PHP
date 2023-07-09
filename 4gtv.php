<?php
error_reporting(0);
$channel = $_GET['id'] ?? "litv-longturn03";
$ch4g = array(
    "litv-ftv13" => "民視新聞台",
    "litv-longturn14" => "寰宇新聞台",
    "4gtv-4gtv052" => "華視新聞資訊台",
    "4gtv-4gtv012" => "空中英語教室",
    "litv-ftv07" => "民視旅遊台",
    "litv-ftv15" => "i-Fun動漫台",
    "4gtv-live206" => "幸福空間居家台",
    "4gtv-4gtv070" => "愛爾達娛樂台",
    "litv-longturn17" => "亞洲旅遊台",
    "4gtv-4gtv025" => "MTV Live HD",
    "litv-longturn15" => "寰宇新聞台灣台",
    "4gtv-4gtv001" => "民視台灣台",
    "4gtv-4gtv074" => "中視新聞台",
    "4gtv-4gtv011" => "影迷數位電影台",
    "4gtv-4gtv047" => "靖天日本台",
    "litv-longturn11" => "龍華日韓台",
    "litv-longturn12" => "龍華偶像台",
    "4gtv-4gtv042" => "公視戲劇",
    "litv-ftv12" => "i-Fun動漫台3",
    "4gtv-4gtv002" => "民視無線台",
    "4gtv-4gtv027" => "CI 罪案偵查頻道",
    "4gtv-4gtv013" => "CNEX紀實頻道",
    "litv-longturn03" => "龍華電影台",
    "4gtv-4gtv004" => "民視綜藝台",
    "litv-longturn20" => "ELTV英語學習台",
    "litv-longturn01" => "龍華卡通台",
    "4gtv-4gtv040" => "中視無線台",
    "litv-longturn02" => "Baby First",
    "4gtv-4gtv003" => "民視第一台",
    "4gtv-4gtv007" => "大愛電視台",
    "4gtv-4gtv076" => "SMART 知識頻道",
    "4gtv-4gtv030" => "CNBC",
    "litv-ftv10" => "半島電視台"
);
function curl_get($url)
{
    $header = [
        "User-Agent: okhttp/3.12.11"
    ];
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 50);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_PROXY, '192.168.10.171'); //http代理服务器地址
    curl_setopt($curl, CURLOPT_PROXYPORT, '6152'); //http代理服务器端口
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_ENCODING, '');
    $data = curl_exec($curl);
    if (curl_error($curl)) {
        return "Error: " . curl_error($curl);
    } else {
        curl_close($curl);
        return $data;
    }
}

function findString($str, $start, $end)
{
    $from_pos = strpos($str, $start);
    $end_pos = strpos($str, $end);
    return substr($str, $from_pos, ($end_pos - $from_pos + 1));
}

$data = json_decode(findString(curl_get("https://app.4gtv.tv/Data/HiNet/GetURL.ashx?Type=LIVE&Content=" . $channel), "{", "}"), true)['VideoURL'];
$key = "VxzAfiseH0AbLShkQOPwdsssw5KyLeuv";
$iv = substr($data, 0, 16);
$streamurl = openssl_decrypt(base64_decode(substr($data, 16)), "AES-256-CBC", $key, 1, $iv);
header("Location: " . $streamurl);
exit;