<?php
session_start();
$name = $_SESSION['name'];
$phone = $_SESSION['phone'];
$dbconnect = mysqli_connect("175.126.232.180","root","0415554970");

if(!$dbconnect){
die("0<br>".mysqli_error());
}

$flag = mysqli_select_db($dbconnect,"inofarm");
$query = "SELECT imgpath FROM imgpathtable where username = '$name' and phone = '$phone' order by idx desc limit 1;";
mysqli_query($dbconnect, "SET NAMES utf8"); //한글 출력을 위한 캐릭터셋팅.
$result = mysqli_query($dbconnect, $query) or die (mysqli_error($dbconnect));

$num = mysqli_num_rows($result);

if($num != 0)
{
  $row = mysqli_fetch_array($result);

  $_SESSION['datetime'] = $row[0];

  echo $row[0];
}
else {
  echo "C:/Innobis/image/noalarm.png";
}

?>
