<script>
  var name;
  var phone;
  function setLocalstorage(n,p){
    name = n;
    phone = p;

    localStorage.setItem('name', name);
    localStorage.setItem('phone', phone);
    //alert(name);
    //alert(phone);

    location.replace('main.html');
  }

  function setSessionstorage(n,p){
    name = n;
    phone = p;

    sessionStorage.setItem('name', name);
    sessionStorage.setItem('phone', phone);
    //alert(name);
    //alert(phone);

    location.replace('main.html');
  }

</script>

﻿<?php
session_start();
$dbconnect = mysqli_connect("175.126.232.180","root","0415554970");
// mysql_connect()를 이용하여 DB에 연결. 성공한다면 1.

if(!$dbconnect){ //실패시 종료
 die("0<br>".mysqli_error());
}
 //echo "1<br>";

$flag = mysqli_select_db($dbconnect,"inofarm");
//select()를 이용하여 특정 테이블에 연결. 성공한다면 1.
if(!$flag) die("0<br>".mysqli_error());

$name = $_POST['loginId'];
$phone = $_POST['password'];

$devicekeys = "<script language=javascript> localStorage.getItem("devicekey");</script>";

$query = "delete from `cma` where `name` = \"$name\" and `devicekey`= '$devicekeys';";

$result = mysqli_query($dbconnect, $query);

if(!$result) die("[SQL error]".mysqli_error($dbconnect)); //질의 실패시 종료

$query = "INSERT INTO `cma` VALUES('$name','$phone','$devicekeys', 1, 1);";

$result = mysqli_query($dbconnect, $query); //질의.
if(!$result) die("[SQL error]".mysqli_error($dbconnect)); //질의 실패시 종료

$query = "select ip from userinfo where name = \"$name\" and phone = \"$phone\"";
//qecho $query;

mysqli_query($dbconnect, "SET NAMES utf8"); //한글 출력을 위한 캐릭터셋팅.
$result = mysqli_query($dbconnect, $query) or die (mysqli_error($dbconnect));  //질의.
//echo $result;

$noOfRows = mysqli_num_rows($result);

if($noOfRows == 0)
{
  echo "none";
  echo "<script>alert(\"로그인 정보가 올바르지 않습니다.\");</script>";
  echo("<script>location.replace('index.html');</script>");
}
else
{
  $row = mysqli_fetch_array($result);

  $_SESSION['name'] = $name;
  $_SESSION['phone'] = $phone;

  if(isset($_POST['keepLogin']))
  {
    if($_POST['keepLogin'] == 'true')
    {
      //아이디 비번 저장;
      //$query = "select ip from userinfo where name = \"$name\" and phone = \"$phone\"";
      // $query = "insert into cmswebuser values(\"$name\", \"$phone\")";
      // $result = mysqli_query($dbconnect, $query) or die (mysqli_error($dbconnect));  //질의.
      echo ("<script language=javascript> setLocalstorage(\"$name\", \"$phone\");</script>");
    }
  }

  else {
    echo ("<script language=javascript> setSessionstorage(\"$name\", \"$phone\");</script>");
    // echo("<script>location.replace('main.html');</script>");
  }

}

mysqli_close($dbconnect); //연결 종료.

?>
