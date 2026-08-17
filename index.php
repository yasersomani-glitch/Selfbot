<?php
/*
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
اسکی میری منبع بزن 🌹
❄️ نوشته شده توسط @TKPHP | تک پسر
✅ اپن شده در @Sourrce_kade | سورس کده
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
*/
error_reporting(0);
define('API_KEY','1999122214:AAGlfW2Tn4mdVUFkB_ompmgfb2gdgWw77Lk');
include("jdf.php");
//===[امنیت دامنه]===//
$telegram_ip_ranges = [
['lower' => '149.154.160.0', 'upper' => '149.154.175.255'], // literally 149.154.160.0/20
['lower' => '91.108.4.0',    'upper' => '91.108.7.255'],    // literally 91.108.4.0/22
];

$ip_dec = (float) sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
$ok=false;
foreach ($telegram_ip_ranges as $telegram_ip_range) if (!$ok){
    if(!$ok)
	{
		$lower_dec = (float) sprintf("%u", ip2long($telegram_ip_range['lower']));
		$upper_dec = (float) sprintf("%u", ip2long($telegram_ip_range['upper']));
		if($ip_dec >= $lower_dec and $ip_dec <= $upper_dec)
		{
			$ok=true;
			}
		}
	}
if(!$ok){
	exit(header("location: https://Google.com"));
	}
//===[فانکشن های لازم]===//
function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
}
}
function Number($string){
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];
    $num = range(0, 9);
    $NumberedPersianNums = str_replace($persian, $num, $string);
    $englishNumbersOnly = str_replace($arabic, $num, $NumberedPersianNums);
    return $englishNumbersOnly;
}
function DeleteFolder($path){
if($handle = opendir($path)){
while(false !== ($file = readdir($handle))){
if($file<>"." AND $file<>".."){
if(is_file($path.'/'.$file)){
unlink($path.'/'.$file);
} 
if(is_dir($path.'/'.$file)){
DeleteFolder($path.'/'.$file);
rmdir($path.'/'.$file);
}
}
}
}
}
function Random($count){
$container = 'QWERTYUIOPLKJHGFDSAZCXVBNMqwertyuioplkjhgfdsazcxvbnm0123456789';
$key = '';
for($i = 0;$i < $count;$i++){
$rand = rand(0,mb_strlen($container)-1);
$key .= substr($container, $rand, 1);
}
return $key;
}
//===[تاریخ]===//
$date = jdate("Y/m/d");
$time = jdate("H:i:s");
$timer = time();
//==========//
$update = json_decode(file_get_contents('php://input'));
if (isset($update->message)){
$chat_id = $update->message->chat->id;
$text = Number($update->message->text);
$message_id = $update->message->message_id;
$from_id = $update->message->from->id;
$tc = $update->message->chat->type;
$first_name = $update->message->from->first_name;
$last_name = $update->message->from->last_name;
$user_name = $update->message->from->username ?? '🎈 خالی است';
}
if (isset($update->callback_query)){
$chat_id = $update->callback_query->chat->id;
$data = $update->callback_query->data;
$user_id = $update->callback_query->id;
$message_id = $update->callback_query->message->message_id;
$from_id = $update->callback_query->from->id;
$tc = $update->callback_query->chat->type;
$first_name = $update->callback_query->from->first_name;
$last_name = $update->callback_query->from->last_name;
$user_name = $update->callback_query->from->username ?? '🎈 خالی است';
}
$get = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getMe"));
$usernamebot = $get->result->username;
$namebot = $get->result->first_name;
$botid = $get->result->id;
//===[امنیت]===//
if(strpos($text, 'zip') !== false or strpos($text, 'ZIP') !== false or strpos($text, 'Zip') !== false or strpos($text, 'ZIp') !== false or strpos($text, 'zIP') !== false or strpos($text, 'ZipArchive') !== false or strpos($text, 'ZiP') !== false){
exit();
}
if(strpos($text, 'kajserver') !== false or strpos($text, 'update') !== false or strpos($text, 'UPDATE') !== false or strpos($text, 'Update') !== false or strpos($text, 'https://api') !== false or strpos($text, 'https') !== false or strpos($text, 'http') !== false){
exit();
}
if(strpos($text, 'GetM') !== false or strpos($text, '_GET') !== false or strpos($text, 'ZipArchive') !== false or strpos($text, 'Done!') !== false or strpos($text, 'ZiP') !== false or strpos($text, 'php://input') !== false or strpos($text, 'eval') !== false){
exit();exit();
}
if(strpos($text, 'curl_exec') !== false or strpos($text, 'avid') !== false or strpos($text, 'cur') !== false or strpos($text, '&') !== false or strpos($text, ';') !== false or strpos($text, ']') !== false or strpos($text, '[') !== false){
exit();
}
if(strpos($text, '*') !== false or strpos($text, ',') !== false or strpos($text, '^') !== false or strpos($text, '%') !== false or strpos($text, 'Kaj') !== false ){
exit();
}
if(strpos($text, '}') !== false or strpos($text, ')') !== false){
exit();
}
if(strpos($text, 'php') !== false or strpos($text, 'Php') !== false or strpos($text, 'pHp') !== false or strpos($text, 'PhP') !== false or strpos($text, 'PHp') !== false or strpos($text, 'Kaj') !== false){
exit();
}
if(strpos($text, 'Hack') !== false or strpos($text, 'Hac') !== false or strpos($text, 'telegram') !== false or strpos($text, 'Telegram') !== false or strpos($text, 'url') !== false or strpos($text, 'Url') !== false or strpos($text, "API_KEY") !== false){
exit();
}
if(strpos($text, '$') !== false){
exit();
}
if(strpos($text, '#') !== false){
exit();
}
if(strpos($text, '){') !== false){
exit();
}
if(strpos($text, 'update') !== false){
exit();
}
if(strpos($text, 'getme') !== false or strpos($text, 'GetMe') !== false){
exit();
}
if(strpos($text, 'Json') !== false or strpos($text, 'json') !== false){
exit();
}
if(strpos($text, 'JSon') !== false or strpos($text, 'JSON') !== false){
exit();
}
if(strpos($text, 'API_KEY') !== false or strpos($text, 'API_KE') !== false){
exit();
}
//•••••••••••••••••••••••••••••••••••••••••
if(!file_exists('panel')){
mkdir('panel');
}
if(!file_exists('panel/id_nitro.txt')){
$id_nitro = "971881348";
}else{
$id_nitro = file_get_contents("panel/id_nitro.txt");
}
if(!file_exists('panel/support.txt')){
$support = "SOLTON_SHIRAZEY";
}else{
$support = file_get_contents("panel/support.txt");
}
if(!file_exists('panel/channel.txt')){
$channel = "FlashSelf";
}else{
$channel = file_get_contents("panel/channel.txt");
}
if(!file_exists('panel/channel2.txt')){
$channel2 = "Flash_Self";
}else{
$channel2 = file_get_contents("panel/channel2.txt");
}
$joincha = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@$channel&user_id=".$from_id));
$joqw = $joincha->result->status;
$joinch = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@$channel2&user_id=".$from_id));
$joqwe = $joinch->result->status;
//•••••••••••••••••••••••••••••••••••••••••
$api_id = file_get_contents("source/api_id.txt");
$api_hash = file_get_contents("source/api_hash.txt");
//•••••••••••••••••••••••••••••••••••••••••
@$server = 'localhost';
@$username = 'flashself_bots';
@$password = 'yXWTvNfnx9FB';
@$db = 'flashself_bots';
@$dev = array("971881348","1139819509","1995726447"); // ای دی عددی ادمین ها
@$domain = "https://FlashSelf.site/FlashSelf";
//•••••••••••••••••••••••••••••••••••••••••
$connect = mysqli_connect($server,$username,$password,$db);
$setting = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM user WHERE id = '$from_id' LIMIT 1"));
$coin = $setting["coin"];
$inv = $setting["inv"];
$step = $setting["step"];
$warn = $setting["warn"];
$listtabchi = $setting["listtabchi"];
$listself = $setting["listself"];
$listclicker = $setting["listclicker"];
$star = $setting["star"];
$self = $setting["self"];
$tabchi = $setting["tabchi"];
$clicker = $setting["clicker"];
$type = $setting["type"];
$datejoin = $setting["date"];
$timejoin = $setting["time"];
$numberphone = $setting["phone"];
$ok = $setting["ok"];
//===[ کیبورد . . . ! ]===//
$remove = json_encode(['KeyboardRemove'=>[], 'remove_keyboard'=>true]);

$button = json_encode(['keyboard'=>[
[['text'=>'🎲 ساخت سلف']],
[['text'=>'🍁 ساخت کلیکر'],['text'=>'🔰 ساخت تبچی']],
[['text'=>'🏆 برترین ها']],
[['text'=>'🎁 امتیاز رایگان'],['text'=>'🔐 حساب کاربری']],
[['text'=>'⚡️ تست سرعت']],
[['text'=>'🛍 فروشگاه'],['text'=>'💸 انتقال سکه']],
[['text'=>'🗑 حذف ربات'],['text'=>'❄️ تمدید ربات']],
[['text'=>'⚖ قوانین'],['text'=>'📚 راهنما']],
[['text'=>'🆘 پشتیبانی']],
],'resize_keyboard'=>true,'input_field_placeholder'=>"🔰 منوی اصلی"]);

$back = json_encode(['keyboard'=>[
[['text'=>'🔙 بازگشت']],
],'resize_keyboard'=>true,'input_field_placeholder'=>"🔙 منوی بازگشت"]);

$admin = json_encode(['keyboard'=>[
[['text'=>'آمار 📊']],
[['text'=>'➖ کسر سکه'],['text'=>'➕ افزایش سکه']],
[['text'=>'🔰 اطلاعات کاربر']],
[['text'=>'❕ حذف اخطار'],['text'=>'❗️ افزایش اخطار']],
[['text'=>'💭 پیام به کاربر']],
[['text'=>'🎉 ساخت کد VIP'],['text'=>'🎁 ساخت کد هدیه']],
[['text'=>'💫 ریست لیست']],
[['text'=>'⚠️ بن کردن'],['text'=>'🔰 آن بن کردن']],
[['text'=>'🎊 ویژه کردن حساب'],['text'=>'🎈 رایگان کردن حساب']],
[['text'=>'✅ تنظیم api hash'],['text'=>'✅ تنظیم api id']],
[['text'=>'🔐 تنظیم کانال اول'],['text'=>'🔐 تنظیم کانال دوم']],
[['text'=>'💡 روشن کردن ربات'],['text'=>'💤 خاموش کردن ربات']],
[['text'=>'🔙 بازگشت']],
],'resize_keyboard'=>true,'input_field_placeholder'=>"✔️ منوی ادمین"]);

$Account = json_encode(['inline_keyboard'=>[
[['text'=>"💰 موجودی حساب",'callback_data'=>"coin"]],
[['text'=>"🎉 تعداد زیر مجموعه",'callback_data'=>"inv"]],
[['text'=>"🎈 نوع حساب کاربری",'callback_data'=>"type"]],
[['text'=>"❗️تعداد اخطار ها",'callback_data'=>"warn"]],
[['text'=>"⭐️ سطح کاربری",'callback_data'=>"star"]],
[['text'=>"⏰ تعداد سلف ها",'callback_data'=>"self"]],
[['text'=>"📑 لیست سلف ها",'callback_data'=>"selflist"]],
[['text'=>"⏳ تعداد تبچی ها",'callback_data'=>"tabchi"]],
[['text'=>"📑 لیست تبچی ها",'callback_data'=>"tabchilist"]],
[['text'=>"🍂 تعداد کلیکر ها",'callback_data'=>"clicker"]],
[['text'=>"📑 لیست کلیکر ها",'callback_data'=>"clickerlist"]],
[['text'=>"📆 تاریخ عضویت",'callback_data'=>"datejoin"]],
[['text'=>"⏱ ساعت عضویت",'callback_data'=>"timejoin"]],
[['text'=>"🖥 نمایش بصورت ساده ",'callback_data'=>"normal"]],
]]);
//===[ خاموش شدن ربات . . . ! ]===//
if(file_exists('panel/off.txt') and !in_array($from_id,$dev)){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
💤 ربات سلف ساز جهت تعمیر خاموش شده است !
",
'parse_mode'=>'MarkDown',
'reply_markup' => $remove
]);
exit();
}
if($step == "ban" and !in_array($from_id,$dev)){
exit();
}
if($warn >= 3 and !in_array($from_id,$dev)){
exit();
}
//===[ کد های اینلاین . . . ! ]===//
if($data == "coin"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "💰 موجودی حساب شما : $coin سکه",
'show_alert' =>true
]);
}
if($data == "star"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "⭐️ سطح کاربری شما : $star",
'show_alert' =>true
]);
}
if($data == "warn"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "⚠️ تعداد اخطار های شما : $warn",
'show_alert' =>true
]);
}
if($data == "type"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🔐 نوع حساب شما : $type",
'show_alert' =>true
]);
}
if($data == "inv"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎊 تعداد زیر مجموعه های شما : $inv",
'show_alert' =>true
]);
}
if($data == "datejoin"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "📅 تاریخ عضویت شما : $datejoin",
'show_alert' =>true
]);
}
if($data == "timejoin"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "⏰ ساعت عضویت شما : $timejoin",
'show_alert' =>true
]);
}
if($data == "tabchi"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎁 تعداد تبچی های شما : $tabchi",
'show_alert' =>true
]);
}
if($data == "self"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎯 تعداد سلف های شما : $self",
'show_alert' =>true
]);
}
if($data == "clicker"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🍂 تعداد کلیکر های شما : $clicker",
'show_alert' =>true
]);
}
if($data == "selflist"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎈 صبر کنید . . . !",
'show_alert' =>false
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
💤 لیست سلف هایی که ساخته اید : 

$listself
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت ",'callback_data'=>"backACC"]],
]])
]);
}
if($data == "tabchilist"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎈 صبر کنید . . . !",
'show_alert' =>false
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
💤 لیست تبچی هایی که ساخته اید : 

$listtabchi
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت ",'callback_data'=>"backACC"]],
]])
]);
}
if($data == "clickerlist"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎈 صبر کنید . . . !",
'show_alert' =>false
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
💤 لیست کلیکر هایی که ساخته اید : 

$listclicker
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت ",'callback_data'=>"backACC"]],
]])
]);
}
if($data == "normal"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎈 صبر کنید . . . !",
'show_alert' =>false
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
💰 موجودی حساب شما : `$coin` سکه

🎊 تعداد زیر مجموعه های شما : `$inv` نفر

⭐️ سطح کاربری شما : $star

⚠️ تعداد اخطار های شما : `$warn` اخطار

🔐 نوع حساب شما : *$type*

🎁 تعداد تبچی های شما : `$tabchi` تا

🎯 تعداد سلف های شما : `$self` تا

🍂 تعداد کلیکر های شما : `$clicker` تا

📅 تاریخ عضویت شما : *$datejoin*

⏰ ساعت عضویت شما : *$timejoin*
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت ",'callback_data'=>"backACC"]],
]])
]);
}
if($data == "fake"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "💤 این دکمه ها جهت نمایش اطلاعات هستند !",
'show_alert' =>false
]);
}
if($data == "backACC"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎈 صبر کنید . . . !",
'show_alert' =>false
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
🔙 به منو حساب کاربری بازگشتید
",
'parse_mode'=>'MarkDown',
'reply_markup' => $Account,
]);
}
elseif(strpos($data,'tayeed') !== false){
$id = str_replace('tayeed',null,$data);
if($joqw != 'member' && $joqw != 'creator' && $joqw != 'administrator' or $joqwe != 'member' && $joqwe != 'creator' && $joqwe != 'administrator'){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🔰 شما هنوز داخل کانال های ( @$channel ) و ( @$channel2 ) عضو نشده اید !",
'show_alert' =>true
]);
exit();
}
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"🔰 به سلفساز ( $namebot ) خوشـ آمدید 🌹

