<?php
/*
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
اسکی میری منبع بزن 🌹
❄️ نوشته شده توسط @TKPHP | تک پسر
✅ اپن شده در @Sourrce_kade | سورس کده
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
*/
$domain = "https://nitro-server.net/FlashSelf";
$Time = stream_context_create(['http'=>['timeout' => 1]]);
$Glob = glob('bot/*/*/index.php');
foreach($Glob as $Globs){
file_get_contents("$domain/$Globs", false, $Time);
}
if(is_file("error_log")){
unlink("error_log");
}
?>