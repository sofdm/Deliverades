<?php 
session_name("client");
session_start();

//connect to database
define('host', 'localhost');
define('user', 'root');
define('password', '');
define('db', 'deliverades');

  if(!isset($_SESSION['email'])){
      header("location: ./login.php");
   }

$con= mysqli_connect(host,user,password,db);
mysqli_query($con, "SET NAMES 'utf8'");//for greek

$sql="SELECT Name, Latitude, Longitude FROM stores where exists(select 1 from stock where NameOfStore_fk = Name and NameOfProduct_fk = 'Κέικ' and amount>='".$_SESSION["Κέικ"]."') and exists(select 1 from stock where NameOfStore_fk = Name and NameOfProduct_fk = 'Τοστ' and amount>='".$_SESSION["Τοστ"]."')and exists(select 1 from stock where NameOfStore_fk = Name and NameOfProduct_fk = 'Χορτόπιτα' and amount>='".$_SESSION["Χορτόπιτα"]."')and exists(select 1 from stock where NameOfStore_fk = Name and NameOfProduct_fk = 'Τυρόπιτα' and amount>='".$_SESSION["Τυρόπιτα"]."')and exists(select 1 from stock where NameOfStore_fk = Name and NameOfProduct_fk = 'Κουλούρι' and amount>='".$_SESSION["Κουλούρι"]."')";
$result = mysqli_query($con,$sql);
$stores = array();
	if(mysqli_num_rows($result) != 0) {
		while($row = mysqli_fetch_assoc($result)) {
				$stores[] = $row;
		}		
	}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>DELIVERADES</title>
<style>
#map {
 width: 60%;
 height: 50%;
margin-left:20%;
}

input[type=text]{
    width: 250px;
	height:30px;
} 
input[type="button"] {
  width: 220px;
  height: 35px;
  background: green;
  border: none;
  border-radius: 2px;
  color: #FFF;
  font-family: 'Roboto', sans-serif;
  font-weight: 550;
  transition: 0.1s ease;
  cursor: pointer;
  font-size: 15px;
}
</style>
</head>

<body>
 <br>
 <p align="right"><a href="#logout" style="color:#ce2512;" onclick="location.href = 'clients_site.php'"> Ακύρωση Παραγγελίας </a> <!--redirect to login page --></p>
  
        <div align="center">
		<div>Εισάγετε τη διεύθυνση Παράδοσης</div>
        <input id="pac-input" type="text" placeholder="Εισαγωγή διεύθυνσης">
		</div>
		
	<br>
    <div id="map"></div>
	
    <div id="infowindow-content">
      <img src="" width="16" height="16" id="place-icon">
      <span id="place-name"  class="title"></span><br>
      <span id="place-address"></span>
	  <span id="place-lat"></span>
	  <span id="place-lng"></span>
    </div>

	<p align=center> Συνολικό ποσό παραγγελίας <?php echo $_SESSION['total'];?> € </p>
	<div align=center>
	<input type="button" name="done" value="Ολοκλήρωση Παραγγελίας" onclick="findthestore()"/>
	</div>

    <script>

	var StorePlaces = [];
	var shortestIndex = 0;
	var place;
	function findthestore(){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		window.alert('Η παραγγελία σας καταχωρήθηκε επιτυχώς');
        window.location.href='clients_site.php';
        }
    };