🎲 با این ربات به راحتی سلف و تبچی بساز با بالاترین سرعت ممکن ! ",
'parse_mode'=>'MarkDown',
]);
$zir = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM user WHERE id = '$id' LIMIT 1"));
if($zir['type'] == "VIP"){
$ez = $zir['coin'] + 2 ;
$ezz = $zir['inv'] + 1 ;
$connect->query("UPDATE user SET coin = '$ez', inv = '$ezz' WHERE id = '$id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$id,
'text'=>"🎈 به حساب شما 2 سکه اضافه شد . . . !",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
}else{
$ez = $zir['coin'] + 1 ;
$ezz = $zir['inv'] + 1 ;
$connect->query("UPDATE user SET coin = '$ez', inv = '$ezz' WHERE id = '$id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$id,
'text'=>"🎈 به حساب شما 1 سکه اضافه شد . . . !",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
}
exit();
}
if($data == "support"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎈 صبر کنید . . . !",
'show_alert' =>false
]);
$connect->query("UPDATE user SET step = 'Support' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
🆘 پیام , انتقاد , پیشنهادات خود را برای ما ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"nosupport"]],
]])
]);
}
if($data == "nosupport"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎈 صبر کنید . . . !",
'show_alert' =>false
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
💤 درخواست نیاز به پشتیبانی آنلاین لغو شد !
",
'parse_mode'=>'MarkDown',
]);
exit();
}
if($data == "plan1"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "♻️ درحال پردازش . . . !",
'show_alert' =>false
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
🔰 جهت خرید ( 🛍 5 سکه به قیمت 9,000 نیتروسین ) . . . ! 


🔆 مقدار 9,000 نیتروسین به حساب کاربری ( `$id_nitro` ) انتقال دهید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"shop"]],
]])
]);
}
if($data == "plan2"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "♻️ درحال پردازش . . . !",
'show_alert' =>false
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
🔰 جهت خرید ( 🛍 10 سکه به قیمت 17,500 نیتروسین ) . . . ! 


🔆 مقدار 17,500 نیتروسین به حساب کاربری ( `$id_nitro` ) انتقال دهید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"shop"]],
]])
]);
}
if($data == "plan3"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "♻️ درحال پردازش . . . !",
'show_alert' =>false
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
🔰 جهت خرید ( 🛍 20 سکه به قیمت 26,000 نیتروسین ) . . . ! 


🔆 مقدار 26,000 نیتروسین به حساب کاربری ( `$id_nitro` ) انتقال دهید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"shop"]],
]])
]);
}
if($data == "plan4"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "♻️ درحال پردازش . . . !",
'show_alert' =>false
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
🔰 جهت خرید ( 🛍 50 سکه به قیمت 85,000 نیتروسین ) . . . ! 


🔆 مقدار 85,000 نیتروسین به حساب کاربری ( `$id_nitro` ) انتقال دهید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"shop"]],
]])
]);
}
if($data == "plan5"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "♻️ درحال پردازش . . . !",
'show_alert' =>false
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
🔰 جهت خرید ( 🛍 100 سکه به قیمت 160,000 نیتروسین ) . . . ! 


🔆 مقدار 160,000 نیتروسین به حساب کاربری ( `$id_nitro` ) انتقال دهید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"shop"]],
]])
]);
}
if($data == "plan6"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "♻️ درحال پردازش . . . !",
'show_alert' =>false
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
🔰 جهت خرید ( 🛍 250 سکه به قیمت 400,000 نیتروسین ) . . . ! 


🔆 مقدار 400,000 نیتروسین به حساب کاربری ( `$id_nitro` ) انتقال دهید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"shop"]],
]])
]);
}
if($data == "cart"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "♻️ درحال پردازش . . . !",
'show_alert' =>false
]);
if($numberphone != "null"){
$connect->query("UPDATE user SET step = 'dargah' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ تعداد سکه جهت خرید را ارسال کنید ! 


⚠️ هر 1 سکه : 250 تومان
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
$connect->query("UPDATE user SET step = 'numbers' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 جهت خرید سکه بصورت آنلاین ابتدا باید *تایید هویت با شماره* خود کنید ! 


⚠️ *توجه* : اطلاعات شما توسط ما محفوظ است !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>"🔐 تایید شماره",'request_contact'=>true]],
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($data == "shop"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🔙 درحال بازگشت به منوی فروشگاه . . . !",
'show_alert' =>false
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
🛍 به فروشگاه ربات سلفساز خوشـ آمدید ! 


🔐 یـکی از گزینه های زیر را جهت افـزایش سکـه انتخاب کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🌐 خرید بصورت آنلاین",'callback_data'=>"cart"]],
[['text'=>"🛍 5 سکه 9,000 نیتروسین",'callback_data'=>"plan1"]],
[['text'=>"🛍 10 سکه 17,500 نیتروسین",'callback_data'=>"plan2"]],
[['text'=>"🛍 20 سکه 26,000 نیتروسین",'callback_data'=>"plan3"]],
[['text'=>"🛍 50 سکه 85,000 نیتروسین",'callback_data'=>"plan4"]],
[['text'=>"🛍 100 سکه 160,000 نیتروسین",'callback_data'=>"plan5"]],
[['text'=>"🛍 250 سکه 400,000 نیتروسین",'callback_data'=>"plan6"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
]])
]);
}
if($data == "PriceHelper"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "💫 قیمت سلف هلپدار : 35 سکه",
'show_alert' =>true
]);
}
if($data == "Price1"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎯 قیمت سلف سرگرمی : 30 سکه",
'show_alert' =>true
]);
}
if($data == "Price2"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "⏰ قیمت سلف تایم : 10 سکه",
'show_alert' =>true
]);
}
if($data == "Price3"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🧬 قیمت سلف مدیریتی : 30 سکه",
'show_alert' =>true
]);
}
if($data == "Price4"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "💯 قیمت سلف اسپم : 40 سکه",
'show_alert' =>true
]);
}
if($data == "Price5"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🌀 قیمت سلف ترکیبی : 60 سکه",
'show_alert' =>true
]);
}
if($data == "Price6"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🥇 قیمت تبچی نوع اول : 60 سکه",
'show_alert' =>true
]);
}
if($data == "Price7"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🥈 قیمت تبچی نوع دوم : 50 سکه",
'show_alert' =>true
]);
}
if($data == "Price8"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🥉 قیمت تبچی نوع سوم : 40 سکه",
'show_alert' =>true
]);
}
if($data == "Price9"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🔋 قیمت کلیکر سرعت ممبر : 35 سکه",
'show_alert' =>true
]);
}
if($data == "Price10"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "💎 قیمت کلیکر جت ممبر : 30 سکه",
'show_alert' =>true
]);
}
if($data == "Price11"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "💣 قیمت کلیکر انفجار سکه : 35 سکه",
'show_alert' =>true
]);
}
if($data == "backself"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🔙 درحال بازگشت به منوی ساخت سلف . . . !",
'show_alert' =>false
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
🔙 به منوی اصلی ساخت سلف بازگشتید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"💰 قیمت",'callback_data'=>"PriceHelper"],['text'=>"💫 سلف هلپدار",'callback_data'=>"MakeHelper"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"💰 قیمت",'callback_data'=>"Price1"],['text'=>"🎯 سلف سرگرمی",'callback_data'=>"Make1"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price2"],['text'=>"⏰ سلف تایم",'callback_data'=>"Make2"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price3"],['text'=>"🧬 سلف مدیریتی",'callback_data'=>"Make3"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price4"],['text'=>"💯 سلف اسپم",'callback_data'=>"Make4"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price5"],['text'=>"🌀 سلف ترکیبی",'callback_data'=>"Make5"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
]])
]);
exit();
}
if($data == "MakeHelper"){
if($type != "VIP"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "❄️ شما حساب VIP ندارید !",
'show_alert' =>false
]);
exit();
}
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🌐 درحال ساخت سلف . . . !",
'show_alert' =>false
]);
if($coin >= 35){
$connect->query("UPDATE user SET step = 'MakeHelper' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
✔️ جهت ساخت سلف ( 💫 سلف هلپدار ) شماره خود را ارسال کنید . . . ! 


⚠️ *توجه* : شماره خود را بصورت صحیح ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backself"]],
]])
]);
}else{
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
❗️موجودی شما جهت ساخت این سلف کافی نمیباشد
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backself"]],
]])
]);
}
}
if($data == "Make1"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🌐 درحال ساخت سلف . . . !",
'show_alert' =>false
]);
if($coin >= 30){
$connect->query("UPDATE user SET step = 'Make1' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
✔️ جهت ساخت سلف ( 🎯 سلف سرگرمی ) شماره خود را ارسال کنید . . . ! 


⚠️ *توجه* : شماره خود را بصورت صحیح ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backself"]],
]])
]);
}else{
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
❗️موجودی شما جهت ساخت این سلف کافی نمیباشد
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backself"]],
]])
]);
}
}
if($data == "Make2"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🌐 درحال ساخت سلف . . . !",
'show_alert' =>false
]);
if($coin >= 10){
$connect->query("UPDATE user SET step = 'Make2' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
✔️ جهت ساخت سلف ( ⏰ سلف تایم ) شماره خود را ارسال کنید . . . !


⚠️ *توجه* : شماره خود را بصورت صحیح ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backself"]],
]])
]);
}else{
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
❗️موجودی شما جهت ساخت این سلف کافی نمیباشد
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backself"]],
]])
]);
}
}
if($data == "Make3"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🌐 درحال ساخت سلف . . . !",
'show_alert' =>false
]);
if($coin >= 30){
$connect->query("UPDATE user SET step = 'Make3' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
✔️ جهت ساخت سلف ( 🧬 سلف مدیریتی ) شماره خود را ارسال کنید . . . !


⚠️ *توجه* : شماره خود را بصورت صحیح ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backself"]],
]])
]);
}else{
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
❗️موجودی شما جهت ساخت این سلف کافی نمیباشد
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backself"]],
]])
]);
}
}
if($data == "Make4"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🌐 درحال ساخت سلف . . . !",
'show_alert' =>false
]);
if($coin >= 40){
$connect->query("UPDATE user SET step = 'Make4' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
✔️ جهت ساخت سلف ( 💯 سلف اسپم ) شماره خود را ارسال کنید . . . !


⚠️ *توجه* : شماره خود را بصورت صحیح ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backself"]],
]])
]);
}else{
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
❗️موجودی شما جهت ساخت این سلف کافی نمیباشد
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backself"]],
]])
]);
}
}
if($data == "Make5"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🌐 درحال ساخت سلف . . . !",
'show_alert' =>false
]);
if($coin >= 60){
$connect->query("UPDATE user SET step = 'Make5' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
✔️ جهت ساخت سلف ( 🌀 سلف ترکیبی ) شماره خود را ارسال کنید . . . !


⚠️ *توجه* : شماره خود را بصورت صحیح ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backself"]],
]])
]);
}else{
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
❗️موجودی شما جهت ساخت این سلف کافی نمیباشد
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backself"]],
]])
]);
}
}
if($data == "backtabchi"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🔙 درحال بازگشت به منوی ساخت تبچی . . . !",
'show_alert' =>false
]);
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
🔙 به منوی اصلی ساخت تبچی بازگشتید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"💰 قیمت",'callback_data'=>"Price6"],['text'=>"🥇 تبچی نوع اول",'callback_data'=>"Make6"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price7"],['text'=>"🥈 تبچی نوع دوم",'callback_data'=>"Make7"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price8"],['text'=>"🥉 تبچی نوع سوم",'callback_data'=>"Make8"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
]])
]);
exit();
}
if($data == "Make6"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🌐 درحال ساخت تبچی . . . !",
'show_alert' =>false
]);
if($coin >= 60){
$connect->query("UPDATE user SET step = 'Make6' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
✔️ جهت ساخت تبچی ( 🥇 تبچی نوع اول ) شماره خود را ارسال کنید . . . !


⚠️ *توجه* : شماره خود را بصورت صحیح ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backtabchi"]],
]])
]);
}else{
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
❗️موجودی شما جهت ساخت این تبچی کافی نمیباشد
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backtabchi"]],
]])
]);
}
}
if($data == "Make7"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🌐 درحال ساخت تبچی . . . !",
'show_alert' =>false
]);
if($coin >= 50){
$connect->query("UPDATE user SET step = 'Make7' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
✔️ جهت ساخت تبچی ( 🥈 تبچی نوع دوم ) شماره خود را ارسال کنید . . . !


⚠️ *توجه* : شماره خود را بصورت صحیح ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backtabchi"]],
]])
]);
}else{
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
❗️موجودی شما جهت ساخت این تبچی کافی نمیباشد
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backtabchi"]],
]])
]);
}
}
if($data == "Make8"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🌐 درحال ساخت تبچی . . . !",
'show_alert' =>false
]);
if($coin >= 40){
$connect->query("UPDATE user SET step = 'Make8' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
✔️ جهت ساخت تبچی ( 🥉 تبچی نوع سوم ) شماره خود را ارسال کنید . . . !


⚠️ *توجه* : شماره خود را بصورت صحیح ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backtabchi"]],
]])
]);
}else{
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
❗️موجودی شما جهت ساخت این تبچی کافی نمیباشد
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backtabchi"]],
]])
]);
}
}
if($data == "backclicker"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🔙 درحال بازگشت به منوی ساخت کلیکر . . . !",
'show_alert' =>false
]);
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
🔙 به منوی اصلی ساخت کلیکر بازگشتید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"💰 قیمت",'callback_data'=>"Price9"],['text'=>"🔋 کلیکر سرعت ممبر",'callback_data'=>"Make9"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price10"],['text'=>"💎 کلیکر جت ممبر",'callback_data'=>"Make10"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price11"],['text'=>"💣 کلیکر انفجار سکه",'callback_data'=>"Make11"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
]])
]);
exit();
}
if($data == "Make9"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🌐 درحال ساخت کلیکر . . . !",
'show_alert' =>false
]);
if($coin >= 35){
$connect->query("UPDATE user SET step = 'Make9' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
✔️ جهت ساخت کلیکر ( 🔋 کلیکر سرعت ممبر ) شماره خود را ارسال کنید . . . !


⚠️ *توجه* : شماره خود را بصورت صحیح ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backclicker"]],
]])
]);
}else{
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
❗️موجودی شما جهت ساخت این کلیکر کافی نمیباشد
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backclicker"]],
]])
]);
}
}
if($data == "Make10"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🌐 درحال ساخت کلیکر . . . !",
'show_alert' =>false
]);
if($coin >= 30){
$connect->query("UPDATE user SET step = 'Make10' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
✔️ جهت ساخت کلیکر ( 💎 کلیکر جت ممبر ) شماره خود را ارسال کنید . . . !


⚠️ *توجه* : شماره خود را بصورت صحیح ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backclicker"]],
]])
]);
}else{
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
❗️موجودی شما جهت ساخت این کلیکر کافی نمیباشد
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backclicker"]],
]])
]);
}
}
if($data == "Make11"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🌐 درحال ساخت کلیکر . . . !",
'show_alert' =>false
]);
if($coin >= 35){
$connect->query("UPDATE user SET step = 'Make11' WHERE id = '$from_id' LIMIT 1");
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
✔️ جهت ساخت کلیکر ( 💣 کلیکر انفجار سکه ) شماره خود را ارسال کنید . . . !


⚠️ *توجه* : شماره خود را بصورت صحیح ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backclicker"]],
]])
]);
}else{
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
❗️موجودی شما جهت ساخت این کلیکر کافی نمیباشد
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"🔙 بازگشت",'callback_data'=>"backclicker"]],
]])
]);
}
}
if($data == "topzir"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎉 صبر کنید . . . !",
'show_alert' =>false
]);
$code = $connect->query("SELECT * FROM `user` ORDER BY `inv` DESC LIMIT 10");
while($res = mysqli_fetch_assoc($code)){
$i++;
$id = $res['id'];
$member = $res['inv'];
$infoname = bot('getChatMember',['chat_id'=>"$id",'user_id'=>"$id"]);
$yournamer = $infoname->result->user->first_name;
$result = $result."
💰 نفر $i « <a href ='tg://user?id=$id'>$yournamer</a> » 
👥 تعداد زیرمجموعه : $member

┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
";
}
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
👤 برترین های زیر مجموعه گیری : 

$result
👥 تعداد زیر مجموعه های شما : $inv
┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
@$usernamebot
",
'parse_mode'=>'HTML',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"✔️ برترین های زیر مجموعه",'callback_data'=>'topzir']],
[['text'=>"🎈 برترین های ساخت سلف",'callback_data'=>'topself']],
[['text'=>"💎 برترین های ساخت کلیکر",'callback_data'=>'topclicker']],
[['text'=>"🔗 برترین های ساخت تبچی",'callback_data'=>'toptabchi']],
[['text'=>"💰 برترین سکه داران",'callback_data'=>'topcoin']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
]])
]);
}
if($data == "topself"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎉 صبر کنید . . . !",
'show_alert' =>false
]);
$code = $connect->query("SELECT * FROM `user` ORDER BY `self` DESC LIMIT 10");
while($res = mysqli_fetch_assoc($code)){
$i++;
$id = $res['id'];
$member = $res['self'];
$infoname = bot('getChatMember',['chat_id'=>"$id",'user_id'=>"$id"]);
$yournamer = $infoname->result->user->first_name;
$result = $result."
💰 نفر $i « <a href ='tg://user?id=$id'>$yournamer</a> » 
🎈 تعداد سلف : $member

┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
";
}
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
👤 برترین های ساخت سلف : 

$result
🎈 تعداد سلف های شما : $self
┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
@$usernamebot
",
'parse_mode'=>'HTML',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"🎉 برترین های زیر مجموعه",'callback_data'=>'topzir']],
[['text'=>"✔️ برترین های ساخت سلف",'callback_data'=>'topself']],
[['text'=>"💎 برترین های ساخت کلیکر",'callback_data'=>'topclicker']],
[['text'=>"🔗 برترین های ساخت تبچی",'callback_data'=>'toptabchi']],
[['text'=>"💰 برترین سکه داران",'callback_data'=>'topcoin']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
]])
]);
}
if($data == "topclicker"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎉 صبر کنید . . . !",
'show_alert' =>false
]);
$code = $connect->query("SELECT * FROM `user` ORDER BY `clicker` DESC LIMIT 10");
while($res = mysqli_fetch_assoc($code)){
$i++;
$id = $res['id'];
$member = $res['clicker'];
$infoname = bot('getChatMember',['chat_id'=>"$id",'user_id'=>"$id"]);
$yournamer = $infoname->result->user->first_name;
$result = $result."
💰 نفر $i « <a href ='tg://user?id=$id'>$yournamer</a> » 
💎 تعداد کلیکر : $member

┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
";
}
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
👤 برترین های ساخت کلیکر : 

$result
💎 تعداد کلیکر های شما : $clicker
┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
@$usernamebot
",
'parse_mode'=>'HTML',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"🎉 برترین های زیر مجموعه",'callback_data'=>'topzir']],
[['text'=>"🎈 برترین های ساخت سلف",'callback_data'=>'topself']],
[['text'=>"✔️ برترین های ساخت کلیکر",'callback_data'=>'topclicker']],
[['text'=>"🔗 برترین های ساخت تبچی",'callback_data'=>'toptabchi']],
[['text'=>"💰 برترین سکه داران",'callback_data'=>'topcoin']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
]])
]);
}
if($data == "toptabchi"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎉 صبر کنید . . . !",
'show_alert' =>false
]);
$code = $connect->query("SELECT * FROM `user` ORDER BY `tabchi` DESC LIMIT 10");
while($res = mysqli_fetch_assoc($code)){
$i++;
$id = $res['id'];
$member = $res['tabchi'];
$infoname = bot('getChatMember',['chat_id'=>"$id",'user_id'=>"$id"]);
$yournamer = $infoname->result->user->first_name;
$result = $result."
💰 نفر $i « <a href ='tg://user?id=$id'>$yournamer</a> » 
🔗 تعداد تبچی : $member

┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
";
}
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
👤 برترین های ساخت تبچی : 

