<?//test
date_default_timezone_set("Asia/Taipei");
$time=date("Y-m-d h:i:s", time());
session_start();
if(@$_POST["test"]=="1"){
session_unset();
}
$link=mysqli_connect("localhost","root","") or die("無法連結");
mysqli_select_db($link,"test") or die ("無法開啟資料庫");
mysqli_query($link, 'SET CHARACTER SET utf8');
mysqli_query($link, "SET collation connection='utf_general_ci'");
if(@$_POST["one"]=="2"){
  $insert="INSERT INTO `path`(`startlat`,`startlng`,`endlat`,`endlng`,`route`) VALUES('".@$_POST['place1']."','".@$_POST['place2']."','".@$_POST['place3']."','".@$_POST['place4']."','".$_POST['start'].'-->'.$_POST['end']."');";
  mysqli_query($link,$insert);
}

$mail="SELECT*FROM `mapregister` WHERE myemail  like '".@$_SESSION["a"]."'";
$resultmail=mysqli_query($link,$mail);
$countmail=mysqli_num_rows($resultmail);
$datamail=mysqli_fetch_assoc($resultmail);

$timediff=explode(" ",$time);
$timeh=explode(":",$timediff[1]);
$timed=explode("-",$timediff[0]);

$querysql="SELECT `latitude`,`longitude`,`PM`,`time` FROM `place` ORDER BY ID DESC"; 
$resultsql=mysqli_query($link, $querysql);
$countsql=mysqli_num_rows($resultsql);

$arrlat=array();
$arrlng=array();
$arrpm=array();
for($b=0; $b<$countsql; $b++){
  $datasql=mysqli_fetch_assoc($resultsql);

  $time2=explode(" ",$datasql['time']);

  $time3=explode(":",$time2[1]);
  $time4=explode("-",$time2[0]);
  $timedif=(int)$timeh[0]-(int)$time3[0];

  if(($timedif<2)&&($timed[0]==$time4[0])&&($timed[1]==$time4[1])&&($timed[2]==$time4[2])){
    array_push($arrlat,$datasql['latitude']);
    array_push($arrlng,$datasql['longitude']);
    array_push($arrpm,$datasql['PM']);
  }

}
$latnum=count($arrlat);
$lngnum=count($arrlng);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Place Autocomplete and Directions</title>
    <script type='text/javascript' src='https://code.jquery.com/jquery-1.9.1.min.js'></script>
    <script type='text/javascript'>
      $(function(){
        $("#flip").click(function(){
        $("#panel").slideToggle("slow");
        $(".xs1").toggle();
        $(".xs2").toggle();
      });
    });
      $(function(){
        $("#mark").click(function(){
        $("#content").animate({width:'toggle'},500);
        $(".xs1").toggle();
        $(".xs2").toggle();
      });
    });

    </script>
    <script type='text/javascript' src='https://code.jquery.com/jquery-1.9.1.min.js'></script>    
    <script>
      var check=function(){
        if(document.getElementById("username").value==""){
          alert("請先登入");
        }       
      }

    </script>
