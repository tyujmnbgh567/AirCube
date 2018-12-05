<?
session_start();
if(@$_POST["test"]==1){
  $_SESSION["a"]=@$_POST['mail'];
  $_SESSION["b"]=@$_POST;
}
?>  
<!DOCTYPE html>
<html> 
<head>
	<title>Log In</title>
 <script src="//code.jquery.com/jquery-2.1.1.min.js"></script> 
  <script>
var check=function(){
  var mail=$('#mail').val();
  var password=$('#password').val();
    $.ajax({
        url:"save.php",
        data: "&mail="+mail+"&password="+password,
        type:"POST",
        dataType:'text',
        success: function(message){          
         document.getElementById("message").innerHTML=message;
         if(message=="true"){
          alert("此帳號不存在");
          history.go(0)
         
         }else if(message=="correct"){
          alert("登入成功");
          window.location.assign("map2.php");
         }else{
          alert("密碼錯誤");
          history.go(0)
         }
        },
        error: function(jqXHR, textStatus, errorThrown){ 
         document.getElementById("message").innerHTML=errorThrown; 
        }
    });
}
 </script>
	 <style type="text/css">
  #header{
    background-color:#D4FFFF;
    height:50px;
    text-align:right;
    line-height:80px;
    position:absolute;
    top:0px;
    margin-top:0px;
    bottom:30px;
    right:0px;
    left:0px;
  }
  #content{
    background-color:#cecece;
    width:200px;
    height:570px;
    text-align:center;
    line-height:400px;
    float:left;
  }
  #textright{
    background-color:#cecece;
    width:200px;
    height:570px;
    text-align:center;
    line-height:400px;
    float:right;
  }
  #map{
    margin-left:120px;
    margin-right:120px;
    margin-top:50px;
    background-color:#F2FFF2;
    text-align:center;
    line-height:30px;
    height:550px;
    font-size: 30px;
    font-weight: bold;
  }
        </style>  
</head>
<body>
  <div id="header"></div>
	<div id="content" ></div>
  <div id="textright"></div>

	<div id="map">
	<form method="POST" name="data" action="" enctype="multipart/form-data">
  會員登入<p><p><p>
	帳號:
	<input type="email" name="mail" id="mail" placeholder="請輸入信箱" style="width:300px;height:50px;font-size:20px;" ><p><p><p>
	密碼:
 	<input type="password" name="password" id="password"placeholder="請輸入密碼" style="width:300px;height:50px;font-size:20px;"><p><p><p>
  <input type="hidden" name="test" value="1">
  <input type="submit" id="submit" onclick="check()" style="width:100px;height:50px;font-size:30px;">
  <input type="button" value="取消" onclick="location.href='local.php'" style="width:100px;height:50px;font-size:30px;"><p><p><p>
  <div id="message" ></div>
	</form>
	</div>
  <div id="footer"></div> 
</body>
</html>
