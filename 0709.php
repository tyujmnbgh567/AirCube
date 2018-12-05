<?
date_default_timezone_set("Asia/Taipei");
$d1=date("Ymd", time());
$d2=date("Y-m-d h:i:s", time());
$x="";
$y="";
for ($i=0; $i <4 ; $i++) { 
  $a=rand(97,122);
  $b=chr($a);
  $x=$x.$b;
}
for ($i=0; $i<4 ; $i++) { 
  $c=rand(0,9);
  $y=$y.$c;
}
$uid=$x.$d1.$y;
if (@$_FILES["file"]["error"]>0){
  //echo "Error: ".$_FILES["file"]["error"]."<br>";
}
else{
  /*echo "Upload: ".$_FILES["file"]["name"]."<br>";
  echo "Type: ".$_FILES["file"]["type"]."<br>";
  echo "Size: ".$_FILES["file"]["size"]."<br>";
  echo "Stored in: ".$_FILES["file"]["tmp_name"]."<br>";*/
  move_uploaded_file(@$_FILES["file"]["tmp_name"],"image/".$uid.".jpg");
}

$link=mysqli_connect("localhost","root","")or die("無法連結");
mysqli_select_db($link,"test") or die("無法開啟資料庫");
mysqli_query($link, 'SET CHARACTER SET utf8');//將資料設為utf8格式(才能讀取中文)
mysqli_query($link, "SET collation connection='utf_general_ci'");

$query="SELECT*FROM `mapregister` where myemail='".@$_POST['mail']."'";
$result=mysqli_query($link, $query);
$count=mysqli_num_rows($result);
$data=mysqli_fetch_assoc($result);
if($count==0){
  $query="INSERT INTO `mapregister`(`userName`,`UID`,`password`,`myemail`,`bday`,`gender`,`photo`,`time`) VALUES('".$_POST['username']."','".$uid."','".$_POST['password']."','".$_POST['mail']."','".$_POST['bday']."','".@$_POST['gender']."','".$uid."','".$d2."')";    
}
mysqli_query($link,$query);
?>
<!DOCTYPE html>
<html> 
<head>
	<title>Register</title>
 <script src="//code.jquery.com/jquery-2.1.1.min.js"></script> 
  <script>
var check=function(){
  var mail=$('#mail').val();  
    $.ajax({
        url:"save.php",
        data: "&mail="+mail,
        type:"POST",
        dataType:'text',
        success: function(message){          
         document.getElementById("message").innerHTML=message;
         crucial=document.getElementById("mail").value.indexOf("@");
           if((document.data.username.value=="")&&(document.data.password.value=="")&&(document.data.mail.value=="")&&(document.data.bday.value=="")&&( document.data.gender.value=="")){
            alert("尚有資料未填寫");
            history.go(0)
            exit(1);            
           }
           else if(crucial==-1){
            alert("電子郵件格式有誤");
            history.go(0)
           }
           else if(message=="true"){
            alert("註冊成功");
            window.location.assign("map2.php");
           }                        
           else{
            alert("此帳號或暱稱已有人使用");
            history.go(0)
            }           
        },
        error: function(jqXHR, textStatus, errorThrown){ 
         document.getElementById("message").innerHTML=errorThrown; 
        }
    });
}
    </script>
	        <style>
          #header{
          background-color:#cecece;
          width:"100";
          height:50px;
          text-align:right;
          line-height:80px;
          position:fixed;
          top:0px;
          bottom:30px;
          right:0px;
          left:0px;
          }
          #content{
            width:280px;
            float:left;
            height:570px;
            text-align: left;
            background-color:#cecece;
            font-size:25px;
            font-weight:bold;/*文字粗細*/
            position: absolute;  
            margin-top:19px;
            left:0px;
          }     
          #map { 
            height:650px;    
            width:1000px;   
            text-align:center;
            line-height: 30px;
            font-size: 30px;
            font-weight: bold;   
            background-color:#F5F5F5;
            float:left;
            position: fixed;
            left:400px; 
            margin-top:19px; 
          }  
        </style>  
}
</head>
<body>


	<div id="map">
	<form method="POST" name="data" action="" enctype="multipart/form-data">
  會員註冊<p><p><p>
	使用者名稱:
	<input type="text" name="username" id="username" placeholder="請輸入暱稱" style="width:300px;height:50px;font-size:20px;"><p><p><p>
	帳號(電子信箱):
	<input type="email" name="mail" id="mail" placeholder="請輸入信箱" style="width:300px;height:50px;font-size:20px;" ><p><p><p>
	密碼:
 	<input type="password" name="password" placeholder="請輸入密碼" style="width:300px;height:50px;font-size:20px;"><p><p><p>
	生日:
	<input type="date" name="bday" style="width:300px;height:50px;font-size:20px;"><p><p><p>
	性別:
	<input type="radio" name="gender" value="male" >男
	<input type="radio" name="gender" value="female" >女<p><p><p>
	<label for="file"> 請選擇大頭貼照:</label>
  <input type="file" name="file" id="file" style="width:300px;height:50px;font-size:20px;"><p><p><p>
  <input type="submit" id="submit" onclick="check()" style="width:100px;height:50px;font-size:30px;">
  <div id="message"  style="visibility:hidden"></div>
	</form>
	</div> 
</body>
</html>

