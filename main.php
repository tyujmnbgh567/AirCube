<?
session_start();
if(@$_POST["test"]=="1"){
session_unset();
}
date_default_timezone_set("Asia/Taipei");
$time=date("Y-m-d h:i:s", time());
$link=mysqli_connect("localhost","root","") or die("無法連結");
mysqli_select_db($link,"test") or die("無法開啟資料庫");
mysqli_query($link,'SET CHARACTER SET utf8');
mysqli_query($link, "SET collation connection='utf_general_ci");

$mail="SELECT*FROM `mapregister` WHERE myemail  like '".@$_SESSION["a"]."'";//顯示使用者
$resultmail=mysqli_query($link,$mail);
$countmail=mysqli_num_rows($resultmail);
$datamail=mysqli_fetch_assoc($resultmail);

$_SESSION['userName']=$datamail['userName'];
$_SESSION['photo']=$datamail['photo'];

$query="SELECT*FROM `mapboard` WHERE  route like '".@$_POST['myText']."'";//顯示留言
$resultboard=mysqli_query($link, $query);
$countboard=mysqli_num_rows($resultboard);
$databoard=mysqli_fetch_assoc($resultboard);

$queryroute="SELECT*FROM `path` where route='".@$_POST['myText']."'";//顯示經緯度
$resultroute=mysqli_query($link, $queryroute);
$countroute=mysqli_num_rows($resultroute);
$dataroute=mysqli_fetch_assoc($resultroute);

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    
    <title>Other Directions</title>
    <script type='text/javascript' src='https://code.jquery.com/jquery-1.9.1.min.js'></script>
    <script type='text/javascript'>
      $(function(){
        $("#flip").click(function(){
        $("#panel").slideToggle("slow");
        $(".xs1").toggle();
        $(".xs2").toggle();
      });
    });
    </script>
    <script>
    var pass=function(){//輸入留言
    var route=$('#route').val();
    var message=$('#message').val();    
      $.ajax({
          url:"create.php",
          data: "&route="+route+"&message="+message,
          type:"POST",
          dataType:'text',
          success: function(hint){          
          },
          error: function(jqXHR, textStatus, errorThrown){ 
          }
      }); 
    }

    </script>
    <script type="text/javascript">

      var c=[];
      var d;
      var map;
      var directionsDisplay;
      var directionsService;          

      function initMap() {

        directionsDisplay=new google.maps.DirectionsRenderer();
        directionsService=new google.maps.DirectionsService();    
          var map = new google.maps.Map(document.getElementById('map'), {
            center:{lat:24,lng:121},
            zoom: 8
            });
        directionsDisplay.setMap(map);
          var logreg = document.getElementById('logreg');
          var total = document.getElementById('total');
          var color = document.getElementById('color');
          
          map.controls[google.maps.ControlPosition.TOP_RIGHT].push(logreg);
          map.controls[google.maps.ControlPosition.TOP_RIGHT].push(total);
          map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(color);
          
        var infowindow=new google.maps.InfoWindow();
        calculateAndDisplayRoute(map);
  }
   function calculateAndDisplayRoute(map) {
      
var locs=[new google.maps.LatLng(25.298415,121.537145),new google.maps.LatLng(23.7485306,120.25626620000003),new google.maps.LatLng(23.0495603,121.16463390000001),new google.maps.LatLng(23.5706269,119.57746159999999),new google.maps.LatLng(24.3487792,118.3285644),new google.maps.LatLng(26.160243,119.95166519999998),new google.maps.LatLng(23.9932872,120.96468660000005),new google.maps.LatLng(22.6083352,120.31172220000008),new google.maps.LatLng(25.0103251,121.51453530000003),new google.maps.LatLng(23.712201,120.68900550000001),new google.maps.LatLng(24.9721514,121.20539630000007),new google.maps.LatLng(25.0614534,121.48671139999999),new google.maps.LatLng(24.631919,121.75374039999997),new google.maps.LatLng(24.7591148,121.75374039999997),new google.maps.LatLng(25.0921827,121.51727219999998),new google.maps.LatLng(23.9910732,121.61119489999999),new google.maps.LatLng(22.7972447,121.07137020000005),new google.maps.LatLng(22.0008277,120.74476379999999),new google.maps.LatLng(22.5294168,120.5624474),new google.maps.LatLng(22.6558442,120.47032579999996),new google.maps.LatLng(22.5553185,120.36084549999998),new google.maps.LatLng(22.5970794,120.31472080000003),new google.maps.LatLng(22.6254162,120.29453620000004),new google.maps.LatLng(22.6877358,120.29165239999998),new google.maps.LatLng(22.7175372,120.30318710000006),new google.maps.LatLng(22.4986756,120.4011911),new google.maps.LatLng(22.584481,120.4011911),new google.maps.LatLng(22.6113591,120.3493158),new google.maps.LatLng(22.6947932,120.36084549999998),new google.maps.LatLng(22.7539012,120.30895409999994),new google.maps.LatLng(22.885385,120.55093579999993),new google.maps.LatLng(22.9997281,120.22702770000001),new google.maps.LatLng(23.0585336,120.13583459999995),new google.maps.LatLng(23.1402613,120.30895409999994),new google.maps.LatLng(23.308747,120.312906),new google.maps.LatLng(23.4800751,120.44911130000003),new google.maps.LatLng(23.7229714,120.19356629999993),new google.maps.LatLng(23.4464152,120.25704210000004),new google.maps.LatLng(23.538123,120.3550808),new google.maps.LatLng(23.7601594,120.3531749),new google.maps.LatLng(23.7077947,120.54090889999998),new google.maps.LatLng(23.9179637,120.67750539999997),new google.maps.LatLng(23.9141358,120.4011911),new google.maps.LatLng(24.1316695,120.46220160000007),new google.maps.LatLng(24.0716583,120.5624474),new google.maps.LatLng(24.1769764,120.6424333),new google.maps.LatLng(24.1588789,120.66361430000006),new google.maps.LatLng(24.1046899,120.68121139999994),new google.maps.LatLng(24.2377939,120.58546739999997),new google.maps.LatLng(24.2521156,120.72235720000003),new google.maps.LatLng(24.3892633,120.76947599999994),new google.maps.LatLng(24.5711502,120.81543579999993),new google.maps.LatLng(24.6884438,120.90248359999998),new google.maps.LatLng(24.8138287,120.96747979999998),new google.maps.LatLng(24.774922,121.04497679999997),new google.maps.LatLng(24.8814458,121.04497679999997),new google.maps.LatLng(24.8444927,121.20539630000007),new google.maps.LatLng(24.9296022,121.20539630000007),new google.maps.LatLng(25.0359365,121.11375440000006),new google.maps.LatLng(25.0492632,121.19394499999999),new google.maps.LatLng(24.9936281,121.30097980000005),new google.maps.LatLng(25.0627243,121.51130639999997),new google.maps.LatLng(25.0541591,121.56386210000005),new google.maps.LatLng(25.021694,121.52747870000007),new google.maps.LatLng(25.0262857,121.49702939999997),new google.maps.LatLng(25.0792018,121.54270930000007),new google.maps.LatLng(25.0950492,121.52460769999993),new google.maps.LatLng(25.1719805,121.44337059999998),new google.maps.LatLng(25.0790108,121.38813779999998),new google.maps.LatLng(25.057179,121.48613799999998),new google.maps.LatLng(25.0265985,121.41783469999996),new google.maps.LatLng(25.0114095,121.46184149999999),new google.maps.LatLng(24.968371,121.43803400000002),new google.maps.LatLng(24.978282,121.53948220000007),new google.maps.LatLng(25.1676024,121.63971839999999),new google.maps.LatLng(25.0616059,121.63971839999999),new google.maps.LatLng(25.1276033,121.73918329999992)];
        var startlat="<?echo $dataroute['startlat'];?>";
        var startlng="<?echo $dataroute['startlng'];?>";
        var endlat="<?echo $dataroute['endlat'];?>";
        var endlng="<?echo $dataroute['endlng'];?>";
        var directionsService = new google.maps.DirectionsService;
        var request={
            origin: {lat:Number(startlat),lng:Number(startlng)},
            destination:{lat:Number(endlat),lng:Number(endlng)},
          provideRouteAlternatives: true,
          travelMode: 'DRIVING'
        };
        directionsService.route(request, function(response, status) {
      if (status === 'OK') {
            /*for (var x = 0, len = response.routes.length; x < len; x++) {
                new google.maps.DirectionsRenderer({
                    map: map,
                    directions: response,  //加上 '//' 即可隱藏路線
                    routeIndex: x,
                });
            }*/
        console.log(response);
        var length=[]; var len2=[]; var lengthindex='';
        for(var q=0;q<response.routes.length;q++){
          len2=response.routes[q].legs[0].distance.text.split(" ");
          length.push(Number(len2[0]));
        }
        lengthindex=length.indexOf(Math.min.apply(Math,length));
        console.log(lengthindex);

        var num='1';
        var value=0;
        var start=0;
        var start1=0;
        var start2=0;
        var start3=0;
        var pm1=0;
        var pm2=0;
        var pm3=0;
        var array=[];
        
        var u='';
        var a='';
        var b='';
        var c='';
        var a1='';
        var b1='';
        var c1=''; 
        var p='';
        var a2=[];
        var b2=[];
        var c2=[];
        var d2=[];
        var e2=[];
        var a3=[];
        var b3=[];
        var c3=[];
        var d3=[];
        var e3=[];
        var a4=[];
        var b4=[];
        var c4=[];
        var d4=[];
        var e4=[];
        var epa="https://opendata.epa.gov.tw/webapi/api/rest/datastore/355000000I-000207/?format={json}&token=m/Z4PvvuD0+CR9FQxw9HFg&callback=?";
        $.getJSON(epa,function(){
          format:"json"
        }).done(function(data){

        var infowindow = new google.maps.InfoWindow();
        for(var x=0;x<response.routes.length;x++){
              var index=[];
              index.push(x);
                      
          for(var i=0;i<77;i++){
              if(google.maps.geometry.poly.isLocationOnEdge(locs[i],new google.maps.Polyline({path:google.maps.geometry.encoding.decodePath(response.routes[x].overview_polyline)}),0.015)){                

              var ppm=Number(data["result"]["records"][i]["PM25"]);

              var pmvalue=[];

              pmvalue.push(data["result"]["records"][i]["PM25"]);
              value=value+Number(data["result"]["records"][i]["PM25"]);
              num=num*data["result"]["records"][i]["PM25"];
              start=start+1;
              if(x==0){
                pm1=pm1+Number(data["result"]["records"][i]["PM25"]);
                start1=start1+1;
                a=response.routes[0].summary;
                a1=response.routes[0].legs[0].distance.text;
                a2.push(locs[i]);
                a3.push(data["result"]["records"][i]["PM25"]);
                a4.push(data["result"]["records"][i]["Site"]);
              }
              else if(x==1){
                pm2=pm2+Number(data["result"]["records"][i]["PM25"]);
                start2=start2+1;
                b=response.routes[1].summary;
                b1=response.routes[1].legs[0].distance.text;
                b2.push(locs[i]);
                b3.push(data["result"]["records"][i]["PM25"]);
                b4.push(data["result"]["records"][i]["Site"]);
              }
              else if(x==2){
                pm3=pm3+Number(data["result"]["records"][i]["PM25"]);
                start3=start3+1;
                c=response.routes[2].summary;
                c1=response.routes[2].legs[0].distance.text;
                c2.push(locs[i]);
                c3.push(data["result"]["records"][i]["PM25"]);
                c4.push(data["result"]["records"][i]["Site"]);
              }
              if(pm3!=""){
                array=[(pm1/start1),(pm2/start2),(pm3/start3)];
              }
              else{
                array=[(pm1/start1),(pm2/start2)];
              }
              y=array.indexOf(Math.min.apply(Math,array));
              
              u=Math.min.apply(Math,array);
              if(y==0){
                d2=a2;
                d3=a3;
                d4=a4;
              }else if(y==1){
                d2=b2;
                d3=b3;
                d4=b4;
              }else if(y==2){
                d2=c2;
                d3=c3;
                d4=c4;
              }
              if(lengthindex==0){
                e2=a2;
                e3=a3;
                e4=a4;
              }else if(lengthindex==1){
                e2=b2;
                e3=b3;
                e4=b4;
              }else if(lengthindex==2){
                e2=c2;
                e3=c3;
                e4=c4;
              }
              document.getElementById("pan").innerHTML='PM2.5更新時間:'+data["result"]["records"][0]["DataCreationDate"];
              /*if(response.routes.length==3){
                document.getElementById("pan3").innerHTML=a+':'+String(pm1/start1)+'<br>'+a1+'<p>'+b+':'+String(pm2/start2)+'<br>'+b1+'<p>'+c+':'+String(pm3/start3)+'<br>'+c1;                
              }
              else{
                document.getElementById("pan3").innerHTML=a+':'+String(pm1/start1)+'<br>'+a1+'<p>'+b+':'+String(pm2/start2)+'<br>'+b1;                
              }*/
          
             }
            }
           };
            show(directionsService,startlat,startlng,endlat,endlng,map,y,lengthindex,d2,e2,d3,e3,d4,e4);
        });
      } else {
        window.alert('Directions request failed due to ' + status);
      }
    });
  }
  function show(directionsService,startlat,startlng,endlat,endlng,map,y,lengthindex,d2,e2,d3,e3,d4,e4){
var a='';
      var infowindow = new google.maps.InfoWindow();
          var ww='';
          var selectedMode = document.getElementById('mode').value;
          if(selectedMode=='pm'){
            for(var i=0;i<d2.length;i++){
                if(d3[i]<=15){
                  ww='http://maps.google.com/mapfiles/ms/icons/green-dot.png';
                }
                else if((d3[i]>15)&&(d3[i]<=20)){
                  ww='http://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
                }else if((d3[i]>20)&&(d3[i]<=25)){
                  ww='http://maps.google.com/mapfiles/ms/icons/orange-dot.png';
                }else if((d3[i]>25)&&(d3[i]<=30)){
                  ww='http://maps.google.com/mapfiles/ms/icons/red-dot.png';
                }else if(d3[i]>30){
                  ww='http://maps.google.com/mapfiles/ms/icons/purple-dot.png';
                }
                  var marker=new google.maps.Marker({
                      icon:ww,
                      position:d2[i],
                      map:map
                  });
              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
              infowindow.setContent(d4[i]+','+d3[i]);
                  infowindow.open(map, marker);
                }
              })(marker, i));              
            }              
          }else{
            for(var i=0;i<e2.length;i++){
                if(e3[i]<=15){
                  ww='http://maps.google.com/mapfiles/ms/icons/green-dot.png';
                }
                else if((e3[i]>15)&&(e3[i]<=20)){
                  ww='http://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
                }else if((e3[i]>20)&&(e3[i]<=25)){
                  ww='http://maps.google.com/mapfiles/ms/icons/orange-dot.png';
                }else if((e3[i]>25)&&(e3[i]<=30)){
                  ww='http://maps.google.com/mapfiles/ms/icons/red-dot.png';
                }else if(e3[i]>30){
                  ww='http://maps.google.com/mapfiles/ms/icons/purple-dot.png';
                }
                  var marker=new google.maps.Marker({
                      icon:ww,
                      position:e2[i],
                      map:map
                  });
              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
              infowindow.setContent(e4[i]+','+e3[i]);
                  infowindow.open(map, marker);
                }
              })(marker, i));              
            } 
          }
          var selectedMode = document.getElementById('mode').value;
          if(selectedMode=='pm'){
              a=y;
            }else{
              a=lengthindex;
            }
              directionsService.route({
                origin: {lat:Number(startlat),lng:Number(startlng)},
                destination:{lat:Number(endlat),lng:Number(endlng)},
                provideRouteAlternatives: true,
                travelMode: 'DRIVING'
              }, function(response, status) {
                console.log(response);
                if (status === 'OK') {
                  new google.maps.DirectionsRenderer({
                        map: map,
                        directions:response, 
                        routeIndex:Number(a),
                  });               
                }else {
                  window.alert('Directions request failed due to ' + status);
                }                
               }
              );
}
 </script>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */

   #content{
    margin:0px;
    padding:5px;
    height:100%;
    width:500px;
    line-height:30px;
    font-size:30px;
    float:left;
    text-align:left;
    background:#F5F5F5;
    border:solid 1px #c3c3c3;
    font-family:'Arial';
    font-weight:bold;
  }

  #map{

    height: 100%;
  }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    #flip{
      margin:0px;
      padding:5px;
      text-align:center;
      cursor:pointer;
      font-family:'Arial';
      width:200px;
    }
    #panel{
      margin:0px;
      padding:5px;
      font-size:20px;
      text-align:center;
      background:#FFFFFF;
      border:solid 1px #c3c3c3;
      display:none;
      font-family:'Arial';
      width:200px;
    } 

      /* Optional: Makes the sample page fill the window. */
    </style>
  </head>
  <body>

    <div id="content" style="overflow:scroll;height:100%;width:400px;background-color:#fffaf3;">
    <div id="pan" style="font-size:30px;"></div>
    <select id="place" style="height:50px;width:120px;font-size:25px;">
    <option value="">請選擇</option>
    <?
    $path="SELECT*FROM `path` WHERE 1 ORDER BY `ID`";
    $resultpath=mysqli_query($link,$path);
    $countpath=mysqli_num_rows($resultpath);
    for($i=0;$i<$countpath;$i++){
    $datapath=mysqli_fetch_assoc($resultpath); 
    ?><option value=""><?echo $datapath['route'];?></option><?
    }
    ?>
    </select>

    <script>
    var select = document.getElementById('place');

    function myFunction(event) {
      var color = 'No place selected';
      if (select.selectedIndex > 0) {
          color = select.item(select.selectedIndex).textContent;
          document.getElementById('myText').value = color;
        }
      }
    select.addEventListener('click', myFunction);

    myFunction();
    </script>
    <form id="formid" method="POST" action="">
    <input type="text" id="myText" name="myText" style="visibility:hidden"><br>
    <button id="button" style="width:100px;height:40px;font-size:20px;">submit</button> 
  
    <!--<input type="submit" id="buttonid" value="查看路徑" onclick="initMap()">-->
    </form>  
    <select id="mode" onchange="initMap();" style="height:50px;width:100px;font-size:25px;">
      <option value="pm">pm2.5</option>
      <option value="path">path</option>
    </select><br><br>
    <input type="button" value="規劃路徑" onclick="location.href='map2.php'" style="width:100px;height:40px;font-size:20px;">
    <div id="idroute">
    <?echo $dataroute['route'];?>
    </div><br><br><br>
    <hr></hr>
    撰寫評論
    <form method="POST" action="">
    <textarea name="message" id="message" style="width:350px;height:100px;"></textarea><br>
    <input type="hidden" name="route" id="route" value=<? echo "\"".$dataroute['route']."\"";?>>    
    <input type="submit" name="submit" onclick="pass()" style="width:100px;height:40px;font-size:20px;"> 

    </form>
    <hr></hr>
    <div id="hint">討論區<br>
    <?
    $word=$databoard['word'];
    $data = json_decode($word,true);
    if($word!=""){
      foreach($data as $value){
      echo $value['name']."<br>";
      echo nl2br($value['text'])."<br>";
      echo $value['time']."<br>";
      echo "========================"."<br>"; 
      } 
    }
    ?>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>

    <div id="map"></div>
    <?if(@$_SESSION["b"] == 0){
      ?><div id="logreg" ><a href ="0709.php"><img src="image/register.png" border="0" width="100"/></a><?
      ?><a href ="login.php"><img src="image/login.png" border="0" width="100"/></a></div><?
    }else {
      ?>
      <div id="total" style="visibility:hidden">
        <div id="flip"><?echo "<img src=\"image/".$datamail['photo'].".jpg\" width=\"70\">";?></div>
        <div id="panel"><?echo $datamail['userName']."歡迎回來";?></div>
      </div>  
      <?         
      }?>
      <table id="color" border="0" height="600">
        <tr>
          <td style="background-color:#00FF00;font-size:25px;">0~15</td>
          <td style="width:50px;"><img src="http://maps.google.com/mapfiles/ms/icons/green-dot.png"></td>
        </tr>
        <tr>
          <td style="background-color:#FFFF77;font-size:25px;">16~20</td>
          <td style="width:50px;"><img src="http://maps.google.com/mapfiles/ms/icons/yellow-dot.png"></td>
        </tr>
        <tr>
          <td style="background-color:#FF8C00;font-size:25px;">21~25</td>
          <td style="width:50px;"><img src="http://maps.google.com/mapfiles/ms/icons/orange-dot.png"></td>
        </tr>
        <tr>
          <td style="background-color:#FF8888;font-size:25px;">26~30</td>
          <td style="width:50px;"><img src="http://maps.google.com/mapfiles/ms/icons/red-dot.png"></td>
        </tr>
        <tr>
          <td style="background-color:#9370DB;font-size:25px;">超過30</td>
          <td style="width:50px;"><img src="http://maps.google.com/mapfiles/ms/icons/purple-dot.png"></td>
        </tr>
      </table>
      
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBXzQEMKDbv-Cd1DyefhIXwNI_hfz-B7M&callback=initMap"
    async defer></script>
  </body>
</html>
            <!--var miao={lat:24.3892633,lng:120.76947599999994};
            var cascadiaFault = new google.maps.Polyline({
              path: [
                {lat:24.37581,lng:120.74935000000005}
              ]
            });
             cascadiaFault.setMap(map);
            if(google.maps.geometry.poly.isLocationOnEdge(miao,cascadiaFault,0.05)){
              alert("success");
            }-->