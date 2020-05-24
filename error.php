<?php
session_start();
$name = $_SESSION['name'];
$phone = $_SESSION['phone'];

if($_SESSION['datetime'] == "-")
  echo("<script>location.replace('main.html');</script>");
else {
  $datetime = $_SESSION['datetime'];
$dbconnect = mysqli_connect("175.126.232.180","root","0415554970");

$temp = explode(' ', $datetime);

$date = $temp[0];
$time = $temp[1];

if(!$dbconnect){
die("0<br>".mysqli_error());
}

$flag = mysqli_select_db($dbconnect,"inofarm");
mysqli_query($dbconnect, "SET NAMES utf8");

$query = "select camnum from imgpathtable where username = '$name' and phone = '$phone';";
$result = mysqli_query($dbconnect, $query) or die (mysqli_error($dbconnect));

$row = mysqli_fetch_array($result);

$camnum = $row[0];

$query = "delete from imgpathtable where username = '$name' and phone = '$phone' and datetime = '$datetime';";

$result = mysqli_query($dbconnect, $query) or die (mysqli_error($dbconnect));

$query = "select ip from userinfo where name = '$name' and phone = '$phone';";
$result = mysqli_query($dbconnect, $query) or die (mysqli_error($dbconnect));

$row = mysqli_fetch_array($result);

$ip = $row[0];

mysqli_close($dbconnect); //연결 종료.

$dbconnect = mysqli_connect($ip,"root","0415554970");

$flag = mysqli_select_db($dbconnect,"cms");
//select()를 이용하여 특정 테이블에 연결. 성공한다면 1.
if(!$flag) die("0<br>".mysqli_error());

$query = "delete from heatalarmlist where date = \"$date\" and time = \"$time\" and number = $camnum";
mysqli_query($dbconnect, "SET NAMES utf8"); //한글 출력을 위한 캐릭터셋팅.
$result = mysqli_query($dbconnect, $query) or die (mysqli_error($dbconnect));  //질의.

$query = "update heatalarmupdate set isupdate = 1, type = 1";
mysqli_query($dbconnect, "SET NAMES utf8"); //한글 출력을 위한 캐릭터셋팅.
$result = mysqli_query($dbconnect, $query) or die (mysqli_error($dbconnect));  //질의.

mysqli_close($dbconnect); //연결 종료.

echo("<script>location.replace('main.html');</script>");
}


?>
