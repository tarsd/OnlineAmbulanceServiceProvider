<?php

session_start();

$source_latitude = $_SESSION["latitude"];
$source_longitude = $_SESSION["longitude"];
$id = $_SESSION["uid"];

mysql_connect('localhost','root','') or die('error');
mysql_select_db('tarsd6701') or die('Could not connect');
$query1 = "SELECT clientname,latitude,longitude,mobile FROM patient WHERE id = '$id'";
$handle1 = mysql_query($query1);

if(mysql_num_rows($handle1) == 1)
{
  //echo 'SUCCESS';
  $query_row1 = mysql_fetch_assoc($handle1);
  $clientname = $query_row1['clientname'];
  $dest_latitude = $query_row1['latitude'];
  $dest_longitude = $query_row1['longitude'];
  $mobile = $query_row1['mobile'];
  echo "Hello. Your Requester's name is <b>".$clientname."</b> AND his mobile number is ".$mobile."<br>";
}
?>



<html>
<head>
<table border="0" cellpadding="0" cellspacing="3">
<tr>
    <td colspan="2">
        <input type="button" value="Get Route" onclick="GetRoute()" />
        <hr />
    </td>
</tr>
<tr>
    <td colspan="2">
        <div id="dvDistance">
        </div>
    </td>
</tr>
<tr>
    <td>
        <div id="dvMap" style="width: 500px; height: 500px">
        </div>
    </td>
    <td>
        <div id="dvPanel" style="width: 500px; height: 500px">
        </div>
    </td>
</tr>
</table>
</head>










<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script type="text/javascript">
var source, destination;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
google.maps.event.addDomListener(window, 'load', function () {
    
    directionsDisplay = new google.maps.DirectionsRenderer({ 'draggable': true });
});


 
function GetRoute() {
    var mumbai = new google.maps.LatLng(30.2457963, 75.8420716);
    var mapOptions = {
        zoom: 7,
        center: mumbai
    };
    map = new google.maps.Map(document.getElementById('dvMap'), mapOptions);
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('dvPanel'));
 
    //*********DIRECTIONS AND ROUTE**********************//
    source=new google.maps.LatLng(<?php echo $source_latitude ?>,<?php echo $source_longitude ?>);
    //source = document.getElementById("txtSource").value;
    destination=new google.maps.LatLng(<?php echo $dest_latitude ?>,<?php echo $dest_longitude ?>);
 
    var request = {
        origin: source,
        destination: destination,
        travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
 
    //*********DISTANCE AND DURATION**********************//
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
        origins: [source],
        destinations: [destination],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false
    }, function (response, status) {
        if (status == google.maps.DistanceMatrixStatus.OK && response.rows[0].elements[0].status != "ZERO_RESULTS") {
            var distance = response.rows[0].elements[0].distance.text;
            var duration = response.rows[0].elements[0].duration.text;
            var dvDistance = document.getElementById("dvDistance");
           dvDistance.innerHTML = "";
            dvDistance.innerHTML += "Distance: " + distance + "<br />";
            dvDistance.innerHTML += "Duration:" + duration;
            
        } else {
            alert("Unable to find the distance via road.");
        }
    });
}

</script>