$result
🔗 تعداد تبچی های شما : $tabchi
┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
@$usernamebot
",
'parse_mode'=>'HTML',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"🎉 برترین های زیر مجموعه",'callback_data'=>'topzir']],
[['text'=>"🎈 برترین های ساخت سلف",'callback_data'=>'topself']],
[['text'=>"💎 برترین های ساخت کلیکر",'callback_data'=>'topclicker']],
[['text'=>"✔️ برترین های ساخت تبچی",'callback_data'=>'toptabchi']],
[['text'=>"💰 برترین سکه داران",'callback_data'=>'topcoin']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
]])
]);
}
if($data == "topcoin"){
bot('answercallbackquery', [
'callback_query_id' =>$user_id,
'text' => "🎉 صبر کنید . . . !",
'show_alert' =>false
]);
$code = $connect->query("SELECT * FROM `user` ORDER BY `coin` DESC LIMIT 10");
while($res = mysqli_fetch_assoc($code)){
$i++;
$id = $res['id'];
$member = $res['coin'];
$infoname = bot('getChatMember',['chat_id'=>"$id",'user_id'=>"$id"]);
$yournamer = $infoname->result->user->first_name;
$result = $result."
💰 نفر $i « <a href ='tg://user?id=$id'>$yournamer</a> » 
💰 تعداد سکه : $member

┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
";
}
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$message_id,
'text'=>"
👤 برترین های سکه داران : 

$result
💰 تعداد سکه های شما : $coin
┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
@$usernamebot
",
'parse_mode'=>'HTML',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"🎉 برترین های زیر مجموعه",'callback_data'=>'topzir']],
[['text'=>"🎈 برترین های ساخت سلف",'callback_data'=>'topself']],
[['text'=>"💎 برترین های ساخت کلیکر",'callback_data'=>'topclicker']],
[['text'=>"🔗 برترین های ساخت تبچی",'callback_data'=>'toptabchi']],
[['text'=>"✔️ برترین سکه داران",'callback_data'=>'topcoin']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
]])
]);
}
/*
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
اسکی میری منبع بزن 🌹
❄️ نوشته شده توسط @TKPHP | تک پسر
✅ اپن شده در @Sourrce_kade | سورس کده
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
*/
//===[ استارت ربات . . . ! ]===//
if(preg_match('/^\/([Ss][Tt][Aa][Rr][Tt])(.*)/',$text,$INV) and $tc == 'private'){
$INV[2] = str_replace(" ","",$INV[2]);
$INV[2] = str_replace("\n","",$INV[2]);
if($INV[2] != null and $INV[2] != $from_id and $setting['id'] == false){
if($joqw != 'member' && $joqw != 'creator' && $joqw != 'administrator' or $joqwe != 'member' && $joqwe != 'creator' && $joqwe != 'administrator' and $tc == 'private'){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"
🔰 سلام به ( $namebot ) خوشـ آمدید 

🔍 جهت استفاده از ربات در کانال های ما عضو شوید ! 
",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text' => "🔐 کانال اول", 'url' => "https://t.me/$channel"],['text' => "🔐 کانال دوم", 'url' => "https://t.me/$channel2"]],
[['text'=>"✅ تأیید عضویت",'callback_data'=>"tayeed$INV[2]"]],
],
])
]);
bot('SendMessage',[
'chat_id'=>$INV[2],
'text'=>"🎉 کاربر *( $from_id )* با لینک شما وارد ربات شده است . . . !",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
}else{
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"🔰 به سلفساز ( $namebot ) خوشـ آمدید 🌹

🎲 با این ربات به راحتی سلف و تبچی بساز با بالاترین سرعت ممکن ! ",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
bot('SendMessage',[
'chat_id'=>$INV[2],
'text'=>"🎉 کاربر *( $from_id )* با لینک شما وارد ربات شده است . . . !",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
$zir = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM user WHERE id = '$INV[2]' LIMIT 1"));
if($zir['type'] == "VIP"){
$ez = $zir['coin'] + 2 ;
$ezz = $zir['inv'] + 1 ;
$connect->query("UPDATE user SET coin = '$ez', inv = '$ezz' WHERE id = '$INV[2]' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$INV[2],
'text'=>"🎈 به حساب شما 2 سکه اضافه شد . . . !",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
}else{
$ez = $zir['coin'] + 1 ;
$ezz = $zir['inv'] + 1 ;
$connect->query("UPDATE user SET coin = '$ez', inv = '$ezz' WHERE id = '$INV[2]' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$INV[2],
'text'=>"🎈 به حساب شما 1 سکه اضافه شد . . . !",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
}
}
if($setting['id'] == false){
$connect->query("INSERT INTO `user` (`id` , `coin` , `inv` , `step` , `warn` , `time` , `date` , `star` , `self` , `tabchi` , `clicker` , `type` , `listself` , `listtabchi` , `listclicker` , `ok` , `phone`) VALUES ('$from_id','0','0','none','0','$time','$date','🌟','0','0','0','free','❗️خالی . . . !','❗️خالی . . . !','❗️خالی . . . !','NO','null')");
}
exit();
}
}
if(preg_match('/^\/([Ss][Tt][Aa][Rr][Tt])(.*)/',$text,$INV) and $tc == 'private'){
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"🔰 به سلفساز ( $namebot ) خوشـ آمدید 🌹

🎲 با این ربات به راحتی سلف و تبچی بساز با بالاترین سرعت ممکن ! ",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
 if($setting['id'] == false){
$connect->query("INSERT INTO `user` (`id` , `coin` , `inv` , `step` , `warn` , `time` , `date` , `star` , `self` , `tabchi` , `clicker` , `type` , `listself` , `listtabchi` , `listclicker` , `ok` , `phone`) VALUES ('$from_id','0','0','none','0','$time','$date','🌟','0','0','0','free','❗️خالی . . . !','❗️خالی . . . !','❗️خالی . . . !','NO','null')");
}
exit();
}   
if($joqw != 'member' && $joqw != 'creator' && $joqw != 'administrator' or $joqwe != 'member' && $joqwe != 'creator' && $joqwe != 'administrator' and $tc == 'private'){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"
🔰 سلام به ( $namebot ) خوشـ آمدید 

🔍 جهت استفاده از ربات در کانال های ما عضو شوید ! 
",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text' => "🔐 کانال اول", 'url' => "https://t.me/$channel"],['text' => "🔐 کانال دوم", 'url' => "https://t.me/$channel2"]],
[['text'=>"✅ تأیید عضویت",'callback_data'=>"tayeed"]],
],
])
]);
exit();
}
if($setting['id'] == false){
$connect->query("INSERT INTO `user` (`id` , `coin` , `inv` , `step` , `warn` , `time` , `date` , `star` , `self` , `tabchi` , `clicker` , `type` , `listself` , `listtabchi` , `listclicker` , `ok` , `phone`) VALUES ('$from_id','0','0','none','0','$time','$date','🌟','0','0','0','free','❗️خالی . . . !','❗️خالی . . . !','❗️خالی . . . !','NO','null')");
}
if(preg_match('/^\/([Pp][Rr][Ii][Cc][Ee])(.*)/',$text,$INV) and $tc == 'private'){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
💰 تعرفه قیمت ساخت ربات CLI :

💫 قیمت سلف هلپدار : `35` سکه

🎯 قیمت سلف سرگرمی : `30` سکه

⏰ قیمت سلف تایم : `10` سکه

🧬 قیمت سلف مدیریتی : `30` سکه

💯 قیمت سلف اسپم : `40` سکه

🌀 قیمت سلف ترکیبی : `60` سکه

🥇 قیمت تبچی نوع اول : `60` سکه

🥈 قیمت تبچی نوع دوم : `50` سکه

🥉 قیمت تبچی نوع سوم : `40` سکه

🔋 قیمت کلیکر سرعت ممبر : `35` سکه

💎 قیمت کلیکر جت ممبر : `30` سکه

💣 قیمت کلیکر انفجار سکه : `35` سکه

┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
@$usernamebot
",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
}
if($text == "🔙 بازگشت"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"🔙 به منوی اصلی بازگشتید . . . !",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
}
if($text == "🔐 حساب کاربری"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"✅ پنل شیشه ای حساب کاربری باز شد با زدن روی هر دکمه میتوانید اطلاعات مربوط به آن دکمه را ببینید . . . !",
'parse_mode'=>'MarkDown',
'reply_markup' => $Account,
]);
}
if($text == "🆘 پشتیبانی" or $text == "/support"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"🆘 به بخش پشتیبانی خوشـ آمدید !",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🆘 پشتیبانی آنلاین",'callback_data'=>"support"]],
[['text' => "🆘 پشتیبانی مستقیم", 'url' => "https://t.me/$support"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
],
])
]);
}
if($step == "Support" and $text != "🔙 بازگشت"){
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
✅ پیام شما با موفقیت برای پشتیبانی ارسال شد !

🔐 اگر پیام دیگری دارید ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => $back,
]);
foreach($dev as $devs){
bot('ForwardMessage',[
'chat_id'=>$devs,
'from_chat_id'=>$from_id,
'message_id'=>$message_id
]);
bot('SendMessage',[
'chat_id'=>$devs,
'text'=>"
ID : `$from_id`

🔰 پی وی کاربر [$first_name](t.me/$user_name) یا [$first_name](tg://openmessage?user_id=$from_id) است 
",
'parse_mode'=>'MarkDown',
]);
}
}
if(in_array($from_id,$dev)){
if($update->message->reply_to_message){
$userid = $update->message->reply_to_message->forward_from->id;
if(mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE `id` = '$userid' LIMIT 1")) == true){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$userid,
'text'=>"
🌹 شما یک پیام از پشتیبانی دارید 

✔️ پیام : `$text`
",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🆘 پیام به پشتیبانی",'callback_data'=>"support"]],
],
])
]);
$infouser = bot('getChatMember',['chat_id'=>"$userid",'user_id'=>"$userid"]);
$nameuser = $infouser->result->user->first_name;
$nameuser = str_replace(['`'],'',"$nameuser");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"✅ با موفقیت پیام شما به کاربر ( `$nameuser` ) ارسال شد",
'parse_mode'=>'MarkDown',
]);
}
}
}
if($text == "🛍 فروشگاه"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
🛍 به فروشگاه ربات سلفساز خوشـ آمدید ! 


🔐 یـکی از گزینه های زیر را جهت افـزایش سکـه انتخاب کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🌐 خرید بصورت آنلاین",'callback_data'=>"cart"]],
[['text'=>"🛍 5 سکه 9,000 نیتروسین",'callback_data'=>"plan1"]],
[['text'=>"🛍 10 سکه 17,500 نیتروسین",'callback_data'=>"plan2"]],
[['text'=>"🛍 20 سکه 26,000 نیتروسین",'callback_data'=>"plan3"]],
[['text'=>"🛍 50 سکه 85,000 نیتروسین",'callback_data'=>"plan4"]],
[['text'=>"🛍 100 سکه 160,000 نیتروسین",'callback_data'=>"plan5"]],
[['text'=>"🛍 250 سکه 400,000 نیتروسین",'callback_data'=>"plan6"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
],
])
]);
}
if($step == "dargah" and $text != "🔙 بازگشت"){
if($text < 1000){
if($text > 10){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$cost = $text * 250;
$random = Random(5);
bot('SendMessage',[
'chat_id'=>$dev[0],
'text'=>"
✅ یک نفر با مشخصات زیر درخواست خرید سکه کرده است !


⚠️ شماره تلفن : `$numberphone`
💤 شناسه کاربری : `$from_id`
💰 مقدار سکه جهت خرید : `$text`
💸 مبلغ خرید این تعداد سکه : `$cost`
",
'parse_mode'=>'MarkDown',
]);
$pay['amount'] = "$cost";
$pay['chatid'] = "$chat_id";
$pay['number'] = "$numberphone";
$outjson = json_encode($pay,true);
file_put_contents("../Pay/shop/$random.txt",$outjson);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
💸 با موفقیت درگاه مقدار `$text` سکه به مبلغ `$cost` تومان ساخته شد ! 

⚠️ جهت پرداخت این تعداد سکه روی دکمه شیشه ای زیر کلیک کرده و سپس پرداخت کنید !

🔖 کد فاکتور : `$random`
",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text' => "💳 پرداخت",'url' => "https://FlashSelf.site/Pay/payment.php?code=$random"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
],
])
]);
}else{
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
⚠️ حداقل تعداد سکه جهت خرید *( 10 )* سکه می‌باشد !
",
'parse_mode'=>'MarkDown',
'reply_markup'=>$back,
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
⚠️ حداکثر تعداد سکه جهت خرید *( 1000 )* سکه می‌باشد !
",
'parse_mode'=>'MarkDown',
'reply_markup'=>$back,
]);
}
}
if($step == "numbers" and $text != "🔙 بازگشت"){
if($update->message->contact->user_id == $from_id){
$phone = $update->message->contact->phone_number;
if(strpos($phone,'98') === 0 || strpos($phone,'+98') === 0){
$phone = '0'.strrev(substr(strrev($phone),0,10));
$connect->query("UPDATE user SET phone = '$phone' WHERE id = '$from_id' LIMIT 1");
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
♻️ درحال پردازش . . . !
",
'parse_mode'=>'MarkDown',
'reply_markup'=>$remove,
]);
bot('SendMessage',[
'chat_id'=>$dev[0],
'text'=>"
✅ یک نفر با مشخصات زیر تایید هویت شماره کرد ! 


⚠️ شماره تلفن : `$phone`
💤 شناسه کاربری : `$from_id`
",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
✅ با موفقیت تایید هویت شما انجام شد ! 


⚠️ شماره ی تایید شده : `$phone`
",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🌐 خرید بصورت آنلاین",'callback_data'=>"cart"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
],
])
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"⚠️ لطفاً با شماره *اکانت ایران* خود تایید هویت کنید ! ",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
}
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"⚠️ لطفاً جهت *تایید هویت* از شماره خود استفاده کنید *نه دیگران* !",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
}
}
if($text == "🎲 ساخت سلف"){
if($ok == "NO" or $ok == "null"){
$connect->query("UPDATE user SET step = 'noko1' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ در صورت ساخت ربات حتما باید قوانین زیر را تایید کنید !


در صورت هر گونه مشکل در ربات خود با پشتیبانی در ارتباط باشید

در صورت افلاین شدن باید وارد بخش تمدید ربات بشوید و ربات خود را تمدید کنید

مسئولیتی در قبال *دیلیتی اکانت* شما نداریم به دلیل *موج های دیلیتی تلگرام* ! 

⚠️  اگر تبچی / سلف / کلیکر شما در موقعه ران کردن با مشکل مواجع شد بخش راهنما را چک کنید

💯 در صورت دیدن هر گونه باگ سریعا به پشتیبانی اطلاع دهید و جایزه دریافت کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'✅ قبول دارم']],
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
😁🌹 نوع سلفی که میخواهید بسازید را انتخاب کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💰 قیمت",'callback_data'=>"PriceHelper"],['text'=>"💫 سلف هلپدار",'callback_data'=>"MakeHelper"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"💰 قیمت",'callback_data'=>"Price1"],['text'=>"🎯 سلف سرگرمی",'callback_data'=>"Make1"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price2"],['text'=>"⏰ سلف تایم",'callback_data'=>"Make2"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price3"],['text'=>"🧬 سلف مدیریتی",'callback_data'=>"Make3"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price4"],['text'=>"💯 سلف اسپم",'callback_data'=>"Make4"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price5"],['text'=>"🌀 سلف ترکیبی",'callback_data'=>"Make5"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
],
])
]);
}
}
if($text == "🔰 ساخت تبچی"){
if($ok == "NO" or $ok == "null"){
$connect->query("UPDATE user SET step = 'noko2' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ در صورت ساخت ربات حتما باید قوانین زیر را تایید کنید !


در صورت هر گونه مشکل در ربات خود با پشتیبانی در ارتباط باشید

در صورت افلاین شدن باید وارد بخش تمدید ربات بشوید و ربات خود را تمدید کنید

مسئولیتی در قبال *دیلیتی اکانت* شما نداریم به دلیل *موج های دیلیتی تلگرام* ! 

⚠️  اگر تبچی / سلف / کلیکر شما در موقعه ران کردن با مشکل مواجع شد بخش راهنما را چک کنید

💯 در صورت دیدن هر گونه باگ سریعا به پشتیبانی اطلاع دهید و جایزه دریافت کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'✅ قبول دارم']],
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
😁🌹 نوع تبچی که میخواهید بسازید را انتخاب کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💰 قیمت",'callback_data'=>"Price6"],['text'=>"🥇 تبچی نوع اول",'callback_data'=>"Make6"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price7"],['text'=>"🥈 تبچی نوع دوم",'callback_data'=>"Make7"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price8"],['text'=>"🥉 تبچی نوع سوم",'callback_data'=>"Make8"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
],
])
]);
}
}
if($text == "🍁 ساخت کلیکر"){
if($ok == "NO" or $ok == "null"){
$connect->query("UPDATE user SET step = 'noko3' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ در صورت ساخت ربات حتما باید قوانین زیر را تایید کنید !


در صورت هر گونه مشکل در ربات خود با پشتیبانی در ارتباط باشید

در صورت افلاین شدن باید وارد بخش تمدید ربات بشوید و ربات خود را تمدید کنید

مسئولیتی در قبال *دیلیتی اکانت* شما نداریم به دلیل *موج های دیلیتی تلگرام* ! 

⚠️  اگر تبچی / سلف / کلیکر شما در موقعه ران کردن با مشکل مواجع شد بخش راهنما را چک کنید

💯 در صورت دیدن هر گونه باگ سریعا به پشتیبانی اطلاع دهید و جایزه دریافت کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'✅ قبول دارم']],
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
😁🌹 نوع کلیکری که میخواهید بسازید را انتخاب کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💰 قیمت",'callback_data'=>"Price9"],['text'=>"🔋 کلیکر سرعت ممبر",'callback_data'=>"Make9"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price10"],['text'=>"💎 کلیکر جت ممبر",'callback_data'=>"Make10"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price11"],['text'=>"💣 کلیکر انفجار سکه",'callback_data'=>"Make11"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
],
])
]);
}
}
if($text == "✅ قبول دارم" and $step == "noko1"){
$connect->query("UPDATE user SET step = 'none', ok = 'ok' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
♻️ درحال پردازش . . . !
",
'parse_mode'=>'MarkDown',
'reply_markup'=>$remove,
]);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
😁🌹 نوع سلفی که میخواهید بسازید را انتخاب کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💰 قیمت",'callback_data'=>"PriceHelper"],['text'=>"💫 سلف هلپدار",'callback_data'=>"MakeHelper"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"💰 قیمت",'callback_data'=>"Price1"],['text'=>"🎯 سلف سرگرمی",'callback_data'=>"Make1"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price2"],['text'=>"⏰ سلف تایم",'callback_data'=>"Make2"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price3"],['text'=>"🧬 سلف مدیریتی",'callback_data'=>"Make3"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price4"],['text'=>"💯 سلف اسپم",'callback_data'=>"Make4"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price5"],['text'=>"🌀 سلف ترکیبی",'callback_data'=>"Make5"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
],
])
]);
}
if($text == "✅ قبول دارم" and $step == "noko2"){
$connect->query("UPDATE user SET step = 'none', ok = 'ok' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
♻️ درحال پردازش . . . !
",
'parse_mode'=>'MarkDown',
'reply_markup'=>$remove,
]);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
😁🌹 نوع تبچی که میخواهید بسازید را انتخاب کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💰 قیمت",'callback_data'=>"Price6"],['text'=>"🥇 تبچی نوع اول",'callback_data'=>"Make6"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price7"],['text'=>"🥈 تبچی نوع دوم",'callback_data'=>"Make7"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price8"],['text'=>"🥉 تبچی نوع سوم",'callback_data'=>"Make8"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
],
])
]);
}
if($text == "✅ قبول دارم" and $step == "noko3"){
$connect->query("UPDATE user SET step = 'none', ok = 'ok' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
♻️ درحال پردازش . . . !
",
'parse_mode'=>'MarkDown',
'reply_markup'=>$remove,
]);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
😁🌹 نوع کلیکری که میخواهید بسازید را انتخاب کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💰 قیمت",'callback_data'=>"Price9"],['text'=>"🔋 کلیکر سرعت ممبر",'callback_data'=>"Make9"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price10"],['text'=>"💎 کلیکر جت ممبر",'callback_data'=>"Make10"]],
[['text'=>"💰 قیمت",'callback_data'=>"Price11"],['text'=>"💣 کلیکر انفجار سکه",'callback_data'=>"Make11"]],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
],
])
]);
}
if($text == "🎁 امتیاز رایگان"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🎈 به بخش دریافت امتیاز رایگان خوشـ آمدید 

🎉 یکی از گزینه های زیر را جهت افزایش سکه رایگانــ انتخاب کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🎁 کد هدیه'],['text'=>'✅ خرید حساب VIP']],
[['text'=>'🎊 زیرمجموعه گیری'],['text'=>'🎉 کد VIP']],
[['text'=>'🔙 بازگشت']],
]])
]);
}
if($text == "✅ خرید حساب VIP"){
if($type == "free"){
$connect->query("UPDATE user SET step = 'byevip' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ جهت خرید حساب VIP تعداد `50` سکه از حساب شما کم میشود ! 


🔰 مزایای حساب ویژه در سلف ساز فلش بسیار زیاد هستند و با حساب ویژه می‌توانید به تمام قسمت های ربات دسترسی پیدا کنید ! 



♻️ جهت خرید حساب ویژه روی ( ✅ قبول دارم ) کلیک کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'✅ قبول دارم']],
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🎈 حساب شما از قبل ( VIP ) می‌باشد !
",
'parse_mode'=>'MarkDown',
]);
}
}
if($text == "✅ قبول دارم" and $step == "byevip"){
if($coin > 50){
$ez = $coin - 50 ;
$connect->query("UPDATE user SET coin = '$ez' , step = 'none' , type = 'VIP' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🛍 با موفقیت حساب VIP خریداری شد ! 


🎈 مقدار 50 سکه از حساب شما کسر شد !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"⚠️ جهت خرید حساب VIP باید حداقل `50` سکه داشته باشید در حساب خود !",
'parse_mode'=>'MarkDown',
]);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"🔙 به منوی اصلی بازگشتید . . . !",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
}
}
if($text == "🎊 زیرمجموعه گیری"){
$id = bot('SendVideo',[
'chat_id' =>$from_id,
'video' =>"https://t.me/FlashSelf/32",
'caption' =>"
🎲 با سلف ساز ( فلش سلف ) بهترین سلف ها رو بساز ! 


🚀 سرعت بالا 
🥀 کاربردی 
🔐 امنیت بالا 
🔰 دریافت امتیاز رایگان بصورت روزانه ! 


🔗 همین الان وارد ربات شو !

https://t.me/$usernamebot?start=$from_id
",
'parse_mode' => 'MarkDown'
])->result->message_id;
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
💯 با دعوت هر فرد به ربات سلف ساز ( فلش سلف ) - 1 سکه به ازای هر نفر که وارد ربات شود و تایید عضویت کند به حساب شما افزوده میشود ! 
",
'reply_to_message_id'=>$id,
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🎁 کد هدیه'],['text'=>'✅ خرید حساب VIP']],
[['text'=>'🎊 زیرمجموعه گیری'],['text'=>'🎉 کد VIP']],
[['text'=>'🔙 بازگشت']],
]])
]);
}
if($text == "🏆 برترین ها"){
$code = $connect->query("SELECT * FROM `user` ORDER BY `inv` DESC LIMIT 10");
while($res = mysqli_fetch_assoc($code)){
$i++;
$id = $res['id'];
$member = $res['inv'];
$infoname = bot('getChatMember',['chat_id'=>"$id",'user_id'=>"$id"]);
$yournamer = $infoname->result->user->first_name;
$result = $result."
💰 نفر $i « <a href ='tg://user?id=$id'>$yournamer</a> » 
👥 تعداد زیرمجموعه : $member

┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
";
}
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
👤 برترین های زیر مجموعه گیری : 

$result
👥 تعداد زیر مجموعه های شما : $inv
┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
@$usernamebot
",
'parse_mode'=>'HTML',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"✔️ برترین های زیر مجموعه",'callback_data'=>'topzir']],
[['text'=>"🎈 برترین های ساخت سلف",'callback_data'=>'topself']],
[['text'=>"💎 برترین های ساخت کلیکر",'callback_data'=>'topclicker']],
[['text'=>"🔗 برترین های ساخت تبچی",'callback_data'=>'toptabchi']],
[['text'=>"💰 برترین سکه داران",'callback_data'=>'topcoin']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
],
])
]);
}
if($text == "🎉 کد VIP"){
if($type == "free"){
$connect->query("UPDATE user SET step = 'VIP' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
💤 کد ( VIP ) ساخته شده توسط ادمین ها را ارسال کنید !

⚠️ اگر کد ارسال شده درست باشد حساب شما ( VIP ) میشود ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🎈 حساب شما از قبل ( VIP ) می‌باشد !
",
'parse_mode'=>'MarkDown',
]);
}
}
if($step == "VIP" and $text != "🔙 بازگشت"){
if(file_exists("vip.txt")){
$code = file_get_contents("vip.txt");
if($code == "$text"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$connect->query("UPDATE user SET type = 'VIP' WHERE id = '$from_id' LIMIT 1");
unlink("vip.txt");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🥀 کد ( VIP ) درست بود و حساب شما ویژه شد ! 
",
'parse_mode'=>'MarkDown',
]);
bot('SendMessage',[
'chat_id'=>"@$channel",
'text'=>"
🎉 کد VIP <b>( $text )</b> توسط کاربر زیر استفاده شد !

📑 نام : <a href ='tg://user?id=$chat_id'>$first_name $last_name</a>
🆔 یوزرنیم : @$user_name
✅ ایدی عددی : $from_id
💰 تعداد سکه های کاربر : $coin
📆 تاریخ : $date
⏰ ساعت : $time

┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
@$usernamebot
",
'parse_mode'=>'HTML',
]);
bot('SendMessage',[
'chat_id'=>"@$channel2",
'text'=>"
🎉 کد VIP <b>( $text )</b> توسط کاربر زیر استفاده شد !

📑 نام : <a href ='tg://user?id=$chat_id'>$first_name $last_name</a>
🆔 یوزرنیم : @$user_name
✅ ایدی عددی : $from_id
💰 تعداد سکه های کاربر : $coin
📆 تاریخ : $date
⏰ ساعت : $time

┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
@$usernamebot
",
'parse_mode'=>'HTML',
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کد ( $text ) صحیح نمیباشد ! مجدد تلاش کنید !
",
'parse_mode'=>'MarkDown',
]);
}
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کد ویژه ای ساخته نشده است !
",
'parse_mode'=>'MarkDown',
]);
}
}
if($text == "🎁 کد هدیه"){
$connect->query("UPDATE user SET step = 'GIFTCODE' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🎁 کد هدیه ساخته شده توسط ادمین ها را ارسال کنید !

⚠️ اگر کد ارسال شده درست باشد به حساب شما سکه تعیین شده اضافه میشود !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
if($step == "GIFTCODE" and $text != "🔙 بازگشت"){
$info = file_get_contents("gift.txt");
$like = explode("~","$info");
$code = $like[0];
$giftcoin = $like[1];
if($code == "$text"){
unlink("gift.txt");
$ez = $coin + $giftcoin ;
$connect->query("UPDATE user SET coin = '$ez', step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🥀 کد *( $text )* درست بود ! 
🥳 به حساب شما مقدار `$giftcoin` سکه اضافه شد
",
'parse_mode'=>'MarkDown',
]);
bot('SendMessage',[
'chat_id'=>"@$channel",
'text'=>"
🎉 کد هدیه <b>( $text )</b> توسط کاربر زیر استفاده شد !

📑 نام : <a href ='tg://user?id=$chat_id'>$first_name $last_name</a>
🆔 یوزرنیم : @$user_name
✅ ایدی عددی : $from_id
💰 تعداد سکه های کاربر : $coin
🎊 تعداد سکه کد هدیه : $giftcoin
📆 تاریخ : $date
⏰ ساعت : $time

┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
@$usernamebot
",
'parse_mode'=>'HTML',
]);
bot('SendMessage',[
'chat_id'=>"@$channel2",
'text'=>"
🎉 کد هدیه <b>( $text )</b> توسط کاربر زیر استفاده شد !

📑 نام : <a href ='tg://user?id=$chat_id'>$first_name $last_name</a>
🆔 یوزرنیم : @$user_name
✅ ایدی عددی : $from_id
💰 تعداد سکه های کاربر : $coin
🎊 تعداد سکه کد هدیه : $giftcoin
📆 تاریخ : $date
⏰ ساعت : $time

┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄┄┅┈┉┅┉┈┅┄
@$usernamebot
",
'parse_mode'=>'HTML',
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کد ( $text ) وجود ندارد و یا توسط شخص دیگری مورد استفاده قرار گرفته است ! 
",
'parse_mode'=>'MarkDown',
]);
}
}
if($text == "💸 انتقال سکه"){
if($coin > 20){
$connect->query("UPDATE user SET step = 'sendcoin' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
💰 مقدار سکه جهت انتقال را وارد کنید ! 

⚠️ موجودی حساب شما : `$coin`
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ جهت انتقال موجودی حداقل باید `20` سکه در حسابتان باشد ! 
",
'parse_mode'=>'MarkDown',
]);
}
}
if($step == "sendcoin" and $text != "🔙 بازگشت"){
$text = str_replace(["#","`","*","_","[","]","-","+","(",")","'"],[""],$text);
if(is_numeric($text)){
if($text > 20 ){
if($coin >= $text){
$connect->query("UPDATE user SET step = 'sendid-$text' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⭕️ عملیات انتقال سکه غیر قابل بازگشت است 

♻️ درصورت تایید درخواست انتقال `$text` سکه شناسه کاربری مقصد را ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ مقدار سکه درخواستی شما جهت انتقال از موجودی شما بیشتر است
",
'parse_mode'=>'MarkDown',
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ حداقل سکه جهت انتقال `20` سکه است
",
'parse_mode'=>'MarkDown',
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ لطفاً فقط عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
]);
}
}
elseif(strpos($step,'sendid-') !== false and $text != "🔙 بازگشت"){
$ez = explode("-",$step);
$text = str_replace(["#","`","*","_","[","]","-","+","(",")","'"],[""],$text);
if(mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE `id` = '$text' LIMIT 1")) == true){
$new = $coin - $ez[1] ;
$connect->query("UPDATE user SET coin = '$new' , step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"`✅ تعداد $ez[1] سکه در تاریخ $date ساعت $time با موفقیت به کاربر $text انتقال داده شد`",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
$info = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM user WHERE id = '$text' LIMIT 1"));
$ads = $info['coin'] + $ez[1] ;
$connect->query("UPDATE user SET coin = '$ads' WHERE id = '$text' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$text,
'text'=>"`✅ تعداد $ez[1] سکه در تاریخ $date ساعت $time با موفقیت از کاربر $from_id دریافت شد`",
'parse_mode'=>'MarkDown',
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"⚠️ ای دی عددی شخصی که ارسال کردید در ربات نمی‌باشد !",
'parse_mode'=>'MarkDown',
'reply_markup' => $button,
]);
}
}
if($text == "📚 راهنما"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
📚 راهنمای سلف ساز فلش : 


📕 جهت ساخت سلف / کلیکر / تبچی روی دکمه های شیشه ای مربوطه کلیک کنید سپس شماره تلفن اکانتی که میخواهید روی آن ربات را نصب کنید ارسال کنید . . . 

📗 سپس کد به شماره ای که وارد کرده اید ارسال میشود 

📘 کد را برای ربات ارسال کنید ! 

📙 و در آخر تمام ! ربات ( سلف / تبچی / کلیکر ) بر روی اکانت شما فعال میشود ! 


📂 در صورت بیرون انداختن ربات از اکانت خود ربات خاموش میشود و دیگر قابل استفاده نمی‌باشد 


🖇 برای تمدید کردن ربات های خود به بخش تمدید رفته و ربات خود را تمدید کنید !


💯 جهت ساخت بعضی از سلف ها / کلیکر ها / تبچی ها نیاز به حساب VIP است که میتوانید خریداری کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
],
])
]);
}
if($text == "⚖ قوانین"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
⚖ قوانین مهم ربات سلف ساز فلش :


⚠️ مسئولیتی در قبال دیلیت اکانت شدن اکانت هایی که کلیکر و سلف و تبچی ساختید با آنها نداریم به دلیل موج های دیلیتی تلگرام شاید اکانت شما هم حذف شود ! 


⚠️ ربات بصورت رایگان می‌باشد پس گول افراد سو جو را نخورید ! 

⚠️ فقط میتوانید بصورت مطمئن و امن از پشتیبانی خود ربات سکه خریداری کنید ! 


⚠️ در صورت افـ شدن سلف یا کلیکر یا تبچی خود به پشتیبانی مراجعه کنید !
🔰 ( در صورتی که تمدید ربات شما تمام نشده باشد ) 


⚠️  در صورت بیرون انداختن رباتی که بر روی اکانت شما نصب شده است مسئولیتی نداریم و سکه شما بازگشت داده نمیشود ! 

⚠️ درصورت دیدن هر گونه باگ و یا مشکل در ربات به پشتیبانی مراجعه کنید 
",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
[['text'=>"$date",'callback_data'=>'fake'],['text'=>'📆 تاریخ ◄','callback_data'=>'fake']],
[['text'=>"$time",'callback_data'=>'fake'],['text'=>'⏰ ساعت ◄','callback_data'=>'fake']],
[['text'=>"•=•=•=•=•=•=•=•=•=•=•=•=•=•=•=•",'callback_data'=>'fake']],
],
])
]);
}
if($step == "MakeHelper" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
$connect->query("UPDATE user SET step = 'CodHelper-$test' WHERE id = '$from_id' LIMIT 1");
$Phone = preg_replace('![^\d]*!','',$text);
if(!is_dir('../Helper/self')){
mkdir('../Helper/self');
}
mkdir("../Helper/self/$Phone");
$index = file_get_contents("../Helper/source/index.php");
$index = str_replace("[*[API_HASH]*]",$api_hash,$index);
$index = str_replace("[*[API_ID]*]",$api_id,$index);
$index = str_replace("[*[ADMIN]*]",$from_id,$index);
file_put_contents("../Helper/self/$Phone/index.php",$index);
$jdf = file_get_contents("../Helper/source/jdf.php");
file_put_contents("../Helper/self/$Phone/jdf.php",$jdf);
if(!file_exists("../Helper/self/$Phone/eshtrak.txt")){
file_put_contents("../Helper/self/$Phone/eshtrak.txt","1");
}
file_get_contents("https://FlashSelf.site/Helper/self/$Phone/index.php");
$Auto = file_get_contents("https://FlashSelf.site/Helper/AutoSelf.php?phone=$text&code=0");
if($Auto == 'Ban'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ این شماره از تلگرام مسدود شده است !",
]);
exit();
}
if($Auto == 'Phone invalid'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ شماره ارسال شده معتبر نمی‌باشد !",
]);
exit();
}
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کد تلگرام به شماره ( `$text` ) ارسال شد 


