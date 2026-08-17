<?php
/*
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
اسکی میری منبع بزن 🌹
❄️ نوشته شده توسط @TKPHP | تک پسر
✅ اپن شده در @Sourrce_kade | سورس کده
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
*/
@$server = 'localhost';
@$username = 'flashself_bots';
@$password = 'yXWTvNfnx9FB';
@$db = 'flashself_bots';
$connect = mysqli_connect($server,$username,$password,$db);
//========================== // table creator // ==============================
mysqli_multi_query($connect,"CREATE TABLE `user` (
   `id` bigint PRIMARY KEY,
	`coin` int NOT NULL,
	`inv` int DEFAULT '0',
	`step` TEXT DEFAULT NULL,
	`star` TEXT DEFAULT NULL,
	`warn` varchar(10) DEFAULT NULL,
	`time` varchar(20) DEFAULT NULL,
	`date` varchar(30) DEFAULT NULL,
	`self` varchar(40) DEFAULT NULL,
	`tabchi` varchar(50) DEFAULT NULL,
	`clicker` varchar(60) DEFAULT NULL,
	`type` varchar(70) DEFAULT NULL,
	`ok` varchar(80) DEFAULT NULL,
	`phone` varchar(100) DEFAULT NULL,
	`listself` TEXT DEFAULT NULL,
	`listclicker` TEXT DEFAULT NULL,
	`listtabchi` TEXT DEFAULT NULL
    ) default charset = utf8mb4;");
//========================== // Check connection // ==============================
if ($connect->connect_error) {
   die("خطا در ارتصال به خاطره :" . $connect->connect_error);
}
  echo "دیتابیس متصل و نصب شد ."
/*
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
اسکی میری منبع بزن 🌹
❄️ نوشته شده توسط @TKPHP | تک پسر
✅ اپن شده در @Sourrce_kade | سورس کده
••••••••••••••••••••••••••••••••••••••••••••••••••••••••••
*/
?>