<script type='text/javascript' src='https://code.jquery.com/jquery-1.9.1.min.js'></script>    
    <script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
 var locations=[['富貴角',25298415,121537145],
['麥寮',23.7485306,120.25626620000003],['關山',23.0495603,121.16463390000001],['馬公',23.5706269,119.57746159999999],['金門',24.3487792,118.3285644],['馬祖',26.160243,119.95166519999998],['埔里',23.9932872,120.96468660000005],['復興',22.6083352,120.31172220000008],['永和',25.0103251,121.51453530000003],['竹山',23.712201,120.68900550000001],['中壢',24.9721514,121.20539630000007],['三重',25.0614534,121.48671139999999],['冬山',24.631919,121.75374039999997],['宜蘭',24.7591148,121.75374039999997],['陽明',25.0921827,121.51727219999998],['花蓮',23.9910732,121.61119489999999],['臺東',22.7972447,121.07137020000005],['恆春',22.0008277,120.74476379999999],['潮州',22.5294168,120.5624474],['屏東',22.6558442,120.47032579999996],['小港',22.5553185,120.36084549999998],['前鎮',22.5970794,120.31472080000003],['前金',22.6254162,120.29453620000004],['左營',22.6877358,120.29165239999998],['楠梓',22.7175372,120.30318710000006],['林園',22.4986756,120.4011911],['大寮',22.584481,120.4011911],['鳳山',22.6113591,120.3493158],['仁武',22.6947932,120.36084549999998],['橋頭',22.7539012,120.30895409999994],['美濃',22.885385,120.55093579999993],['臺南',22.9997281,120.22702770000001],['安南',23.0585336,120.13583459999995],['善化',23.1402613,120.30895409999994],['新營',23.308747,120.312906],['嘉義',23.4800751,120.44911130000003],['臺西',23.7229714,120.19356629999993],['朴子',23.4464152,120.25704210000004],['新港',23.538123,120.3550808],['崙背',23.7601594,120.3531749],['斗六',23.7077947,120.54090889999998],['南投',23.9179637,120.67750539999997],['二林',23.9141358,120.4011911],['線西',24.0716583,120.5624474],['彰化',24.1769764,120.6424333],['西屯',24.1316695,120.46220160000007],['忠明',24.1588789,120.66361430000006],['大里',24.1046899,120.68121139999994],['沙鹿',24.2377939,120.58546739999997],['豐原',24.2521156,120.72235720000003],['三義',24.3892633,120.76947599999994],['苗栗',24.5711502,120.81543579999993],['頭份',24.6884438,120.90248359999998],['新竹',24.8138287,120.96747979999998],['竹東',24.774922,121.04497679999997],['湖口',24.8814458,121.04497679999997],['龍潭',24.8444927,121.20539630000007],['平鎮',24.9296022,121.20539630000007],['觀音',25.0359365,121.11375440000006],['大園',25.0492632,121.19394499999999],['桃園',24.9936281,121.30097980000005],['大同',25.0627243,121.51130639999997],['松山',25.0541591,121.56386210000005],['古亭',25.021694,121.52747870000007],['萬華',25.0262857,121.49702939999997],['中山',25.0792018,121.54270930000007],['士林',25.0950492,121.52460769999993],['淡水',25.1719805,121.44337059999998],['林口',25.0790108,121.38813779999998],['菜寮',25.057179,121.48613799999998],['新莊',25.0265985,121.41783469999996],['板橋',25.0114095,121.46184149999999],['土城',24.968371,121.43803400000002],['新店',24.978282,121.53948220000007],['萬里',25.1676024,121.63971839999999],['汐止',25.0616059,121.63971839999999],['基隆',25.1276033,121.73918329999992]];
       function initMap() {
var locs=[new google.maps.LatLng(25.298415,121.537145),new google.maps.LatLng(23.7485306,120.25626620000003),new google.maps.LatLng(23.0495603,121.16463390000001),new google.maps.LatLng(23.5706269,119.57746159999999),new google.maps.LatLng(24.3487792,118.3285644),new google.maps.LatLng(26.160243,119.95166519999998),new google.maps.LatLng(23.9932872,120.96468660000005),new google.maps.LatLng(22.6083352,120.31172220000008),new google.maps.LatLng(25.0103251,121.51453530000003),new google.maps.LatLng(23.712201,120.68900550000001),new google.maps.LatLng(24.9721514,121.20539630000007),new google.maps.LatLng(25.0614534,121.48671139999999),new google.maps.LatLng(24.631919,121.75374039999997),new google.maps.LatLng(24.7591148,121.75374039999997),new google.maps.LatLng(25.0921827,121.51727219999998),new google.maps.LatLng(23.9910732,121.61119489999999),new google.maps.LatLng(22.7972447,121.07137020000005),new google.maps.LatLng(22.0008277,120.74476379999999),new google.maps.LatLng(22.5294168,120.5624474),new google.maps.LatLng(22.6558442,120.47032579999996),new google.maps.LatLng(22.5553185,120.36084549999998),new google.maps.LatLng(22.5970794,120.31472080000003),new google.maps.LatLng(22.6254162,120.29453620000004),new google.maps.LatLng(22.6877358,120.29165239999998),new google.maps.LatLng(22.7175372,120.30318710000006),new google.maps.LatLng(22.4986756,120.4011911),new google.maps.LatLng(22.584481,120.4011911),new google.maps.LatLng(22.6113591,120.3493158),new google.maps.LatLng(22.6947932,120.36084549999998),new google.maps.LatLng(22.7539012,120.30895409999994),new google.maps.LatLng(22.885385,120.55093579999993),new google.maps.LatLng(22.9997281,120.22702770000001),new google.maps.LatLng(23.0585336,120.13583459999995),new google.maps.LatLng(23.1402613,120.30895409999994),new google.maps.LatLng(23.308747,120.312906),new google.maps.LatLng(23.4800751,120.44911130000003),new google.maps.LatLng(23.7229714,120.19356629999993),new google.maps.LatLng(23.4464152,120.25704210000004),new google.maps.LatLng(23.538123,120.3550808),new google.maps.LatLng(23.7601594,120.3531749),new google.maps.LatLng(23.7077947,120.54090889999998),new google.maps.LatLng(23.9179637,120.67750539999997),new google.maps.LatLng(23.9141358,120.4011911),new google.maps.LatLng(24.1316695,120.46220160000007),new google.maps.LatLng(24.0716583,120.5624474),new google.maps.LatLng(24.1769764,120.6424333),new google.maps.LatLng(24.1588789,120.66361430000006),new google.maps.LatLng(24.1046899,120.68121139999994),new google.maps.LatLng(24.2377939,120.58546739999997),new google.maps.LatLng(24.2521156,120.72235720000003),new google.maps.LatLng(24.3892633,120.76947599999994),new google.maps.LatLng(24.5711502,120.81543579999993),new google.maps.LatLng(24.6884438,120.90248359999998),new google.maps.LatLng(24.8138287,120.96747979999998),new google.maps.LatLng(24.774922,121.04497679999997),new google.maps.LatLng(24.8814458,121.04497679999997),new google.maps.LatLng(24.8444927,121.20539630000007),new google.maps.LatLng(24.9296022,121.20539630000007),new google.maps.LatLng(25.0359365,121.11375440000006),new google.maps.LatLng(25.0492632,121.19394499999999),new google.maps.LatLng(24.9936281,121.30097980000005),new google.maps.LatLng(25.0627243,121.51130639999997),new google.maps.LatLng(25.0541591,121.56386210000005),new google.maps.LatLng(25.021694,121.52747870000007),new google.maps.LatLng(25.0262857,121.49702939999997),new google.maps.LatLng(25.0792018,121.54270930000007),new google.maps.LatLng(25.0950492,121.52460769999993),new google.maps.LatLng(25.1719805,121.44337059999998),new google.maps.LatLng(25.0790108,121.38813779999998),new google.maps.LatLng(25.057179,121.48613799999998),new google.maps.LatLng(25.0265985,121.41783469999996),new google.maps.LatLng(25.0114095,121.46184149999999),new google.maps.LatLng(24.968371,121.43803400000002),new google.maps.LatLng(24.978282,121.53948220000007),new google.maps.LatLng(25.1676024,121.63971839999999),new google.maps.LatLng(25.0616059,121.63971839999999),new google.maps.LatLng(25.1276033,121.73918329999992)];  
        var latsql = ["<? echo join("\", \"",$arrlat); ?>"];
        var latjs="<? print($latnum);?>";
        var lngsql = ["<? echo join("\", \"",$arrlng); ?>"];
        var lngjs="<? print($lngnum);?>";        
        var pmsql = ["<? echo join("\", \"",$arrpm); ?>"];

        var map = new google.maps.Map(document.getElementById('map'), {
          mapTypeControl: false,
          center: {lat: 24, lng: 121},
          zoom: 8
        });
        var infowindow = new google.maps.InfoWindow();
        for(var u=0;u<latjs;u++){
          var marker2 = new google.maps.Marker({
            position:{lat: Number(latsql[u]), lng: Number(lngsql[u])},
            map: map
          }); 
          google.maps.event.addListener(marker2, 'click', (function(marker2, u) {
            return function() {
          infowindow.setContent(pmsql[u]);
              infowindow.open(map, marker2);
            }
          })(marker2, u));    
        }

            /*var miao=new google.maps.LatLng(24.3892633,120.76947599999994);
            var cascadiaFault = new google.maps.Polyline({
              path: [
                new google.maps.LatLng(24.37581,120.74935000000005), new google.maps.LatLng(24.5711502,120.81543579999993)
              ]
            });
             cascadiaFault.setMap(map);
            if(google.maps.geometry.poly.isLocationOnEdge(miao,cascadiaFault,0.05)){
              alert("success");
            }
            else{
              alert("fail");
            }*/

        //以下為PM2.5數值
      var epa="https://opendata.epa.gov.tw/webapi/api/rest/datastore/355000000I-000207/?format={json}&token=m/Z4PvvuD0+CR9FQxw9HFg&callback=?";
        $.getJSON(epa,function(){
          format:"json"
        }).done(function(data){
          var infowindow = new google.maps.InfoWindow();
          document.getElementById("pan").innerHTML='PM2.5更新時間:'+'<br>'+data["result"]["records"][0]["DataCreationDate"];
          for(var i=0;i<77;i++){

              var ppm=Number(data["result"]["records"][i]["PM25"]);
              var xy='';
              if(ppm<=15){
                xy='http://maps.google.com/mapfiles/ms/icons/green-dot.png';
              }
              else if((ppm>15)&&(ppm<=20)){
                xy='http://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
              }else if((ppm>20)&&(ppm<=25)){
                xy='http://maps.google.com/mapfiles/ms/icons/orange-dot.png';
              }else if((ppm>25)&&(ppm<=30)){
                xy='http://maps.google.com/mapfiles/ms/icons/red-dot.png';
              }else if(ppm>30){
                xy='http://maps.google.com/mapfiles/ms/icons/purple-dot.png';
              }
                  var marker=new google.maps.Marker({
                    icon:xy,
                    position:locs[i],
                    map:map
                  }); 

            var pmvalue=[];
            pmvalue.push(data["result"]["records"][i]["PM25"]);
            
            //document.getElementById("demo").innerHTML=pmvalue[0];
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                infowindow.setContent(data["result"]["records"][i]["Site"]+','+data["result"]["records"][i]["PM25"]);
                infowindow.open(map, marker);
              }
            })(marker, i));
          }
        });

        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;

        new AutocompleteDirectionsHandler(map);
      }

      function AutocompleteDirectionsHandler(map) {
        this.map = map;
        this.originPlaceId = null;
        this.destinationPlaceId = null;
        this.travelMode = 'DRIVING';

        var originInput = document.getElementById('origin-input');
        var destinationInput = document.getElementById('destination-input');
        var modeSelector = document.getElementById('mode-selector');
        var total = document.getElementById('total');    
        var logreg = document.getElementById('logreg');
        var markcontent = document.getElementById('markcontent');
        var color = document.getElementById('color');
        this.directionsService = new google.maps.DirectionsService;
        this.directionsDisplay = new google.maps.DirectionsRenderer;
        this.directionsDisplay.setMap(map);

        var originAutocomplete = new google.maps.places.Autocomplete(
            originInput, {placeIdOnly: true});
        var destinationAutocomplete = new google.maps.places.Autocomplete(
            destinationInput, {placeIdOnly: true});

        this.setupClickListener('changemode-walking', 'WALKING');
        this.setupClickListener('changemode-transit', 'TRANSIT');
        this.setupClickListener('changemode-driving', 'DRIVING');

        this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
        this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');


        this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(markcontent);
        /*this.map.controls[google.maps.ControlPosition.TOP_CENTER].push(originInput);
        this.map.controls[google.maps.ControlPosition.TOP_CENTER].push(destinationInput);
        this.map.controls[google.maps.ControlPosition.TOP_CENTER].push(modeSelector);*/
        this.map.controls[google.maps.ControlPosition.TOP_RIGHT].push(logreg);
        this.map.controls[google.maps.ControlPosition.TOP_RIGHT].push(total);
        this.map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(color);
      }

      // Sets a listener on a radio button to change the filter type on Places
      // Autocomplete.
      AutocompleteDirectionsHandler.prototype.setupClickListener = function(id, mode) {
        var radioButton = document.getElementById(id);
        var me = this;
        radioButton.addEventListener('click', function() {
          me.travelMode = mode;
          me.route();
        });
      };

      AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(autocomplete, mode) {
        var me = this;
        autocomplete.bindTo('bounds', this.map);
        autocomplete.addListener('place_changed', function() {
          var place = autocomplete.getPlace();
         /*document.getElementById("place1").innerHTML=place.geometry.location.lat();
         document.getElementById("place2").innerHTML=place.geometry.location.lng();*/
          if (!place.place_id) {
            window.alert("Please select an option from the dropdown list.");
            return;
          }
          if (mode === 'ORIG') {
            me.originPlaceId = place.place_id;            
            var geocoder=new google.maps.Geocoder();
            geocoder.geocode({'placeId':me.originPlaceId},function(results,status){
            if(status==='OK'){
                if(results[0]){
                var place1=document.getElementById("place1").value=results[0].geometry.location.lat();
                var place2=document.getElementById("place2").value=results[0].geometry.location.lng();
                document.getElementById("start").value=document.getElementById("origin-input").value;
                }else{
                window.alert('No results found');
                }
              }else{
                window.alert('Geocoder failed due to: ' + status);
              }
            });
          } else {
            me.destinationPlaceId = place.place_id;
            var geocoder=new google.maps.Geocoder();           
            geocoder.geocode({'placeId':me.destinationPlaceId},function(results,status){
            if(status==='OK'){
                if(results[0]){
                var place3=document.getElementById("place3").value=results[0].geometry.location.lat();
                var place4=document.getElementById("place4").value=results[0].geometry.location.lng();
                document.getElementById("end").value=document.getElementById("destination-input").value;
                }else{
                window.alert('No results found');
                }
              }else{
                window.alert('Geocoder failed due to: ' + status);
              }
            });
          }
          me.route();

        });

      };

      AutocompleteDirectionsHandler.prototype.route = function(map) {

        if (!this.originPlaceId || !this.destinationPlaceId) {
          return;
        }
        var me = this;
        this.directionsService.route({
          origin: {'placeId': this.originPlaceId},
          destination: {'placeId': this.destinationPlaceId},
          travelMode: this.travelMode
        }, function(response, status) {
          if (status === 'OK') {
            me.directionsDisplay.setDirections(response);
            var place=me.originPlaceId+','+me.destinationPlaceId;
            document.getElementById("pm").onclick=function(){
            window.location.assign("test.php?"+place);              
            }
            var currentRouteArray = response.routes[0];
            var currentRoute = currentRouteArray.overview_path;

            obj_newPolyline = new google.maps.Polyline({ map: map });
            
            var pathlatlng=[];
            var path = obj_newPolyline.getPath();
            for (var x = 0; x < currentRoute.length; x++) {
                pos= new google.maps.LatLng(currentRoute[x].lat(), currentRoute[x].lng())
                path.push(pos);
                pathlatlng.push(pos);
                document.getElementById("demo").value=pathlatlng;
                var marker=new google.maps.Marker({
                  position:pos,
                  map:map
                });
            }
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      };
      //24.402520000000003, 120.76472000000001
                /*for (var x = 0; x < currentRoute.length; x++) {
                var pos = new google.maps.LatLng(currentRoute[x].kb, currentRoute[x].lb)
                latArray[x] = currentRoute[x].kb; //Returns the latitude
                lngArray[x] = currentRoute[x].lb; //Returns the longitude
                path.push(pos);
                }*/
    </script>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */

    #mark{
      margin:0px;
      padding:5px;
      height:30px;
      width:50px;
      font-size:20px;
      float:left;
      text-align:center;
      background:#FF7F50;
      cursor:pointer;
      font-family:'Arial';
    }
   #content{
    margin:0px;
    padding:5px;
    height:1000px;
    width:300px;
    line-height:30px;
    font-size:30px;
    float:left;
    text-align:left;
    background:#F5F5F5;
    border:solid 1px #c3c3c3;
    display:none;
    font-family:'Arial';
  }
   #textleft{
    background-color:#cecece;
    width:500px;
    height:750px;
    text-align:center;
    float:left;
    }
  #map{
    /*margin-left:120px;
    margin-right:120px;
    background-color:#F2FFF2;
    text-align:center;
    line-height:30px;
    height:750px;
    font-size: 50px;
    font-weight: bold;*/
    height: 100%;
  }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 50px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #origin-input,
      #destination-input {
        background-color: #fff;
        font-size: 20px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        width:280px;
      }
      #mode-selector {
        color: #fff;
        background-color: #4d90fe;
        margin-left: 12px;
        padding: 5px 11px 0px 11px;
        width:250px;
        height:40px;
      }

      #mode-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
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
    </style>
  </head>
  <body>
     <div id="markcontent" style="width:400px;">
     <div id="content">
      <div id="pan"></div><br>
      <input id="origin-input" class="controls" type="text" placeholder="Enter an origin location">
      <input id="destination-input" class="controls" type="text" placeholder="Enter a destination location"><p>
      <button id="pm" style="height:30px;width:80px;font-size:20px;">pm2.5</button><p>
      <input type="button" value="查看其他路徑" onclick="location.href='main.php'" style="width:150px;height:30px;font-size:20px;">           
      <div id="mode-selector" class="controls" style="visibility:hidden">
      <input type="radio" name="type" id="changemode-walking" >
      <label for="changemode-walking"></label>

      <input type="radio" name="type" id="changemode-transit">
      <label for="changemode-transit">Transit</label>

      <input type="radio" name="type" id="changemode-driving" checked="checked">
      <label for="changemode-driving">Driving</label>
      </div>

      <div id="message"></div>
      <form method="POST" action="" >
      <input type="hidden" id="start" name="start">         
      <input type="hidden" id="place1" name="place1">
      <input type="hidden" id="place2" name="place2">
      <input type="hidden" id="end" name="end">         
      <input type="hidden" id="place3" name="place3">
      <input type="hidden" id="place4" name="place4">
      <input type="hidden" name="one" value="2">
      <input type="hidden" name="username" id="username" value=<?echo "\"".$datamail['myemail']."\""?>><br>
      <input type="submit" value="提交路徑" style="width:100px;height:30px;font-size:20px;visibility:hidden" onclick="check()">

      </form> 
      
     </div> 
     <div id="mark"><span class="1">click</span></div>
    </div>   
<div id="map"></div>
  <div style="margin-bottom:50px;">
      <?if(@$_SESSION["b"]==0){
      ?>
        <div id="logreg">
        <a href ="0709.php"><img src="image/register.png" border="0" width="100"/></a><?
        ?><a href ="login.php"><img src="image/login.png" border="0" width="100"/></a>

        </div><?
      }else {
        ?>
            <div id="total">
              <!--<div id="flip"><?echo "<img src=\"image/".$datamail['photo'].".jpg\" width=\"70\">";?></div>-->
              <div id="flip"><?echo "<img src=\"image/user.png\" width=\"70\">";?></div>
              <div id="panel"><?echo $datamail['userName']."歡迎回來";?><hr></hr>
              <form method="POST" action="">
                <input type="hidden" name="test" value="1" style="width:10px;">
                <input type="submit" value="登出" onclick="location.href='map2.php'" style="width:60px;height:30px;font-size:20px;" >
              <form>
              </div>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBXzQEMKDbv-Cd1DyefhIXwNI_hfz-B7M&libraries=places&callback=initMap"
        async defer></script>

  </body>
</html>
<!--AIzaSyBBXzQEMKDbv-Cd1DyefhIXwNI_hfz-B7M - 66488