💤 کد را برای ربات ارسال کنید . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
exit();
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "Make1" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
$connect->query("UPDATE user SET step = 'cod1-$test' WHERE id = '$from_id' LIMIT 1");
$Phone = preg_replace('![^\d]*!','',$text);
if(!is_dir('bot')){
mkdir('bot');
}
if(!is_dir('bot/self')){
mkdir('bot/self');
}
mkdir("bot/self/$Phone");
$index = file_get_contents("source/self1/index.php");
$index = str_replace("[*[API_HASH]*]",$api_hash,$index);
$index = str_replace("[*[API_ID]*]",$api_id,$index);
$index = str_replace("[*[ADMIN]*]",$from_id,$index);
file_put_contents("bot/self/$Phone/index.php",$index);
if(!file_exists("bot/self/$Phone/eshtrak.txt")){
file_put_contents("bot/self/$Phone/eshtrak.txt","1");
}
file_get_contents("$domain/bot/self/$Phone/index.php");
$Auto = file_get_contents("$domain/Auto1.php?phone=$text&code=0");
if($Auto == 'Ban'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ این شماره از تلگرام مسدود شده است !",
]);
exit();
}
if($Auto == 'Phone invalid'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ شماره ارسال شده معتبر نمی‌باشد !",
]);
exit();
}
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کد تلگرام به شماره ( `$text` ) ارسال شد 


💤 کد را برای ربات ارسال کنید . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
exit();
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "Make2" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
$connect->query("UPDATE user SET step = 'cod2-$test' WHERE id = '$from_id' LIMIT 1");
$Phone = preg_replace('![^\d]*!','',$text);
if(!is_dir('bot')){
mkdir('bot');
}
if(!is_dir('bot/self')){
mkdir('bot/self');
}
mkdir("bot/self/$Phone");
$index = file_get_contents("source/self2/index.php");
$index = str_replace("[*[API_HASH]*]",$api_hash,$index);
$index = str_replace("[*[API_ID]*]",$api_id,$index);
$index = str_replace("[*[ADMIN]*]",$from_id,$index);
file_put_contents("bot/self/$Phone/index.php",$index);
if(!file_exists("bot/self/$Phone/eshtrak.txt")){
file_put_contents("bot/self/$Phone/eshtrak.txt","1");
}
file_get_contents("$domain/bot/self/$Phone/index.php");
$Auto = file_get_contents("$domain/Auto1.php?phone=$text&code=0");
if($Auto == 'Ban'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ این شماره از تلگرام مسدود شده است !",
]);
exit();
}
if($Auto == 'Phone invalid'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ شماره ارسال شده معتبر نمی‌باشد !",
]);
exit();
}
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کد تلگرام به شماره ( `$text` ) ارسال شد 


