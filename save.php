<?
$mail=@$_POST['mail'];

$password=@$_POST['password'];

$link=mysqli_connect("localhost","root","")or die("無法連結");
mysqli_select_db($link,"test") or die("無法開啟資料庫");
mysqli_query($link, 'SET CHARACTER SET utf8');//將資料設為utf8格式(才能讀取中文)
mysqli_query($link, "SET collation connection='utf_general_ci'");
$query="SELECT*FROM `mapregister` where myemail like '".$mail."'";
$name="SELECT*FROM `mapregister` where password like '".$password."'";

$result=mysqli_query($link, $query);
$count=mysqli_num_rows($result);
$resultname=mysqli_query($link, $name);
$countname=mysqli_num_rows($resultname);

if($count==0){
  echo "true";  
}else if($countname==1){
  echo "correct";
}
?>
