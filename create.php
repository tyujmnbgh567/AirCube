<?
session_start();
date_default_timezone_set("Asia/Taipei");
$time=date("Y-m-d h:i:s", time());
$route=@$_POST['route'];
$message=@$_POST['message'];
$link=mysqli_connect("localhost","root","") or die("無法連結");
mysqli_select_db($link,"test") or die("無法開啟資料庫");
mysqli_query($link,'SET CHARACTER SET utf8');
mysqli_query($link, "SET collation connection='utf_general_ci");

$select="SELECT*FROM `path` WHERE  route like '".$route."'";
$result=mysqli_query($link, $select);
$count=mysqli_num_rows($result);
$data=mysqli_fetch_assoc($result);

$query="SELECT*FROM `mapboard` WHERE  route like '".$route."'"; 
$resultboard=mysqli_query($link, $query);
$countboard=mysqli_num_rows($resultboard);
$databoard=mysqli_fetch_assoc($resultboard);

$noword='['."{"."\"name\"".':'."\"".$_SESSION['userName']."\"".','."\"text\"".':'."\"".$message."\"".','."\"time\"".':'."\"".$time."\""."}".']';
$word=$databoard['word'];
$word1=explode("]",$word);
//$word2 = $word1[0].','.'{'."\"text\"".':'."\"".@$_POST['message']."\"".'}'.']';
$word2 = $word1[0].','.'{'."\"name\"".':'."\"".$_SESSION['userName']."\"".','."\"text\"".':'."\"".$message."\"".','."\"time\"".':'."\"".$time."\"".'}'.']';
if($message != ""){
  
  	if($countboard == 0){
		$insert="INSERT INTO `mapboard`(`word`,`route`) VALUES('".$noword."','".$route."');";
		mysqli_query($link,$insert);//資料表內無任何資料

  	}else{

		$insert2=" UPDATE `mapboard` SET `word`='".$word2."' WHERE `route` like '".$route."';";
		mysqli_query($link,$insert2);

	}
}
?>

<!--ajax傳route後丟select再把count寫進if的判斷  
