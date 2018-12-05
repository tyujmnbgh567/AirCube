<?
$start=@$_POST['start'];
$end=@$_POST['end'];
$place1=@$_POST['place1'];
$link=mysqli_connect("localhost","root","")or die("無法連結");
mysqli_select_db($link,"test") or die("無法開啟資料庫");
mysqli_query($link, 'SET CHARACTER SET utf8');//將資料設為utf8格式(才能讀取中文)
mysqli_query($link, "SET collation connection='utf_general_ci'");
$path="SELECT*FROM `path` where `route` like '".$start.'-->'.$end."'";
$resultpath=mysqli_query($link, $path);
$countpath=mysqli_num_rows($resultpath);
//echo $countpath;
if($countpath==0){
  echo "right";
}else if($countpath!=0){
  echo "left";
}
?>