if (place!= null) {
  xhttp.open("POST", "findthestore.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("name="+StorePlaces[shortestIndex].title+"&placeaddress="+place.name);
}
else {
window.alert('Πρέπει να εισάγετε διεύθυνση παράδοσης');	
}
	}	
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 38.248620, lng: 21.737462},
          zoom: 13
        });
		
	//create json object with stores
	<?php foreach($stores as $store){ ?>
		var obj ={'title': <?php echo json_encode($store["Name"]);?>, 'latLng': new google.maps.LatLng(<?php echo json_encode($store["Latitude"]); ?>,<?php echo json_encode($store["Longitude"]);?>)}
		StorePlaces.push(obj);
	<?php } ?>
	
	 // An array of store places we want to potentially visit.
	/*StorePlaces = [
	//to pass the store array from php to javascript you have to use json_encode
		{'title': <?php echo json_encode($stores[0]["Name"]);?>, 'latLng': new google.maps.LatLng(<?php echo json_encode($stores[0]["Latitude"]); ?>,<?php echo json_encode($stores[0]["Longitude"]);?>)},
		{'title': <?php echo json_encode($stores[1]["Name"]); ?>, 'latLng': new google.maps.LatLng(<?php echo json_encode($stores[1]["Latitude"]); ?>,<?php echo json_encode($stores[1]["Longitude"]);?>)},
		{'title': <?php echo json_encode($stores[2]["Name"]); ?>, 'latLng': new google.maps.LatLng(<?php echo json_encode($stores[2]["Latitude"]); ?>, <?php echo json_encode($stores[2]["Longitude"]);?>)},
		{'title':<?php echo json_encode($stores[3]["Name"]); ?>, 'latLng': new google.maps.LatLng(<?php echo json_encode($stores[3]["Latitude"]); ?>, <?php echo json_encode($stores[3]["Longitude"]);?>)},
		{'title': <?php echo json_encode($stores[4]["Name"]); ?>, 'latLng': new google.maps.LatLng(<?php echo json_encode($stores[4]["Latitude"]); ?>, <?php echo json_encode($stores[4]["Longitude"]);?>)},
		{'title': <?php echo json_encode($stores[5]["Name"]); ?>, 'latLng': new google.maps.LatLng(<?php echo json_encode($stores[5]["Latitude"]); ?>, <?php echo json_encode($stores[5]["Longitude"]);?>)}
	];*/

	//show markers of store places
	var i;
     for (i = 0; i < StorePlaces.length; i++){
      StorePlaces[i].marker = new google.maps.Marker({
        position:  StorePlaces[i].latLng,
        map: map,
        title: StorePlaces[i].title,
        icon: 'https://maps.google.com/mapfiles/ms/icons/orange.png'

      });
	 }
	 //window.alert(StorePlaces[0].title);
	 
        var input = document.getElementById('pac-input');
        var autocomplete = new google.maps.places.Autocomplete(input);
  
        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(['geometry', 'icon', 'name']);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29),
		  draggable: true
        });
		
		//when you change the address
          autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // zoom to the chosen place.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);		  
          marker.setVisible(true);	
	      shortestDistance(StorePlaces,place.geometry.location,map);

		  // info details when an address is set
          infowindowContent.children['place-icon'].src = place.icon;
          infowindowContent.children['place-name'].textContent = place.name;
		  infowindowContent.children['place-lat'].textContent = place.geometry.location.lat();
		  infowindowContent.children['place-lng'].textContent = place.geometry.location.lng();
          infowindow.open(map, marker);		
        });
		
      }
	  
function shortestDistance(StorePlaces,chosenPosition,map) {
	var routeResults = [];
	var directionsService = new google.maps.DirectionsService();
	var directionsDisplay = new google.maps.DirectionsRenderer();
	var size = StorePlaces.length;
	var j=0;

	function calcRoute(start) {
		var request = {
			origin: start,
			destination: chosenPosition,
			travelMode: 'DRIVING'
		};
		directionsService.route(request, function(response, status) {     
	  if (status == 'OK') {
		routeResults.push(response);
		if (routeResults.length === size) {
		findShortest();}
      } else {
        size--;
      }
	  //since directionsService.route is asynchronous we have to call calcRoute one at a time 
	  j++; 
	  if (j< StorePlaces.length){
	  calcRoute( StorePlaces[j].latLng);
	  }  
    });
  }
  
   // Goes through all routes stored and finds which one is the shortest. It then
  // sets the shortest route on the map for the user to see.
  function findShortest() {
	
    var i = routeResults.length;
    shortestIndex = 0;
    var shortestLength = routeResults[0].routes[0].legs[0].distance.value;

    for (i = 1; i < StorePlaces.length; i++){
      if (routeResults[i].routes[0].legs[0].distance.value < shortestLength) {
        shortestIndex = i;
        shortestLength = routeResults[i].routes[0].legs[0].distance.value;
      }
    }
	directionsDisplay.setDirections(routeResults[shortestIndex]);//what to do when it finds the shortest route	
	//window.alert(StorePlaces[0].title);	
  }
  
	directionsDisplay.setMap(map);
	calcRoute( StorePlaces[0].latLng);



}	
    </script>
	


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAL4YkRBlIvb5OrdzNdarVICRO4MAO4Hcc&libraries=places&callback=initMap"></script>


</body>
</html>