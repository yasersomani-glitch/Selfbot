<?php
/*
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
اسکی میری منبع بزن 🌹
❄️ نوشته شده توسط @TKPHP | تک پسر
✅ اپن شده در @Sourrce_kade | سورس کده
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
*/
$Glob = glob('bot/self/*/madeline-74.phar');
foreach($Glob as $Globs){
unlink("$Globs");
}
$Globb = glob('bot/tabchi/*/madeline-74.phar');
foreach($Globb as $Globss){
unlink("$Globss");
}
$Globbb = glob('bot/clicker/*/madeline-74.phar');
foreach($Globbb as $Globsss){
unlink("$Globsss");
}
$error = glob('bot/self/*/error_log');
foreach($error as $errors){
unlink("$errors");
}
$errorr = glob('bot/tabchi/*/error_log');
foreach($errorr as $errorss){
unlink("$errorss");
}
$errorrr = glob('bot/clicker/*/error_log');
foreach($errorrr as $errorsss){
unlink("$errorsss");
}
echo 'OK . . . !';
if(is_file("error_log")){
unlink("error_log");
}
?>