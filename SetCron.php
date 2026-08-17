<?php
/*
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
اسکی میری منبع بزن 🌹
❄️ نوشته شده توسط @TKPHP | تک پسر
✅ اپن شده در @Sourrce_kade | سورس کده
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
*/
@$domain = "https://FlashSelf.site/FlashSelf";
$cron = glob('bot/self/*/index.php');
foreach($cron as $crons){
$rand = rand(11111,99999);
file_get_contents("$domain/AutoCron.php?url=$domain/$crons&time=1&phone=$rand");
}
$cronn = glob('bot/tabchi/*/index.php');
foreach($cronn as $cronss){
$rand = rand(11111,99999);
file_get_contents("$domain/AutoCron.php?url=$domain/$cronss&time=1&phone=$rand");
}
$cronnn = glob('bot/clicker/*/index.php');
foreach($cronnn as $cronsss){
$rand = rand(11111,99999);
file_get_contents("$domain/AutoCron.php?url=$domain/$cronsss&time=1&phone=$rand");
}
echo 'OK . . . !';
if(is_file("error_log")){
file_get_contents("error_log");
}
/*
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
اسکی میری منبع بزن 🌹
❄️ نوشته شده توسط @TKPHP | تک پسر
✅ اپن شده در @Sourrce_kade | سورس کده
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
*/
?>