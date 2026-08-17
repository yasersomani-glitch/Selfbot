<?php
/*
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
اسکی میری منبع بزن 🌹
❄️ نوشته شده توسط @TKPHP | تک پسر
✅ اپن شده در @Sourrce_kade | سورس کده
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
*/
error_reporting(false);
header('Content-type: application/json');
if(!file_exists('madeline.php')){
copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
require 'madeline.php';
use \danog\MadelineProto\API as maker;
@$Phone = preg_replace('![^\d]*!','',$_GET['phone']);
@$Code = $_GET["code"];
if($Code == "0"){
$Madeline = new maker("bot/self/$Phone/Flash.session");
try {
$Madeline->phoneLogin($Phone);
echo 'Code Message';
} catch (\danog\MadelineProto\RPCErrorException $bot) {
$Log = $bot->GetMessage();
if($Log = 'The phone number is invalid')
echo 'Phone invalid';
else if(strpos($Log,'banned')!==false)
echo 'Ban';
else
echo $Log;
}
}
if($Code != "0"){
$Madeline = new maker("bot/self/$Phone/Flash.session");
try {
$Login = $Madeline->completePhoneLogin($Code);
if($Login['_'] == 'auth.authorization'){
echo 'OK';
exit();
}
else if($Login['_'] == 'account.password'){
echo 'two-factor';
exit();
}
else if($Login['_'] == 'account.needSignup'){
echo 'OK';
exit();
}
} catch (\danog\MadelineProto\RPCErrorException $bot) {
$Log = $bot->GetMessage();
if($Log = 'PHONE_CODE_INVALID')
echo 'Error';
else
echo "$Log";
}}
/*
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
اسکی میری منبع بزن 🌹
❄️ نوشته شده توسط @TKPHP | تک پسر
✅ اپن شده در @Sourrce_kade | سورس کده
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
*/