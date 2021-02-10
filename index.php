<?php
require 'api.php';

$class = new cmapi;
if(isset($_POST["link"])){
  //echo $_POST["link"].$_POST["botid"].$_POST["deviceid"].$_POST["sessiontoken"];
  echo $class->start($_POST["link"], $_POST["botid"], $_POST["deviceid"], $_POST["sessiontoken"]);
}else if(isset($_POST["invitelink"])){
  echo $class->GetInviteID($_POST["invitelink"]);
}else if(isset($_POST["invitelinkexplode"])){
  $left = explode('com/~',$_POST["invitelinkexplode"]);
  $right = explode('?s=m',$left[1]);
  echo ($right[0]);
}else if(isset($_POST["deviceleft"])){
  echo $class->GetDeviceLeft($_POST["deviceleft"]);
}else if(isset($_POST["getdevice"])){
  echo $class->GetDevice();
}else if(isset($_POST["updatedevice"])){
  echo $class->updatedevice($_POST["updatedevice"]);
}else{
  echo "NoData";
}
//echo $class->start('https://GetCoinMaster.com/~yaLD4?s=m','ror48__ckkkyh3zx00dnuul68ed18vsb', '3acc946a-f3d8-4321-9ca7-69e747130603', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6IjEifQ.eyJkZXZpY2UiOnsiaWQiOiIzYWNjOTQ2YS1mM2Q4LTQzMjEtOWNhNy02OWU3NDcxMzA2MDMifSwic2Vzc2lvbiI6eyJwbGF5ZXJJZCI6InJvcjQ4X19ja2treWgzengwMGRudXVsNjhlZDE4dnNiIiwiZXh0cmEiOnsicGxhdGZvcm0iOiJ1bmtub3duIiwicHJvZmlsZSI6IjNfNV9mYmFuZF9Qb29sIn19LCJpYXQiOjE2MTIwODYyNjQsImV4cCI6MTYxMjE0Mzg2NH0.uiNgObTzNvJlD1xK6cZ9YUbCNY5Uzb69W4AAS2U0u7c');
//echo $class->GetInviteID("https://GetCoinMaster.com/~y5DA0?s=m");
//echo $class->FacebookToken();

?>