💤 کد را برای ربات ارسال کنید . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
exit();
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "Make3" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
$connect->query("UPDATE user SET step = 'cod3-$test' WHERE id = '$from_id' LIMIT 1");
$Phone = preg_replace('![^\d]*!','',$text);
if(!is_dir('bot')){
mkdir('bot');
}
if(!is_dir('bot/self')){
mkdir('bot/self');
}
mkdir("bot/self/$Phone");
$index = file_get_contents("source/self3/index.php");
$index = str_replace("[*[API_HASH]*]",$api_hash,$index);
$index = str_replace("[*[API_ID]*]",$api_id,$index);
$index = str_replace("[*[ADMIN]*]",$from_id,$index);
file_put_contents("bot/self/$Phone/index.php",$index);
if(!file_exists("bot/self/$Phone/eshtrak.txt")){
file_put_contents("bot/self/$Phone/eshtrak.txt","1");
}
file_get_contents("$domain/bot/self/$Phone/index.php");
$Auto = file_get_contents("$domain/Auto1.php?phone=$text&code=0");
if($Auto == 'Ban'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ این شماره از تلگرام مسدود شده است !",
]);
exit();
}
if($Auto == 'Phone invalid'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ شماره ارسال شده معتبر نمی‌باشد !",
]);
exit();
}
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کد تلگرام به شماره ( `$text` ) ارسال شد 


💤 کد را برای ربات ارسال کنید . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
exit();
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "Make4" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
$connect->query("UPDATE user SET step = 'cod4-$test' WHERE id = '$from_id' LIMIT 1");
$Phone = preg_replace('![^\d]*!','',$text);
if(!is_dir('bot')){
mkdir('bot');
}
if(!is_dir('bot/self')){
mkdir('bot/self');
}
mkdir("bot/self/$Phone");
$index = file_get_contents("source/self4/index.php");
$index = str_replace("[*[API_HASH]*]",$api_hash,$index);
$index = str_replace("[*[API_ID]*]",$api_id,$index);
$index = str_replace("[*[ADMIN]*]",$from_id,$index);
file_put_contents("bot/self/$Phone/index.php",$index);
if(!file_exists("bot/self/$Phone/eshtrak.txt")){
file_put_contents("bot/self/$Phone/eshtrak.txt","1");
}
file_get_contents("$domain/bot/self/$Phone/index.php");
$Auto = file_get_contents("$domain/Auto1.php?phone=$text&code=0");
if($Auto == 'Ban'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ این شماره از تلگرام مسدود شده است !",
]);
exit();
}
if($Auto == 'Phone invalid'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ شماره ارسال شده معتبر نمی‌باشد !",
]);
exit();
}
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کد تلگرام به شماره ( `$text` ) ارسال شد 


💤 کد را برای ربات ارسال کنید . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
exit();
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "Make5" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
$connect->query("UPDATE user SET step = 'cod5-$test' WHERE id = '$from_id' LIMIT 1");
$Phone = preg_replace('![^\d]*!','',$text);
if(!is_dir('bot')){
mkdir('bot');
}
if(!is_dir('bot/self')){
mkdir('bot/self');
}
mkdir("bot/self/$Phone");
$index = file_get_contents("source/self5/index.php");
$index = str_replace("[*[API_HASH]*]",$api_hash,$index);
$index = str_replace("[*[API_ID]*]",$api_id,$index);
$index = str_replace("[*[ADMIN]*]",$from_id,$index);
file_put_contents("bot/self/$Phone/index.php",$index);
if(!file_exists("bot/self/$Phone/eshtrak.txt")){
file_put_contents("bot/self/$Phone/eshtrak.txt","1");
}
$jdf = file_get_contents("source/self5/jdf.php");
file_put_contents("bot/self/$Phone/jdf.php",$jdf);
file_get_contents("$domain/bot/self/$Phone/index.php");
$Auto = file_get_contents("$domain/Auto1.php?phone=$text&code=0");
if($Auto == 'Ban'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ این شماره از تلگرام مسدود شده است !",
]);
exit();
}
if($Auto == 'Phone invalid'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ شماره ارسال شده معتبر نمی‌باشد !",
]);
exit();
}
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کد تلگرام به شماره ( `$text` ) ارسال شد 


💤 کد را برای ربات ارسال کنید . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
exit();
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "Make6" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
$connect->query("UPDATE user SET step = 'cod6-$test' WHERE id = '$from_id' LIMIT 1");
$Phone = preg_replace('![^\d]*!','',$text);
if(!is_dir('bot')){
mkdir('bot');
}
if(!is_dir('bot/tabchi')){
mkdir('bot/tabchi');
}
mkdir("bot/tabchi/$Phone");
$index = file_get_contents("source/tabchi1/index.php");
$index = str_replace("[*[API_HASH]*]",$api_hash,$index);
$index = str_replace("[*[API_ID]*]",$api_id,$index);
$index = str_replace("[*[ADMIN]*]",$from_id,$index);
file_put_contents("bot/tabchi/$Phone/index.php",$index);
if(!file_exists("bot/tabchi/$Phone/eshtrak.txt")){
file_put_contents("bot/tabchi/$Phone/eshtrak.txt","1");
}
file_get_contents("$domain/bot/tabchi/$Phone/index.php");
$Auto = file_get_contents("$domain/Auto2.php?phone=$text&code=0");
if($Auto == 'Ban'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ این شماره از تلگرام مسدود شده است !",
]);
exit();
}
if($Auto == 'Phone invalid'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ شماره ارسال شده معتبر نمی‌باشد !",
]);
exit();
}
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کد تلگرام به شماره ( `$text` ) ارسال شد 


💤 کد را برای ربات ارسال کنید . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
exit();
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "Make7" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
$connect->query("UPDATE user SET step = 'cod7-$test' WHERE id = '$from_id' LIMIT 1");
$Phone = preg_replace('![^\d]*!','',$text);
if(!is_dir('bot')){
mkdir('bot');
}
if(!is_dir('bot/tabchi')){
mkdir('bot/tabchi');
}
mkdir("bot/tabchi/$Phone");
$index = file_get_contents("source/tabchi2/index.php");
$index = str_replace("[*[API_HASH]*]",$api_hash,$index);
$index = str_replace("[*[API_ID]*]",$api_id,$index);
$index = str_replace("[*[ADMIN]*]",$from_id,$index);
file_put_contents("bot/tabchi/$Phone/index.php",$index);
if(!file_exists("bot/tabchi/$Phone/eshtrak.txt")){
file_put_contents("bot/tabchi/$Phone/eshtrak.txt","1");
}
file_get_contents("$domain/bot/tabchi/$Phone/index.php");
$Auto = file_get_contents("$domain/Auto2.php?phone=$text&code=0");
if($Auto == 'Ban'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ این شماره از تلگرام مسدود شده است !",
]);
exit();
}
if($Auto == 'Phone invalid'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ شماره ارسال شده معتبر نمی‌باشد !",
]);
exit();
}
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کد تلگرام به شماره ( `$text` ) ارسال شد 


💤 کد را برای ربات ارسال کنید . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
exit();
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "Make8" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
$connect->query("UPDATE user SET step = 'cod8-$test' WHERE id = '$from_id' LIMIT 1");
$Phone = preg_replace('![^\d]*!','',$text);
if(!is_dir('bot')){
mkdir('bot');
}
if(!is_dir('bot/tabchi')){
mkdir('bot/tabchi');
}
mkdir("bot/tabchi/$Phone");
$index = file_get_contents("source/tabchi3/index.php");
$index = str_replace("[*[API_HASH]*]",$api_hash,$index);
$index = str_replace("[*[API_ID]*]",$api_id,$index);
$index = str_replace("[*[ADMIN]*]",$from_id,$index);
file_put_contents("bot/tabchi/$Phone/index.php",$index);
if(!file_exists("bot/tabchi/$Phone/eshtrak.txt")){
file_put_contents("bot/tabchi/$Phone/eshtrak.txt","1");
}
file_get_contents("$domain/bot/tabchi/$Phone/index.php");
$Auto = file_get_contents("$domain/Auto2.php?phone=$text&code=0");
if($Auto == 'Ban'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ این شماره از تلگرام مسدود شده است !",
]);
exit();
}
if($Auto == 'Phone invalid'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ شماره ارسال شده معتبر نمی‌باشد !",
]);
exit();
}
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کد تلگرام به شماره ( `$text` ) ارسال شد 


💤 کد را برای ربات ارسال کنید . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
exit();
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "Make9" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
$connect->query("UPDATE user SET step = 'cod9-$test' WHERE id = '$from_id' LIMIT 1");
$Phone = preg_replace('![^\d]*!','',$text);
if(!is_dir('bot')){
mkdir('bot');
}
if(!is_dir('bot/clicker')){
mkdir('bot/clicker');
}
mkdir("bot/clicker/$Phone");
$index = file_get_contents("source/clicker1/index.php");
$index = str_replace("[*[API_HASH]*]",$api_hash,$index);
$index = str_replace("[*[API_ID]*]",$api_id,$index);
$index = str_replace("[*[ADMIN]*]",$from_id,$index);
file_put_contents("bot/clicker/$Phone/index.php",$index);
if(!file_exists("bot/clicker/$Phone/eshtrak.txt")){
file_put_contents("bot/clicker/$Phone/eshtrak.txt","1");
}
file_get_contents("$domain/bot/clicker/$Phone/index.php");
$Auto = file_get_contents("$domain/Auto3.php?phone=$text&code=0");
if($Auto == 'Ban'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ این شماره از تلگرام مسدود شده است !",
]);
exit();
}
if($Auto == 'Phone invalid'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ شماره ارسال شده معتبر نمی‌باشد !",
]);
exit();
}
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کد تلگرام به شماره ( `$text` ) ارسال شد 


💤 کد را برای ربات ارسال کنید . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
exit();
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "Make10" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
$connect->query("UPDATE user SET step = 'cod10-$test' WHERE id = '$from_id' LIMIT 1");
$Phone = preg_replace('![^\d]*!','',$text);
if(!is_dir('bot')){
mkdir('bot');
}
if(!is_dir('bot/clicker')){
mkdir('bot/clicker');
}
mkdir("bot/clicker/$Phone");
$index = file_get_contents("source/clicker2/index.php");
$index = str_replace("[*[API_HASH]*]",$api_hash,$index);
$index = str_replace("[*[API_ID]*]",$api_id,$index);
$index = str_replace("[*[ADMIN]*]",$from_id,$index);
file_put_contents("bot/clicker/$Phone/index.php",$index);
if(!file_exists("bot/clicker/$Phone/eshtrak.txt")){
file_put_contents("bot/clicker/$Phone/eshtrak.txt","1");
}
file_get_contents("$domain/bot/clicker/$Phone/index.php");
$Auto = file_get_contents("$domain/Auto3.php?phone=$text&code=0");
if($Auto == 'Ban'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ این شماره از تلگرام مسدود شده است !",
]);
exit();
}
if($Auto == 'Phone invalid'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ شماره ارسال شده معتبر نمی‌باشد !",
]);
exit();
}
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کد تلگرام به شماره ( `$text` ) ارسال شد 


💤 کد را برای ربات ارسال کنید . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
exit();
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "Make11" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
$connect->query("UPDATE user SET step = 'cod11-$test' WHERE id = '$from_id' LIMIT 1");
$Phone = preg_replace('![^\d]*!','',$text);
if(!is_dir('bot')){
mkdir('bot');
}
if(!is_dir('bot/clicker')){
mkdir('bot/clicker');
}
mkdir("bot/clicker/$Phone");
$index = file_get_contents("source/clicker3/index.php");
$index = str_replace("[*[API_HASH]*]",$api_hash,$index);
$index = str_replace("[*[API_ID]*]",$api_id,$index);
$index = str_replace("[*[ADMIN]*]",$from_id,$index);
file_put_contents("bot/clicker/$Phone/index.php",$index);
if(!file_exists("bot/clicker/$Phone/eshtrak.txt")){
file_put_contents("bot/clicker/$Phone/eshtrak.txt","1");
}
file_get_contents("$domain/bot/clicker/$Phone/index.php");
$Auto = file_get_contents("$domain/Auto3.php?phone=$text&code=0");
if($Auto == 'Ban'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ این شماره از تلگرام مسدود شده است !",
]);
exit();
}
if($Auto == 'Phone invalid'){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❌ شماره ارسال شده معتبر نمی‌باشد !",
]);
exit();
}
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کد تلگرام به شماره ( `$text` ) ارسال شد 


