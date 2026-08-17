<?php
/*
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
اسکی میری منبع بزن 🌹
❄️ نوشته شده توسط @TKPHP | تک پسر
✅ اپن شده در @Sourrce_kade | سورس کده
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
*/
// =-=-=-=-=-= Hrader =-=-=-=-=-=
error_reporting(false);
header('content-type:application/json;charset=utf-8');
// =-=-=-=-=-= Acciunt Information =-=-=-=-=-=
$email = 'kodeagp@hi2.in'; // Username of your account in Cron-Job.org
$pass  = 'kodeagp@hi2.in'; // Password of your account in Cron-Job.org
// =-=-=-=-=-= Script =-=-=-=-=-=
if(isset($_GET['url']) and isset($_GET['time']) and isset($_GET['phone']) and $_GET['url'] !== null and $_GET['time'] !== null and $_GET['phone'] !== null){
$urlcron = $_GET['url'];
$timer = $_GET['time'];
$phone = $_GET['phone'];
if($_GET['time'] == 1 or $_GET['time'] == 2 or $_GET['time'] == 5 or $_GET['time'] == 10 or $_GET['time'] == 15 or $_GET['time'] == 30){
if($timer==1){
$data=":[-1],";
}
if($timer==2){
$data=":[0,2,4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34,36,38,40,42,44,46,48,50,52,54,56,58],";
}
if($timer==5){
$data=":[0,5,10,15,20,25,30,35,40,45,50,55],";
}
if($timer==10){
$data=":[0,10,20,30,40,50],";
}
if($timer==15){
$data=":[0,15,30,45],";
}
if($timer==30){
$data=":[0,30],";
}
if($timer==60){
$data=":[0],";
}
        // =-=-=-=-=-= Curl OPT =-=-=-=-=-=
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.cron-job.org/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"email":"'.$email.'","password":"'.$pass.'","rememberMe":true}');
        $headers = array();
        $headers[] = 'Connection: keep-alive';
        $headers[] = 'Sec-Ch-Ua: ^^Google';
        $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
        $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept: application/json, text/plain, */*';
        $headers[] = 'X-Api-Method: Login';
        $headers[] = 'X-Ui-Language: en';
        $headers[] = 'Sec-Ch-Ua-Platform: ^^Windows^^\"\"';
        $headers[] = 'Origin: https://console.cron-job.org';
        $headers[] = 'Sec-Fetch-Site: same-site';
        $headers[] = 'Sec-Fetch-Mode: cors';
        $headers[] = 'Sec-Fetch-Dest: empty';
        $headers[] = 'Referer: https://console.cron-job.org/';
        $headers[] = 'Accept-Language: en-US,en;q=0.9,fa;q=0.8';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        $a = json_decode($result,true);
        $token = $a['token'];
        curl_close($ch);
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://api.cron-job.org/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 
        '{"job":{
            "title":"@FlashSelfBot - $phone",
            "url":"'.$urlcron.'",
            "enabled":true,
            "saveResponses":false,
            "auth":{"enable":false,
            "user":"","password":""
    },
            "notification":{
                "onSuccess":true,
                "onDisable":true,
                "onFailure":false
    },
            "requestMethod":0,
            "extendedData":{
                "body":"","headers":{}},
                "schedule":{"mdays":[-1],
                "wdays":[-1],
                "months":[-1],
                "hours":[-1],
                "minutes"'.$data.'
                "timezone":"Asia/Tehran"
    }
}}');
        // =-=-=-=-=-= Hrader's Array =-=-=-=-=-=
        $headers = array();
        $headers[] = 'Connection: keep-alive';
        $headers[] = 'Sec-Ch-Ua: ^^Google';
        $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
        $headers[] = 'Authorization: Bearer '.$token;
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept: application/json, text/plain, */*';
        $headers[] = 'X-Api-Method: CreateJob';
        $headers[] = 'X-Ui-Language: en';
        $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36';
        $headers[] = 'Sec-Ch-Ua-Platform: ^^Windows^^\"\"';
        $headers[] = 'Origin: https://console.cron-job.org';
        $headers[] = 'Sec-Fetch-Site: same-site';
        $headers[] = 'Sec-Fetch-Mode: cors';
        $headers[] = 'Sec-Fetch-Dest: empty';
        $headers[] = 'Referer: https://console.cron-job.org/';
        $headers[] = 'Accept-Language: en-US,en;q=0.9,fa;q=0.8';
        $headers[] = 'Cookie: refreshToken=1xF67oLl2C2giAEv1vbH7JDm0Y0vrl0J09kNE4KsSEYoAUSntsAKSkYyMYQpmnmm';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
echo json_encode(['ok'=> 'true', 'results'=>['message'=>"Cron Job Now Is Set !",'link'=>$_GET['url'],'time'=>"$timer Minutes",'phone'=>$_GET['phone']]], 448);
}else{
echo json_encode(['ok'=> 'false', 'results'=>"time Value Is Invalid !"], 448);
}
}else{
echo json_encode(['ok'=> 'false', 'results'=>"time Or url Or phone Fields Is NULL !"], 448);
}
/*
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
اسکی میری منبع بزن 🌹
❄️ نوشته شده توسط @TKPHP | تک پسر
✅ اپن شده در @Sourrce_kade | سورس کده
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
*/