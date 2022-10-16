<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game_db";


$con = mysqli_connect($servername, $username, $password); // للأتصال بمخدم قواعد البيانات 

if ($con) {
  // echo "تمت عملية الإتصال بالسيرفر بنجاح";
} else {
  echo "لم يتم الاتصال حصل خطأ";
}


$con_db = mysqli_connect($servername, $username, $password, $dbname); // للأتصال بمخدم قواعد البيانات والداتابيز 

$sql = "";

if ($con_db) {
  // echo "تم الاتصال بالداتابيز بنجاح";
} else {
  echo "لم يتم الاتصال بالداتا بيز حصل خطأ";
}