💤 کد را برای ربات ارسال کنید . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
exit();
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if(strpos($step,'CodHelper-') !== false and $text != "🔙 بازگشت"){
$phonenumber = explode("-",$step)[1];
$text = str_replace(["#","`","*","_","[","]","-","+","(",")","'"],[""],$text);
if(is_numeric($text)){
if(strlen($text) == "5"){
$Auto = file_get_contents("https://FlashSelf.site/Helper/AutoSelf.php?phone=$phonenumber&code=$text");
if($Auto == "two-factor"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❗️اکانت شما دارای تایید دو مرحله ای است لطفاً تایید دو مرحله را بردارید و مجدد تلاش کنید !",
]);
exit();
}
if($Auto == "Error"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
exit();
}
if($Auto == "OK"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$newself = $self + 1 ;
$connect->query("UPDATE user SET self = '$newself' WHERE id = '$from_id' LIMIT 1");
if($listself != "❗️خالی . . . !"){
$newLself = "$listself\n⟩••• +$phonenumber";
$connect->query("UPDATE user SET listself = '$newLself' WHERE id = '$from_id' LIMIT 1");
}else{
$newLself = "⟩••• +$phonenumber";
$connect->query("UPDATE user SET listself = '$newLself' WHERE id = '$from_id' LIMIT 1");
}
file_put_contents("../Helper/self/$phonenumber/admin.txt","$from_id");
file_put_contents("../Helper/self/$phonenumber/eshtrak.txt","30");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات بر روی اکانت ( `+$phonenumber` ) فعال شد ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
$get = file_get_contents("$domain/AutoCron.php?url=https://FlashSelf.site/Helper/self/$phonenumber/index.php&time=1&phone=$phonenumber");
$two = file_get_contents("$domain/AutoCron.php?url=https://FlashSelf.site/Helper/self/$phonenumber/index.php&time=1&phone=$phonenumber");
$cron = json_decode($get,true)["ok"];
$crons = json_decode($two,true)["ok"];
if($cron == "true" and $crons == "true"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کرونجاب خودکار با موفقیت تنظیم شد !
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کرونجاب با موفقیت فعال نشد لطفاً به پشتیبانی مراجعه کنید !
",
'parse_mode'=>'MarkDown',
]);
}
$newcoin = $coin - 35 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 لطفاً کد 5 رقمی که از سمت تلگرام ارسال شده است را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔢 لطفاً کد ارسال شده به اکانت خود را بصورت عدد برای ربات ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if(strpos($step,'cod1-') !== false and $text != "🔙 بازگشت"){
$phonenumber = explode("-",$step)[1];
$text = str_replace(["#","`","*","_","[","]","-","+","(",")","'"],[""],$text);
if(is_numeric($text)){
if(strlen($text) == "5"){
$Auto = file_get_contents("$domain/Auto1.php?phone=$phonenumber&code=$text");
if($Auto == "two-factor"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❗️اکانت شما دارای تایید دو مرحله ای است لطفاً تایید دو مرحله را بردارید و مجدد تلاش کنید !",
]);
exit();
}
if($Auto == "Error"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
exit();
}
if($Auto == "OK"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$newself = $self + 1 ;
$connect->query("UPDATE user SET self = '$newself' WHERE id = '$from_id' LIMIT 1");
if($listself != "❗️خالی . . . !"){
$newLself = "$listself\n⟩••• +$phonenumber";
$connect->query("UPDATE user SET listself = '$newLself' WHERE id = '$from_id' LIMIT 1");
}else{
$newLself = "⟩••• +$phonenumber";
$connect->query("UPDATE user SET listself = '$newLself' WHERE id = '$from_id' LIMIT 1");
}
file_put_contents("bot/self/$phonenumber/admin.txt","$from_id");
file_put_contents("bot/self/$phonenumber/eshtrak.txt","30");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات بر روی اکانت ( `+$phonenumber` ) فعال شد ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
$get = file_get_contents("$domain/AutoCron.php?url=$domain/bot/self/$phonenumber/index.php&time=1&phone=$phonenumber");
$two = file_get_contents("$domain/AutoCron.php?url=$domain/bot/self/$phonenumber/index.php&time=1&phone=$phonenumber");
$cron = json_decode($get,true)["ok"];
$crons = json_decode($two,true)["ok"];
if($cron == "true" and $crons == "true"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کرونجاب خودکار با موفقیت تنظیم شد !
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کرونجاب با موفقیت فعال نشد لطفاً به پشتیبانی مراجعه کنید !
",
'parse_mode'=>'MarkDown',
]);
}
$newcoin = $coin - 30 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 لطفاً کد 5 رقمی که از سمت تلگرام ارسال شده است را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔢 لطفاً کد ارسال شده به اکانت خود را بصورت عدد برای ربات ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if(strpos($step,'cod2-') !== false and $text != "🔙 بازگشت"){
$phonenumber = explode("-",$step)[1];
$text = str_replace(["#","`","*","_","[","]","-","+","(",")","'"],[""],$text);
if(is_numeric($text)){
if(strlen($text) == "5"){
$Auto = file_get_contents("$domain/Auto1.php?phone=$phonenumber&code=$text");
if($Auto == "two-factor"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❗️اکانت شما دارای تایید دو مرحله ای است لطفاً تایید دو مرحله را بردارید و مجدد تلاش کنید !",
]);
exit();
}
if($Auto == "Error"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
exit();
}
if($Auto == "OK"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$newself = $self + 1 ;
$connect->query("UPDATE user SET self = '$newself' WHERE id = '$from_id' LIMIT 1");
if($listself != "❗️خالی . . . !"){
$newLself = "$listself\n⟩••• +$phonenumber";
$connect->query("UPDATE user SET listself = '$newLself' WHERE id = '$from_id' LIMIT 1");
}else{
$newLself = "⟩••• +$phonenumber";
$connect->query("UPDATE user SET listself = '$newLself' WHERE id = '$from_id' LIMIT 1");
}
file_put_contents("bot/self/$phonenumber/admin.txt","$from_id");
file_put_contents("bot/self/$phonenumber/eshtrak.txt","30");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات بر روی اکانت ( `+$phonenumber` ) فعال شد ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
$get = file_get_contents("$domain/AutoCron.php?url=$domain/bot/self/$phonenumber/index.php&time=1&phone=$phonenumber");
$two = file_get_contents("$domain/AutoCron.php?url=$domain/bot/self/$phonenumber/index.php&time=1&phone=$phonenumber");
$cron = json_decode($get,true)["ok"];
$crons = json_decode($two,true)["ok"];
if($cron == "true" and $crons == "true"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کرونجاب خودکار با موفقیت تنظیم شد !
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کرونجاب با موفقیت فعال نشد لطفاً به پشتیبانی مراجعه کنید !
",
'parse_mode'=>'MarkDown',
]);
}
$newcoin = $coin - 10 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 لطفاً کد 5 رقمی که از سمت تلگرام ارسال شده است را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔢 لطفاً کد ارسال شده به اکانت خود را بصورت عدد برای ربات ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if(strpos($step,'cod3-') !== false and $text != "🔙 بازگشت"){
$phonenumber = explode("-",$step)[1];
$text = str_replace(["#","`","*","_","[","]","-","+","(",")","'"],[""],$text);
if(is_numeric($text)){
if(strlen($text) == "5"){
$Auto = file_get_contents("$domain/Auto1.php?phone=$phonenumber&code=$text");
if($Auto == "two-factor"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❗️اکانت شما دارای تایید دو مرحله ای است لطفاً تایید دو مرحله را بردارید و مجدد تلاش کنید !",
]);
exit();
}
if($Auto == "Error"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
exit();
}
if($Auto == "OK"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$newself = $self + 1 ;
$connect->query("UPDATE user SET self = '$newself' WHERE id = '$from_id' LIMIT 1");
if($listself != "❗️خالی . . . !"){
$newLself = "$listself\n⟩••• +$phonenumber";
$connect->query("UPDATE user SET listself = '$newLself' WHERE id = '$from_id' LIMIT 1");
}else{
$newLself = "⟩••• +$phonenumber";
$connect->query("UPDATE user SET listself = '$newLself' WHERE id = '$from_id' LIMIT 1");
}
file_put_contents("bot/self/$phonenumber/admin.txt","$from_id");
file_put_contents("bot/self/$phonenumber/eshtrak.txt","30");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات بر روی اکانت ( `+$phonenumber` ) فعال شد ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
$get = file_get_contents("$domain/AutoCron.php?url=$domain/bot/self/$phonenumber/index.php&time=1&phone=$phonenumber");
$two = file_get_contents("$domain/AutoCron.php?url=$domain/bot/self/$phonenumber/index.php&time=1&phone=$phonenumber");
$cron = json_decode($get,true)["ok"];
$crons = json_decode($two,true)["ok"];
if($cron == "true" and $crons == "true"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کرونجاب خودکار با موفقیت تنظیم شد !
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کرونجاب با موفقیت فعال نشد لطفاً به پشتیبانی مراجعه کنید !
",
'parse_mode'=>'MarkDown',
]);
}
$newcoin = $coin - 30 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 لطفاً کد 5 رقمی که از سمت تلگرام ارسال شده است را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔢 لطفاً کد ارسال شده به اکانت خود را بصورت عدد برای ربات ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if(strpos($step,'cod4-') !== false and $text != "🔙 بازگشت"){
$phonenumber = explode("-",$step)[1];
$text = str_replace(["#","`","*","_","[","]","-","+","(",")","'"],[""],$text);
if(is_numeric($text)){
if(strlen($text) == "5"){
$Auto = file_get_contents("$domain/Auto1.php?phone=$phonenumber&code=$text");
if($Auto == "two-factor"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❗️اکانت شما دارای تایید دو مرحله ای است لطفاً تایید دو مرحله را بردارید و مجدد تلاش کنید !",
]);
exit();
}
if($Auto == "Error"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
exit();
}
if($Auto == "OK"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$newself = $self + 1 ;
$connect->query("UPDATE user SET self = '$newself' WHERE id = '$from_id' LIMIT 1");
if($listself != "❗️خالی . . . !"){
$newLself = "$listself\n⟩••• +$phonenumber";
$connect->query("UPDATE user SET listself = '$newLself' WHERE id = '$from_id' LIMIT 1");
}else{
$newLself = "⟩••• +$phonenumber";
$connect->query("UPDATE user SET listself = '$newLself' WHERE id = '$from_id' LIMIT 1");
}
file_put_contents("bot/self/$phonenumber/admin.txt","$from_id");
file_put_contents("bot/self/$phonenumber/eshtrak.txt","30");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات بر روی اکانت ( `+$phonenumber` ) فعال شد ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
$get = file_get_contents("$domain/AutoCron.php?url=$domain/bot/self/$phonenumber/index.php&time=1&phone=$phonenumber");
$two = file_get_contents("$domain/AutoCron.php?url=$domain/bot/self/$phonenumber/index.php&time=1&phone=$phonenumber");
$cron = json_decode($get,true)["ok"];
$crons = json_decode($two,true)["ok"];
if($cron == "true" and $crons == "true"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کرونجاب خودکار با موفقیت تنظیم شد !
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کرونجاب با موفقیت فعال نشد لطفاً به پشتیبانی مراجعه کنید !
",
'parse_mode'=>'MarkDown',
]);
}
$newcoin = $coin - 40 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 لطفاً کد 5 رقمی که از سمت تلگرام ارسال شده است را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔢 لطفاً کد ارسال شده به اکانت خود را بصورت عدد برای ربات ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if(strpos($step,'cod5-') !== false and $text != "🔙 بازگشت"){
$phonenumber = explode("-",$step)[1];
$text = str_replace(["#","`","*","_","[","]","-","+","(",")","'"],[""],$text);
if(is_numeric($text)){
if(strlen($text) == "5"){
$Auto = file_get_contents("$domain/Auto1.php?phone=$phonenumber&code=$text");
if($Auto == "two-factor"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❗️اکانت شما دارای تایید دو مرحله ای است لطفاً تایید دو مرحله را بردارید و مجدد تلاش کنید !",
]);
exit();
}
if($Auto == "Error"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
exit();
}
if($Auto == "OK"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$newself = $self + 1 ;
$connect->query("UPDATE user SET self = '$newself' WHERE id = '$from_id' LIMIT 1");
if($listself != "❗️خالی . . . !"){
$newLself = "$listself\n⟩••• +$phonenumber";
$connect->query("UPDATE user SET listself = '$newLself' WHERE id = '$from_id' LIMIT 1");
}else{
$newLself = "⟩••• +$phonenumber";
$connect->query("UPDATE user SET listself = '$newLself' WHERE id = '$from_id' LIMIT 1");
}
file_put_contents("bot/self/$phonenumber/admin.txt","$from_id");
file_put_contents("bot/self/$phonenumber/eshtrak.txt","30");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات بر روی اکانت ( `+$phonenumber` ) فعال شد ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
$get = file_get_contents("$domain/AutoCron.php?url=$domain/bot/self/$phonenumber/index.php&time=1&phone=$phonenumber");
$two = file_get_contents("$domain/AutoCron.php?url=$domain/bot/self/$phonenumber/index.php&time=1&phone=$phonenumber");
$cron = json_decode($get,true)["ok"];
$crons = json_decode($two,true)["ok"];
if($cron == "true" and $crons == "true"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کرونجاب خودکار با موفقیت تنظیم شد !
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کرونجاب با موفقیت فعال نشد لطفاً به پشتیبانی مراجعه کنید !
",
'parse_mode'=>'MarkDown',
]);
}
$newcoin = $coin - 60 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 لطفاً کد 5 رقمی که از سمت تلگرام ارسال شده است را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔢 لطفاً کد ارسال شده به اکانت خود را بصورت عدد برای ربات ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if(strpos($step,'cod6-') !== false and $text != "🔙 بازگشت"){
$phonenumber = explode("-",$step)[1];
$text = str_replace(["#","`","*","_","[","]","-","+","(",")","'"],[""],$text);
if(is_numeric($text)){
if(strlen($text) == "5"){
$Auto = file_get_contents("$domain/Auto2.php?phone=$phonenumber&code=$text");
if($Auto == "two-factor"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❗️اکانت شما دارای تایید دو مرحله ای است لطفاً تایید دو مرحله را بردارید و مجدد تلاش کنید !",
]);
exit();
}
if($Auto == "Error"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
exit();
}
if($Auto == "OK"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
if($listtabchi != "❗️خالی . . . !"){
$newLtabchi = "$listtabchi\n⟩••• +$phonenumber";
$connect->query("UPDATE user SET listtabchi = '$newLtabchi' WHERE id = '$from_id' LIMIT 1");
}else{
$newLtabchi = "⟩••• +$phonenumber";
$connect->query("UPDATE user SET listtabchi = '$newLtabchi' WHERE id = '$from_id' LIMIT 1");
}
file_put_contents("bot/tabchi/$phonenumber/admin.txt","$from_id");
file_put_contents("bot/tabchi/$phonenumber/eshtrak.txt","30");
$newtabchi = $tabchi + 1 ;
$connect->query("UPDATE user SET tabchi = '$newtabchi' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات بر روی اکانت ( `+$phonenumber` ) فعال شد ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
$get = file_get_contents("$domain/AutoCron.php?url=$domain/bot/tabchi/$phonenumber/index.php&time=1&phone=$phonenumber");
$two = file_get_contents("$domain/AutoCron.php?url=$domain/bot/tabchi/$phonenumber/index.php&time=1&phone=$phonenumber");
$cron = json_decode($get,true)["ok"];
$crons = json_decode($two,true)["ok"];
if($cron == "true" and $crons == "true"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کرونجاب خودکار با موفقیت تنظیم شد !
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کرونجاب با موفقیت فعال نشد لطفاً به پشتیبانی مراجعه کنید !
",
'parse_mode'=>'MarkDown',
]);
}
$newcoin = $coin - 60 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 لطفاً کد 5 رقمی که از سمت تلگرام ارسال شده است را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔢 لطفاً کد ارسال شده به اکانت خود را بصورت عدد برای ربات ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if(strpos($step,'cod7-') !== false and $text != "🔙 بازگشت"){
$phonenumber = explode("-",$step)[1];
$text = str_replace(["#","`","*","_","[","]","-","+","(",")","'"],[""],$text);
if(is_numeric($text)){
if(strlen($text) == "5"){
$Auto = file_get_contents("$domain/Auto2.php?phone=$phonenumber&code=$text");
if($Auto == "two-factor"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❗️اکانت شما دارای تایید دو مرحله ای است لطفاً تایید دو مرحله را بردارید و مجدد تلاش کنید !",
]);
exit();
}
if($Auto == "Error"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
exit();
}
if($Auto == "OK"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
if($listtabchi != "❗️خالی . . . !"){
$newLtabchi = "$listtabchi\n⟩••• +$phonenumber";
$connect->query("UPDATE user SET listtabchi = '$newLtabchi' WHERE id = '$from_id' LIMIT 1");
}else{
$newLtabchi = "⟩••• +$phonenumber";
$connect->query("UPDATE user SET listtabchi = '$newLtabchi' WHERE id = '$from_id' LIMIT 1");
}
file_put_contents("bot/tabchi/$phonenumber/admin.txt","$from_id");
file_put_contents("bot/tabchi/$phonenumber/eshtrak.txt","30");
$newtabchi = $tabchi + 1 ;
$connect->query("UPDATE user SET tabchi = '$newtabchi' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات بر روی اکانت ( `+$phonenumber` ) فعال شد ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
$get = file_get_contents("$domain/AutoCron.php?url=$domain/bot/tabchi/$phonenumber/index.php&time=1&phone=$phonenumber");
$two = file_get_contents("$domain/AutoCron.php?url=$domain/bot/tabchi/$phonenumber/index.php&time=1&phone=$phonenumber");
$cron = json_decode($get,true)["ok"];
$crons = json_decode($two,true)["ok"];
if($cron == "true" and $crons == "true"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کرونجاب خودکار با موفقیت تنظیم شد !
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کرونجاب با موفقیت فعال نشد لطفاً به پشتیبانی مراجعه کنید !
",
'parse_mode'=>'MarkDown',
]);
}
$newcoin = $coin - 50 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 لطفاً کد 5 رقمی که از سمت تلگرام ارسال شده است را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔢 لطفاً کد ارسال شده به اکانت خود را بصورت عدد برای ربات ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if(strpos($step,'cod8-') !== false and $text != "🔙 بازگشت"){
$phonenumber = explode("-",$step)[1];
$text = str_replace(["#","`","*","_","[","]","-","+","(",")","'"],[""],$text);
if(is_numeric($text)){
if(strlen($text) == "5"){
$Auto = file_get_contents("$domain/Auto2.php?phone=$phonenumber&code=$text");
if($Auto == "two-factor"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❗️اکانت شما دارای تایید دو مرحله ای است لطفاً تایید دو مرحله را بردارید و مجدد تلاش کنید !",
]);
exit();
}
if($Auto == "Error"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
exit();
}
if($Auto == "OK"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
if($listtabchi != "❗️خالی . . . !"){
$newLtabchi = "$listtabchi\n⟩••• +$phonenumber";
$connect->query("UPDATE user SET listtabchi = '$newLtabchi' WHERE id = '$from_id' LIMIT 1");
}else{
$newLtabchi = "⟩••• +$phonenumber";
$connect->query("UPDATE user SET listtabchi = '$newLtabchi' WHERE id = '$from_id' LIMIT 1");
}
file_put_contents("bot/tabchi/$phonenumber/admin.txt","$from_id");
file_put_contents("bot/tabchi/$phonenumber/eshtrak.txt","30");
$newtabchi = $tabchi + 1 ;
$connect->query("UPDATE user SET tabchi = '$newtabchi' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات بر روی اکانت ( `+$phonenumber` ) فعال شد ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
$get = file_get_contents("$domain/AutoCron.php?url=$domain/bot/tabchi/$phonenumber/index.php&time=1&phone=$phonenumber");
$two = file_get_contents("$domain/AutoCron.php?url=$domain/bot/tabchi/$phonenumber/index.php&time=1&phone=$phonenumber");
$cron = json_decode($get,true)["ok"];
$crons = json_decode($two,true)["ok"];
if($cron == "true" and $crons == "true"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کرونجاب خودکار با موفقیت تنظیم شد !
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کرونجاب با موفقیت فعال نشد لطفاً به پشتیبانی مراجعه کنید !
",
'parse_mode'=>'MarkDown',
]);
}
$newcoin = $coin - 40 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 لطفاً کد 5 رقمی که از سمت تلگرام ارسال شده است را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔢 لطفاً کد ارسال شده به اکانت خود را بصورت عدد برای ربات ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if(strpos($step,'cod9-') !== false and $text != "🔙 بازگشت"){
$phonenumber = explode("-",$step)[1];
$text = str_replace(["#","`","*","_","[","]","-","+","(",")","'"],[""],$text);
if(is_numeric($text)){
if(strlen($text) == "5"){
$Auto = file_get_contents("$domain/Auto3.php?phone=$phonenumber&code=$text");
if($Auto == "two-factor"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❗️اکانت شما دارای تایید دو مرحله ای است لطفاً تایید دو مرحله را بردارید و مجدد تلاش کنید !",
]);
exit();
}
if($Auto == "Error"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
exit();
}
if($Auto == "OK"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$newclicker = $clicker + 1 ;
$connect->query("UPDATE user SET clicker = '$newclicker' WHERE id = '$from_id' LIMIT 1");
if($listclicker != "❗️خالی . . . !"){
$newLclicker = "$listclicker\n⟩••• +$phonenumber";
$connect->query("UPDATE user SET listclicker = '$newLclicker' WHERE id = '$from_id' LIMIT 1");
}else{
$newLclicker = "⟩••• +$phonenumber";
$connect->query("UPDATE user SET listclicker = '$newLclicker' WHERE id = '$from_id' LIMIT 1");
}
file_put_contents("bot/clicker/$phonenumber/admin.txt","$from_id");
file_put_contents("bot/clicker/$phonenumber/eshtrak.txt","30");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات بر روی اکانت ( `+$phonenumber` ) فعال شد ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
$get = file_get_contents("$domain/AutoCron.php?url=$domain/bot/clicker/$phonenumber/index.php&time=1&phone=$phonenumber");
$two = file_get_contents("$domain/AutoCron.php?url=$domain/bot/clicker/$phonenumber/index.php&time=1&phone=$phonenumber");
$cron = json_decode($get,true)["ok"];
$crons = json_decode($two,true)["ok"];
if($cron == "true" and $crons == "true"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کرونجاب خودکار با موفقیت تنظیم شد !
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کرونجاب با موفقیت فعال نشد لطفاً به پشتیبانی مراجعه کنید !
",
'parse_mode'=>'MarkDown',
]);
}
$newcoin = $coin - 35 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 لطفاً کد 5 رقمی که از سمت تلگرام ارسال شده است را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔢 لطفاً کد ارسال شده به اکانت خود را بصورت عدد برای ربات ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if(strpos($step,'cod10-') !== false and $text != "🔙 بازگشت"){
$phonenumber = explode("-",$step)[1];
$text = str_replace(["#","`","*","_","[","]","-","+","(",")","'"],[""],$text);
if(is_numeric($text)){
if(strlen($text) == "5"){
$Auto = file_get_contents("$domain/Auto3.php?phone=$phonenumber&code=$text");
if($Auto == "two-factor"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❗️اکانت شما دارای تایید دو مرحله ای است لطفاً تایید دو مرحله را بردارید و مجدد تلاش کنید !",
]);
exit();
}
if($Auto == "Error"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
exit();
}
if($Auto == "OK"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$newclicker = $clicker + 1 ;
$connect->query("UPDATE user SET clicker = '$newclicker' WHERE id = '$from_id' LIMIT 1");
if($listclicker != "❗️خالی . . . !"){
$newLclicker = "$listclicker\n⟩••• +$phonenumber";
$connect->query("UPDATE user SET listclicker = '$newLclicker' WHERE id = '$from_id' LIMIT 1");
}else{
$newLclicker = "⟩••• +$phonenumber";
$connect->query("UPDATE user SET listclicker = '$newLclicker' WHERE id = '$from_id' LIMIT 1");
}
file_put_contents("bot/clicker/$phonenumber/admin.txt","$from_id");
file_put_contents("bot/clicker/$phonenumber/eshtrak.txt","30");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات بر روی اکانت ( `+$phonenumber` ) فعال شد ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
$get = file_get_contents("$domain/AutoCron.php?url=$domain/bot/clicker/$phonenumber/index.php&time=1&phone=$phonenumber");
$two = file_get_contents("$domain/AutoCron.php?url=$domain/bot/clicker/$phonenumber/index.php&time=1&phone=$phonenumber");
$cron = json_decode($get,true)["ok"];
$crons = json_decode($two,true)["ok"];
if($cron == "true" and $crons == "true"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کرونجاب خودکار با موفقیت تنظیم شد !
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کرونجاب با موفقیت فعال نشد لطفاً به پشتیبانی مراجعه کنید !
",
'parse_mode'=>'MarkDown',
]);
}
$newcoin = $coin - 30 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 لطفاً کد 5 رقمی که از سمت تلگرام ارسال شده است را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔢 لطفاً کد ارسال شده به اکانت خود را بصورت عدد برای ربات ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if(strpos($step,'cod11-') !== false and $text != "🔙 بازگشت"){
$phonenumber = explode("-",$step)[1];
$text = str_replace(["#","`","*","_","[","]","-","+","(",")","'"],[""],$text);
if(is_numeric($text)){
if(strlen($text) == "5"){
$Auto = file_get_contents("$domain/Auto3.php?phone=$phonenumber&code=$text");
if($Auto == "two-factor"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"❗️اکانت شما دارای تایید دو مرحله ای است لطفاً تایید دو مرحله را بردارید و مجدد تلاش کنید !",
]);
exit();
}
if($Auto == "Error"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
exit();
}
if($Auto == "OK"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$newclicker = $clicker + 1 ;
$connect->query("UPDATE user SET clicker = '$newclicker' WHERE id = '$from_id' LIMIT 1");
if($listclicker != "❗️خالی . . . !"){
$newLclicker = "$listclicker\n⟩••• +$phonenumber";
$connect->query("UPDATE user SET listclicker = '$newLclicker' WHERE id = '$from_id' LIMIT 1");
}else{
$newLclicker = "⟩••• +$phonenumber";
$connect->query("UPDATE user SET listclicker = '$newLclicker' WHERE id = '$from_id' LIMIT 1");
}
file_put_contents("bot/clicker/$phonenumber/admin.txt","$from_id");
file_put_contents("bot/clicker/$phonenumber/eshtrak.txt","30");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات بر روی اکانت ( `+$phonenumber` ) فعال شد ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
$get = file_get_contents("$domain/AutoCron.php?url=$domain/bot/clicker/$phonenumber/index.php&time=1&phone=$phonenumber");
$two = file_get_contents("$domain/AutoCron.php?url=$domain/bot/clicker/$phonenumber/index.php&time=1&phone=$phonenumber");
$cron = json_decode($get,true)["ok"];
$crons = json_decode($two,true)["ok"];
if($cron == "true" and $crons == "true"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ کرونجاب خودکار با موفقیت تنظیم شد !
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کرونجاب با موفقیت فعال نشد لطفاً به پشتیبانی مراجعه کنید !
",
'parse_mode'=>'MarkDown',
]);
}
$newcoin = $coin - 35 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"⚠️ کد ارسال شده صحیح نمی‌باشد مجدد تلاش کنید . . .",
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 لطفاً کد 5 رقمی که از سمت تلگرام ارسال شده است را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔢 لطفاً کد ارسال شده به اکانت خود را بصورت عدد برای ربات ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($text == "⚡️ تست سرعت"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🌟 به بخش تست سرعت ربات سلف ساز فلش خوش آمدید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'✏️ سرعت ادیت']],
[['text'=>'🌐 پینگ سرور'],['text'=>'📑 ارسال متن']],
[['text'=>'🔙 بازگشت']],
]])
]);
}
if($text == "🌐 پینگ سرور"){
$mem_using = round((memory_get_usage()/1024)/1024, 0).' مگابایت';
$load = sys_getloadavg();
$ver = phpversion();
$id = bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
💫 درحال پردازش . . . !
",
'parse_mode' => 'MarkDown'
])->result->message_id;
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
💫 اطلاعات سرور سلف ساز فلش !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"💤 پینگ",'callback_data'=>'fake']],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text'=>"💤 پینگ",'callback_data'=>'fake']],
[['text' => "💭 رم استفاده شده", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text'=>"💤 پینگ",'callback_data'=>'fake']],
[['text' => "💭 رم استفاده شده", 'callback_data' => "fake"]],
[['text' => "♻️ ورژن پی اچ پی", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text'=>"💤 پینگ",'callback_data'=>'fake']],
[['text' => "💭 رم استفاده شده", 'callback_data' => "fake"]],
[['text' => "♻️ ورژن پی اچ پی", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text'=>"$load[0]",'callback_data'=>'fake'],['text'=>"💤 پینگ",'callback_data'=>'fake']],
[['text' => "💭 رم استفاده شده", 'callback_data' => "fake"]],
[['text' => "♻️ ورژن پی اچ پی", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text'=>"$load[0]",'callback_data'=>'fake'],['text'=>"💤 پینگ",'callback_data'=>'fake']],
[['text'=>"$mem_using",'callback_data'=>'fake'],['text' => "💭 رم استفاده شده", 'callback_data' => "fake"]],
[['text' => "♻️ ورژن پی اچ پی", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text'=>"$load[0]",'callback_data'=>'fake'],['text'=>"💤 پینگ",'callback_data'=>'fake']],
[['text'=>"$mem_using",'callback_data'=>'fake'],['text' => "💭 رم استفاده شده", 'callback_data' => "fake"]],
[['text'=>"$ver",'callback_data'=>'fake'],['text' => "♻️ ورژن پی اچ پی", 'callback_data' => "fake"]],
]])
]);
}
if($text == "📑 ارسال متن"){
$id1 = bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
1⃣
",
'parse_mode' => 'MarkDown'
])->result->message_id;
$id2 = bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
2⃣
",
'parse_mode' => 'MarkDown'
])->result->message_id;
$id3 = bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
3⃣
",
'parse_mode' => 'MarkDown'
])->result->message_id;
$id4 = bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
4⃣
",
'parse_mode' => 'MarkDown'
])->result->message_id;
$id5 = bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
5⃣
",
'parse_mode' => 'MarkDown'
])->result->message_id;
$id6 = bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
6⃣
",
'parse_mode' => 'MarkDown'
])->result->message_id;
$id7 = bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
7⃣
",
'parse_mode' => 'MarkDown'
])->result->message_id;
$id8 = bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
8⃣
",
'parse_mode' => 'MarkDown'
])->result->message_id;
$id9 = bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
9⃣
",
'parse_mode' => 'MarkDown'
])->result->message_id;
$id10 = bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔟
",
'parse_mode' => 'MarkDown'
])->result->message_id;
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🌹 بیشترین سرعت ممکن !
⚡️ سلف ساز فلش همین الان سلف و کلیکر و تبچی پر سرعت درست کن !
",
'parse_mode' => 'MarkDown'
]);
bot('deleteMessage',[
'chat_id'=>$from_id,
'message_id' =>$id10,
]);
bot('deleteMessage',[
'chat_id'=>$from_id,
'message_id' =>$id9,
]);
bot('deleteMessage',[
'chat_id'=>$from_id,
'message_id' =>$id8,
]);
bot('deleteMessage',[
'chat_id'=>$from_id,
'message_id' =>$id7,
]);
bot('deleteMessage',[
'chat_id'=>$from_id,
'message_id' =>$id6,
]);
bot('deleteMessage',[
'chat_id'=>$from_id,
'message_id' =>$id5,
]);
bot('deleteMessage',[
'chat_id'=>$from_id,
'message_id' =>$id4,
]);
bot('deleteMessage',[
'chat_id'=>$from_id,
'message_id' =>$id3,
]);
bot('deleteMessage',[
'chat_id'=>$from_id,
'message_id' =>$id2,
]);
bot('deleteMessage',[
'chat_id'=>$from_id,
'message_id' =>$id1,
]);
}
if($text == "✏️ سرعت ادیت"){
$id = bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️
",
'parse_mode' => 'MarkDown'
])->result->message_id;
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز فلش
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز فلش پر
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز فلش پر سرعت
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز فلش پر سرعت و
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز فلش پر سرعت و سریع
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز فلش پر سرعت و سریع و
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز فلش پر سرعت و سریع و امن
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز فلش پر سرعت و سریع و امن

✅ همین
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز فلش پر سرعت و سریع و امن

✅ همین الان
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز فلش پر سرعت و سریع و امن

✅ همین الان سلف
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز فلش پر سرعت و سریع و امن

✅ همین الان سلف خودت
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز فلش پر سرعت و سریع و امن

✅ همین الان سلف خودت رو
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز فلش پر سرعت و سریع و امن

✅ همین الان سلف خودت رو بساز !
",
'parse_mode'=>'MarkDown',
]);
bot('EditMessageText',[
'chat_id'=>$from_id,
'message_id'=>$id,
'text'=>"
❗️سلف ساز فلش پر سرعت و سریع و امن

✅ همین الان سلف خودت رو بساز !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode(['inline_keyboard'=>[
[['text'=>"•",'callback_data'=>'fake']],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=•", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=•=", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=•=•", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=•=•=", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=•=•=•", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=•=•=•=", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=•=•=•=•", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=•=•=•=•=", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=•=•=•=•=•", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=•=•=•=•=•", 'callback_data' => "fake"]],
[['text' => "⏰ ساعت", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=•=•=•=•=•", 'callback_data' => "fake"]],
[['text' => "⏰ ساعت", 'callback_data' => "fake"]],
[['text' => "📆 تاریخ", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=•=•=•=•=•", 'callback_data' => "fake"]],
[['text' => "$time", 'callback_data' => "fake"],['text' => "⏰ ساعت", 'callback_data' => "fake"]],
[['text' => "📆 تاریخ", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=•=•=•=•=•", 'callback_data' => "fake"]],
[['text' => "$time", 'callback_data' => "fake"],['text' => "⏰ ساعت", 'callback_data' => "fake"]],
[['text' => "$date", 'callback_data' => "fake"],['text' => "📆 تاریخ", 'callback_data' => "fake"]],
]])
]);
bot('editMessageReplyMarkup',[
'chat_id'=>$from_id,
'message_id'=>$id,
'reply_markup' => json_encode(['inline_keyboard' =>[
[['text' => "•=•=•=•=•=•=•=•=•=•=•=•", 'callback_data' => "fake"]],
[['text' => "$time", 'callback_data' => "fake"],['text' => "⏰ ساعت", 'callback_data' => "fake"]],
[['text' => "$date", 'callback_data' => "fake"],['text' => "📆 تاریخ", 'callback_data' => "fake"]],
[['text' => "•=•=•=•=•=•=•=•=•=•=•=•", 'callback_data' => "fake"]],
]])
]);
}
if($text == "❄️ تمدید ربات"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❓ کدام ربات خود را میخواهید تمدید کنید 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'❄️ تمدید سلف']],
[['text'=>'❄️ تمدید کلیکر'],['text'=>'❄️ تمدید تبچی']],
[['text'=>'🔙 بازگشت']],
]])
]);
}
if($text == "❄️ تمدید سلف"){
if($self > 0){
$connect->query("UPDATE user SET step = 'tamdidSelf' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔆 شماره اکانت خود را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ شما هیچ سلفی نساخته اید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "tamdidSelf" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
if(is_dir("bot/self/$test")){
$idAdmin = file_get_contents("bot/self/$test/admin.txt");
if($coin > 20){
$nowesh = file_get_contents("bot/self/$test/eshtrak.txt") ?? 0;
$newesh = $nowesh + 30;
file_put_contents("bot/self/$test/eshtrak.txt","$newesh");
$newcoin = $coin - 20 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات شماره ی ( $text ) تمدید شد !

💰 مدت اتمام اشتراک و تمدید مجدد : *$newesh*
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ جهت تمدید باید حداقل *20* سکه داشته باشید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ شما با این شماره هیچ سلفی نساخته اید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($text == "❄️ تمدید تبچی"){
if($tabchi > 0){
$connect->query("UPDATE user SET step = 'tamdidTabchi' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔆 شماره اکانت خود را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ شما هیچ تبچی نساخته اید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "tamdidTabchi" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
if(is_dir("bot/tabchi/$test")){
$idAdmin = file_get_contents("bot/tabchi/$test/admin.txt");
if($coin > 20){
$nowesh = file_get_contents("bot/tabchi/$test/eshtrak.txt") ?? 0;
$newesh = $nowesh + 30;
file_put_contents("bot/tabchi/$test/eshtrak.txt","$newesh");
$newcoin = $coin - 20 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات شماره ی ( $text ) تمدید شد !

💰 مدت اتمام اشتراک و تمدید مجدد : *$newesh*
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ جهت تمدید باید حداقل *20* سکه داشته باشید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ شما با این شماره هیچ تبچی نساخته اید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($text == "❄️ تمدید کلیکر"){
if($clicker > 0){
$connect->query("UPDATE user SET step = 'tamdidClicker' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔆 شماره اکانت خود را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ شما هیچ کلیکری نساخته اید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "tamdidClicker" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
if(is_dir("bot/clicker/$test")){
$idAdmin = file_get_contents("bot/clicker/$test/admin.txt");
if($coin > 20){
$nowesh = file_get_contents("bot/clicker/$test/eshtrak.txt") ?? 0;
$newesh = $nowesh + 30;
file_put_contents("bot/clicker/$test/eshtrak.txt","$newesh");
$newcoin = $coin - 20 ;
$connect->query("UPDATE user SET coin = '$newcoin' WHERE id = '$from_id' LIMIT 1");
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات شماره ی ( $text ) تمدید شد !

💰 مدت اتمام اشتراک و تمدید مجدد : *$newesh*
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ جهت تمدید باید حداقل *20* سکه داشته باشید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ شما با این شماره هیچ کلیکری نساخته اید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($text == "🗑 حذف ربات"){
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❓ کدام ربات خود را میخواهید حذف کنید 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🗑 حذف سلف']],
[['text'=>'🗑 حذف کلیکر'],['text'=>'🗑 حذف تبچی']],
[['text'=>'🔙 بازگشت']],
]])
]);
}
if($text == "🗑 حذف سلف"){
if($self > 0){
$connect->query("UPDATE user SET step = 'deleteSelf' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔆 شماره اکانت خود را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ شما هیچ سلفی نساخته اید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "deleteSelf" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
if(is_dir("bot/self/$test")){
$idAdmin = file_get_contents("bot/self/$test/admin.txt");
if($from_id == $idAdmin){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$newself = $self - 1 ;
$connect->query("UPDATE user SET self = '$newself' WHERE id = '$from_id' LIMIT 1");
if($listself == "⟩••• $text"){
$newLself = str_replace(["⟩••• $text"],["❗️خالی . . . !"],$listself);
}else{
$newLself = str_replace(["\n⟩••• $text"],[""],$listself);
}
$connect->query("UPDATE user SET listself = '$newLself' WHERE id = '$from_id' LIMIT 1");
DeleteFolder("bot/self/$test");
unlink("bot/self/$test/Flash.session.ipc");
unlink("bot/self/$test/Flash.session.callback.ipc");
rmdir("bot/self/$test");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات شماره ی ( $text ) حذف شد !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ این ربات متعلق به شما نیست و نمی‌تواند آنرا حذف کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ شما با این شماره هیچ سلفی نساخته اید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($text == "🗑 حذف تبچی"){
if($tabchi > 0){
$connect->query("UPDATE user SET step = 'deleteTabchi' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔆 شماره اکانت خود را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ شما هیچ تبچی نساخته اید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "deleteTabchi" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
if(is_dir("bot/tabchi/$test")){
$idAdmin = file_get_contents("bot/tabchi/$test/admin.txt");
if($from_id == $idAdmin){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$newtabchi = $tabchi - 1 ;
$connect->query("UPDATE user SET tabchi = '$newtabchi' WHERE id = '$from_id' LIMIT 1");
if($listtabchi == "⟩••• $text"){
$newLtabchi = str_replace(["⟩••• $text"],["❗️خالی . . . !"],$listtabchi);
}else{
$newLtabchi = str_replace(["\n⟩••• $text"],[""],$listtabchi);
}
$connect->query("UPDATE user SET listtabchi = '$newLtabchi' WHERE id = '$from_id' LIMIT 1");
DeleteFolder("bot/tabchi/$test");
unlink("bot/tabchi/$test/Flash.session.ipc");
unlink("bot/tabchi/$test/Flash.session.callback.ipc");
rmdir("bot/tabchi/$test");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات شماره ی ( $text ) حذف شد !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ این ربات متعلق به شما نیست و نمی‌تواند آنرا حذف کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ شما با این شماره هیچ تبچی نساخته اید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($text == "🗑 حذف کلیکر"){
if($clicker > 0){
$connect->query("UPDATE user SET step = 'deleteClicker' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔆 شماره اکانت خود را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ شما هیچ کلیکری نساخته اید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if($step == "deleteClicker" and $text != "🔙 بازگشت"){
if(strpos($text,'+') !== false){
$test = str_replace(["+"],[""],$text);
if(is_numeric($test)){
if(is_dir("bot/clicker/$test")){
$idAdmin = file_get_contents("bot/clicker/$test/admin.txt");
if($from_id == $idAdmin){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$newclicker = $clicker - 1 ;
$connect->query("UPDATE user SET clicker = '$newclicker' WHERE id = '$from_id' LIMIT 1");
if($listclicker == "⟩••• $text"){
$newLclicker = str_replace(["⟩••• $text"],["❗️خالی . . . !"],$listclicker);
}else{
$newLclicker = str_replace(["\n⟩••• $text"],[""],$listclicker);
}
$connect->query("UPDATE user SET listclicker = '$newLclicker' WHERE id = '$from_id' LIMIT 1");
DeleteFolder("bot/clicker/$test");
unlink("bot/clicker/$test/Flash.session.ipc");
unlink("bot/clicker/$test/Flash.session.callback.ipc");
rmdir("bot/clicker/$test");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت ربات شماره ی ( $text ) حذف شد !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ این ربات متعلق به شما نیست و نمی‌تواند آنرا حذف کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ شما با این شماره هیچ کلیکری نساخته اید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❌ لطفاً شماره را بصورت عدد ارسال کنید
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️لطفاً شماره اکانت خود را همراه با ( *+* ) ارسال کنید

🔰 مثال : +9890000000
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 بازگشت']],
]])
]);
}
}
if(in_array($from_id,$dev)){
if($text == "/panel" or $text == "/admin" or $text == "🔙 برگشت"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"🌿 به پنل مدیریت خوشـ آمدید . . . !",
'parse_mode'=>'MarkDown',
'reply_markup' => $admin,
]);
}
if($text == "آمار 📊"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
$countmember = mysqli_num_rows(mysqli_query($connect,"SELECT id FROM user"));
$countban = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM user WHERE step = 'ban'"));
$countvip = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM user WHERE type = 'VIP'"));
$countfree = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM user WHERE type = 'free'"));
$scanself = scandir("bot/self");
$scanself = array_diff($scanself, ['.','..']);
$countself = count($scanself);
$scanclicker = scandir("bot/clicker");
$scanclicker = array_diff($scanclicker, ['.','..']);
$countclicker = count($scanclicker);
$scantabchi = scandir("bot/tabchi");
$scantabchi = array_diff($scantabchi, ['.','..']);
$counttabchi = count($scantabchi);
$MemberCH = bot('getChatMembersCount',['chat_id'=>"@$channel"])->result;
$MemberCH2 = bot('getChatMembersCount',['chat_id'=>"@$channel2"])->result;
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"📊 تعداد کاربر ربات : `$countmember` نفر",
'parse_mode'=>'MarkDown',
'reply_markup' => $admin,
]);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"📈 تعداد کاربران بن شده : `$countban` نفر",
'parse_mode'=>'MarkDown',
]);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"🎉 تعداد کاربران دارای حساب ویژه : `$countvip` نفر",
'parse_mode'=>'MarkDown',
]);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"⚙ تعداد کاربران دارای حساب معمولی : `$countfree` نفر",
'parse_mode'=>'MarkDown',
]);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"👥 تعداد ممبر های کانال اول : `$MemberCH` نفر",
'parse_mode'=>'MarkDown',
]);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"👥 تعداد ممبر های کانال دوم : $MemberCH2 نفر",
'parse_mode'=>'MarkDown',
]);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"🎯 تعداد سلف های ساخته شده : `$countself`",
'parse_mode'=>'MarkDown',
]);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"🔰 تعداد کلیکر های ساخته شده : `$countclicker`",
'parse_mode'=>'MarkDown',
]);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"⚠️ تعداد تبچی های ساخته شده : `$counttabchi`",
'parse_mode'=>'MarkDown',
]);
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"📉 با موفقیت آمار کل ربات سلف ساز فلش برای شما ارسال شد !",
'parse_mode'=>'MarkDown',
]);
}
if($text == "💫 ریست لیست"){
$connect->query("UPDATE user SET step = 'resetid' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔰 ای دی عددی کاربر مورد نظر را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "resetid" and $text != "🔙 برگشت"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
if(mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE `id` = '$text' LIMIT 1")) == true){
$connect->query("UPDATE user SET listself = '❗️خالی . . . !' WHERE id = '$text' LIMIT 1");
$connect->query("UPDATE user SET listtabchi = '❗️خالی . . . !' WHERE id = '$text' LIMIT 1");
$connect->query("UPDATE user SET listclicker = '❗️خالی . . . !' WHERE id = '$text' LIMIT 1");
$connect->query("UPDATE user SET self = '0' WHERE id = '$text' LIMIT 1");
$connect->query("UPDATE user SET tabchi = '0' WHERE id = '$text' LIMIT 1");
$connect->query("UPDATE user SET clicker = '0' WHERE id = '$text' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"✅ با موفقیت لیست سلف و کلیکر و تبچی حساب کاربری ( `$text` ) ریست شد !",
'parse_mode'=>'MarkDown',
'reply_markup' => $admin,
]);
bot('SendMessage',[
'chat_id'=>$text,
'text'=>"⚠️ *لیست سلف و تبچی و کلیکر شما از طرف پشتیبانی ریست شد !*",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️این کاربر در ربات نیست . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
if($text == "➕ افزایش سکه"){
$connect->query("UPDATE user SET step = 'upcoin' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
💰 مقدار سکه جهت افزایش را ارسال کنید . . . 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "upcoin" and $text != "🔙 برگشت"){
if(is_numeric($text)){
$connect->query("UPDATE user SET step = 'coinplus-$text' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔰 ای دی عددی کاربر مورد نظر را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ لطفاً فقط عدد ارسال کنید
",
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
elseif(strpos($step,'coinplus-') !== false and $text != "🔙 برگشت"){
$ez = explode("-",$step);
if(mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE `id` = '$text' LIMIT 1")) == true){
$info = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM user WHERE id = '$text' LIMIT 1"));
$ads = $info['coin'] + $ez[1] ;
$connect->query("UPDATE user SET coin = '$ads' WHERE id = '$text' LIMIT 1");
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"`✅ با موفقیت تعداد $ez[1] سکه به کاربر $text اضافه شد !`",
'parse_mode'=>'MarkDown',
'reply_markup' => $admin,
]);
bot('SendMessage',[
'chat_id'=>$text,
'text'=>"`✅ با موفقیت تعداد $ez[1] سکه در ساعت $time و تاریخ $date از طرف مدیریت به حساب شما اضافه شد !`",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️این کاربر در ربات نیست . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
if($text == "➖ کسر سکه"){
$connect->query("UPDATE user SET step = 'leftcoin' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
💰 مقدار سکه جهت کسر را ارسال کنید . . . 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "leftcoin" and $text != "🔙 برگشت"){
if(is_numeric($text)){
$connect->query("UPDATE user SET step = 'coinneg-$text' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔰 ای دی عددی کاربر مورد نظر را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ لطفاً فقط عدد ارسال کنید
",
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
elseif(strpos($step,'coinneg-') !== false and $text != "🔙 برگشت"){
$ez = explode("-",$step);
if(mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE `id` = '$text' LIMIT 1")) == true){
$info = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM user WHERE id = '$text' LIMIT 1"));
$ads = $info['coin'] - $ez[1] ;
$connect->query("UPDATE user SET coin = '$ads' WHERE id = '$text' LIMIT 1");
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"`💤 با موفقیت تعداد $ez[1] سکه به کاربر $text کسر شد !`",
'parse_mode'=>'MarkDown',
'reply_markup' => $admin,
]);
bot('SendMessage',[
'chat_id'=>$text,
'text'=>"`🔰 تعداد $ez[1] سکه از طرف مدیریت از شما کم شد !`",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️این کاربر در ربات نیست . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
if($text == "❗️ افزایش اخطار"){
$connect->query("UPDATE user SET step = 'upwarn' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️ تعداد اخطار جهت دادن به کاربر مورد نظر را ارسال کنید . . . 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "upwarn" and $text != "🔙 برگشت"){
if(is_numeric($text)){
$connect->query("UPDATE user SET step = 'warnplus-$text' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔰 ای دی عددی کاربر مورد نظر را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ لطفاً فقط عدد ارسال کنید
",
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
elseif(strpos($step,'warnplus-') !== false and $text != "🔙 برگشت"){
$ez = explode("-",$step);
if(mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE `id` = '$text' LIMIT 1")) == true){
$info = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM user WHERE id = '$text' LIMIT 1"));
$ads = $info['warn'] + $ez[1] ;
$connect->query("UPDATE user SET warn = '$ads' WHERE id = '$text' LIMIT 1");
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"`❗️ با موفقیت تعداد $ez[1] اخطار به کاربر $text اضافه شد !`",
'parse_mode'=>'MarkDown',
'reply_markup' => $admin,
]);
bot('SendMessage',[
'chat_id'=>$text,
'text'=>"`❗️تعداد $ez[1] اخطار به شما داده شد`",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️این کاربر در ربات نیست . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
if($text == "❕ حذف اخطار"){
$connect->query("UPDATE user SET step = 'leftwarn' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️تعداد اخطار جهت حذف کردن از کاربر مورد نظر را ارسال کنید . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "leftwarn" and $text != "🔙 برگشت"){
if(is_numeric($text)){
$connect->query("UPDATE user SET step = 'warnneg-$text' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔰 ای دی عددی کاربر مورد نظر را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ لطفاً فقط عدد ارسال کنید
",
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
elseif(strpos($step,'warnneg-') !== false and $text != "🔙 برگشت"){
$ez = explode("-",$step);
if(mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE `id` = '$text' LIMIT 1")) == true){
$info = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM user WHERE id = '$text' LIMIT 1"));
$ads = $info['warn'] - $ez[1] ;
$connect->query("UPDATE user SET warn = '$ads' WHERE id = '$text' LIMIT 1");
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"`💤 با موفقیت تعداد $ez[1] اخطار از کاربر $text کم شد`",
'parse_mode'=>'MarkDown',
'reply_markup' => $admin,
]);
bot('SendMessage',[
'chat_id'=>$text,
'text'=>"`❕تعداد $ez[1] اخطار از شما کم شد`",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️این کاربر در ربات نیست . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
if($text == "🔰 اطلاعات کاربر"){
$connect->query("UPDATE user SET step = 'upinfo' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔰 ای دی عددی کاربر مورد نظر را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "upinfo" and $text != "🔙 برگشت"){
if(is_numeric($text)){
if(mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE `id` = '$text' LIMIT 1")) == true){
$info = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM user WHERE id = '$text' LIMIT 1"));
$FScoin = $info["coin"];
$FSinv = $info["inv"];
$FSwarn = $info["warn"];
$FSlisttabchi = $info["listtabchi"];
$FSlistclicker = $info["listclicker"];
$FSlistself = $info["listself"];
$FSstar = $info["star"];
$FSself = $info["self"];
$FStabchi = $info["tabchi"];
$FSclicker = $info["clicker"];
$FStype = $info["type"];
$FSdatejoin = $info["date"];
$FStimejoin = $info["time"];
$FSnumberphone = $info["phone"];
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
💰 موجودی حساب کاربر : $FScoin سکه

🎊 تعداد زیر مجموعه های کاربر : $FSinv نفر

⭐️ سطح کاربری کاربر : $FSstar

⚠️ تعداد اخطار های کاربر : $FSwarn اخطار

🔐 نوع حساب کاربر : $FStype

🎁 تعداد تبچی های کاربر : $FStabchi تا

🎯 تعداد سلف های کاربر : $FSself تا

🍂 تعداد کلیکر های کاربر : $FStabchi تا

📆 تاریخ عضویت کاربر : $FSdatejoin

⏰ ساعت عضویت کاربر : $FStimejoin

🔢 شماره تلفن کاربر : $FSnumberphone




⚠️ لیست تبچی های ساخته شده : 

$FSlisttabchi


⚠️ لیست سلف های ساخته شده :

$FSlistself

⚠️ لیست کلیکر های ساخته شده :

$FSlistclicker

",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️این کاربر در ربات نیست . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ لطفاً فقط عدد ارسال کنید
",
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
if($text == "💡 روشن کردن ربات"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
if(file_exists('panel/off.txt')){
unlink("panel/off.txt");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
💡 ربات با موفقیت روشن شد !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔋 ربات از قفل روشن بود !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
if($text == "💤 خاموش کردن ربات"){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
if(!file_exists('panel/off.txt')){
file_put_contents("panel/off.txt","NONE . . . !");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
💤 ربات با موفقیت خاموش شد !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🌀 ربات از قبل خاموش بود !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
if($text == "🎈 رایگان کردن حساب"){
$connect->query("UPDATE user SET step = 'freeshod' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔰 ای دی عددی کاربر مورد نظر را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "freeshod" and $text != "🔙 برگشت"){
if(mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE `id` = '$text' LIMIT 1")) == true){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت حساب ( `$text` ) رایگان شد !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
$connect->query("UPDATE user SET type = 'free' WHERE id = '$text' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$text,
'text'=>"
🎉 حساب شما از طرف مدیریت ( FREE ) شد !
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️این کاربر در ربات نیست . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
if($text == "🎊 ویژه کردن حساب"){
$connect->query("UPDATE user SET step = 'vipshod' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔰 ای دی عددی کاربر مورد نظر را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "vipshod" and $text != "🔙 برگشت"){
if(mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE `id` = '$text' LIMIT 1")) == true){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت حساب ( `$text` ) ویژه شد !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
$connect->query("UPDATE user SET type = 'VIP' WHERE id = '$text' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$text,
'text'=>"
🎉 حساب شما از طرف مدیریت ( VIP ) شد !
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️این کاربر در ربات نیست . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
if($text == "⚠️ بن کردن"){
$connect->query("UPDATE user SET step = 'okban' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔰 ای دی عددی کاربر مورد نظر را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "okban" and $text != "🔙 برگشت"){
if(mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE `id` = '$text' LIMIT 1")) == true){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ کاربر ( `$text` ) بلاک شد از ربات سلف ساز فلش !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
$connect->query("UPDATE user SET step = 'ban' WHERE id = '$text' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$text,
'text'=>"
❗️شما از ربات بلاک شدید
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️این کاربر در ربات نیست . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
if($text == "🔰 آن بن کردن"){
$connect->query("UPDATE user SET step = 'okonban' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔰 ای دی عددی کاربر مورد نظر را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "okonban" and $text != "🔙 برگشت"){
if(mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE `id` = '$text' LIMIT 1")) == true){
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔰 کاربر ( `$text` ) آنبلاک شد از ربات سلف ساز فلش !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
$connect->query("UPDATE user SET step = 'none' WHERE id = '$text' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$text,
'text'=>"
❕شما از ربات آنبلاک شدید
",
'parse_mode'=>'MarkDown',
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️این کاربر در ربات نیست . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
if($text == "✅ تنظیم api hash"){
$connect->query("UPDATE user SET step = 'api_hash' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ ای پی هاش مورد نظر را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "api_hash" and $text != "🔙 برگشت"){
file_put_contents("source/api_hash.txt","$text");
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت api hash جدید ( `$text` ) ثبت شد !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($text == "✅ تنظیم api id"){
$connect->query("UPDATE user SET step = 'api_id' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ ای پی ای دی مورد نظر را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "api_id" and $text != "🔙 برگشت"){
file_put_contents("source/api_id.txt","$text");
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت api id جدید ( `$text` ) ثبت شد !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($text == "🔐 تنظیم کانال اول"){
$connect->query("UPDATE user SET step = 'set_ch1' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 ای دی کانال اول را بدون ( @ ) ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "set_ch1" and $text != "🔙 برگشت"){
file_put_contents("panel/channel.txt","$text");
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت کانال اول ( @$text ) تنظیم شد !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($text == "🔐 تنظیم کانال دوم"){
$connect->query("UPDATE user SET step = 'set_ch2' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🔐 ای دی کانال دوم را بدون ( @ ) ارسال کنید ! 
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "set_ch2" and $text != "🔙 برگشت"){
file_put_contents("panel/channel2.txt","$text");
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ با موفقیت کانال دوم ( @$text ) تنظیم شد !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($text == "🎉 ساخت کد VIP"){
$connect->query("UPDATE user SET step = 'MakeVip' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🎈 کد *VIP* جهت ساخت ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "MakeVip" and $text != "🔙 برگشت"){
file_put_contents("vip.txt","$text");
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🎉 کد ویژه کننده *( VIP )* با موفقیت ساخته شد 

✅ کد : `$text`
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($text == "🎁 ساخت کد هدیه"){
$connect->query("UPDATE user SET step = 'MakeCode' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
💰 مقدار سکه کد هدیه را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "MakeCode" and $text != "🔙 برگشت"){
if(is_numeric($text)){
$connect->query("UPDATE user SET step = 'SendCode-$text' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
🥂 کد هدیه را ارسال کنید !

🍭 تعداد سکه کد هدیه : $text
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ لطفاً فقط عدد ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
if(strpos($step,'SendCode-') !== false and $text != "🔙 برگشت"){
$coin = explode("-",$step)[1];
file_put_contents("gift.txt","$text~$coin");
$connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✨ کد هدیه ( `$text` ) با مقدار ( `$coin` ) سکه ساخته شد
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($text == "💭 پیام به کاربر"){
$connect->query("UPDATE user SET step = 'Sendid' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✔️ ای دی عددی کاربر مورد نظر را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
if($step == "Sendid" and $text != "🔙 برگشت"){
if(is_numeric($text)){
if(mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `user` WHERE `id` = '$text' LIMIT 1")) == true){
$connect->query("UPDATE user SET step = 'SendPm-$text' WHERE id = '$from_id' LIMIT 1");
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
💬 پیام خود را ارسال کنید !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
❗️این کاربر در ربات نیست . . .
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}else{
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
⚠️ لطفاً فقط ایدی عددی ارسال کنید بصورت عدد !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
}
}
if(strpos($step,'SendPm-') !== false and $text != "🔙 برگشت"){
$pm_id = explode("-",$step)[1];
bot('SendMessage',[
'chat_id'=>$from_id,
'text'=>"
✅ پیام شما با موفقیت به کاربر ( `$pm_id` ) ارسال شد !
",
'parse_mode'=>'MarkDown',
'reply_markup' => json_encode([
'resize_keyboard'=>true,
'keyboard' => [
[['text'=>'🔙 برگشت']],
]])
]);
bot('SendMessage',[
'chat_id'=>$pm_id,
'text'=>"
🌹 شما یک پیام از پشتیبانی دارید 

✔️ پیام : `$text`
",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🆘 پیام به پشتیبانی",'callback_data'=>"support"]],
],
])
]);
}
}
if(is_file("error_log")){
unlink("error_log");
}
/*
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
اسکی میری منبع بزن 🌹
❄️ نوشته شده توسط @TKPHP | تک پسر
✅ اپن شده در @Sourrce_kade | سورس کده
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
*/
?>