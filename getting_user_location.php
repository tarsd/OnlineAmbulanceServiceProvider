<!-- FORM FOR PATIENT -->

 <html>
  <head>
      <title>Patient Form</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	  <link href="css/style.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="getting_user_location-page">
    <script>
           function getLocation()
           {
              if(!navigator.geolocation)
              {
	       alert('Your Browser does not support HTML5 Geo Location. Please Use Newer Version Browsers');
              } 
              navigator.geolocation.getCurrentPosition(success, error);
           }

           function success(position){
	          var latitude  = position.coords.latitude;	
	          var longitude = position.coords.longitude;	
	          var accuracy  = position.coords.accuracy;
                  var client = document.getElementById("clientname").value;
                  var mobile = document.getElementById("clientmobile").value;
                  //alert("latitude is " + latitude + "\n");
                  //alert("longitude is " + longitude + "\n");
                  test(client,latitude,longitude,accuracy,mobile);
           }
           function error(err){
	          alert('ERROR(' + err.code + '): ' + err.message);
           }

 
           function test(client,latitude,longitude,accuracy,mobile)
           {
	       //alert('asd1');
	       var arr = [];
	       //alert(s.options.length);
	  
	       /*for(var count=0; count < s.options.length; count++)
	       {
		 arr.push(s.options[count].value);
	       }*/
	 
               
               arr.push(client);
               arr.push(latitude);
               arr.push(longitude);
               arr.push(mobile);
               //alert(arr);
	       $.ajax({
                    type: "POST",
                    url: 'file1.php',
                    data: {"check":arr},
                    success: function(data)
                    {
                      alert("Your Response has been recorded");
                    }
                   
               });
               //alert('asd4');
           }
           

   </script>

   <form class="getting_user_location" action="getting_user_location.php" method="post">
      <h1>Fill The Form For Quick Ambulance Service</h1> 
      <label>Your Name :</label>  
      <input type="text"  id="clientname" name="clientname">
      <label>Patient's Name : (If Known)</label>
      <input type="text"  id="patientname" name="patientname">
      <label> Your Mobile Number :</label>
      <input type="text"  id="clientmobile" name="mobile">
      <label>Patient's SEX :</label>
      <div style="float:left; text-align:left;"> <input type="radio" class="radio-btn" name="sex" value="male" checked><div class="text-12"> Male</div>
      <input type="radio" class="radio-btn" name="sex" value="female"><div class="text-12"> Female</div></div>
      <label>City :</label>  
      <input type="text"  id="city">
      <label>Problem :</label>     
      <input type="text"  id="problem">
      <label> <small>Press "SUBMIT" Before pressing "Get UID" Button  </small></label>
      <div class="submit-btn">
		  <input type="button" class="getting-btn" value="Submit" onclick="getLocation()">
		  <input type="submit" class="getting-btn" value="Get UID">
		  <input type="submit" class="getting-btn" name="go_back" value="Go Back" >
	 </div>
   </form>
   
   </body>
 </html>

<?php

mysql_connect('localhost','root','') or die('error');
mysql_select_db('tarsd6701') or die('Could not connect');
//echo 'connected';
@$client = $_POST['clientname'];
@$client_mobile = $_POST['mobile'];

$query = "SELECT id,clientname FROM patient WHERE clientname = '$client' and mobile = '$client_mobile'";


session_start();
$_SESSION['mobile'] = $client_mobile;

if($handle = mysql_query($query))
{
  //echo "Successful";
  
  while($query_row = mysql_fetch_assoc($handle))
  {
   $id = $query_row['id'];
   $client_db = $query_row['clientname'];
   echo "<h2>Your UID IS (" .$id. "). Please Remember this.</h2>";
   $_SESSION['id'] = $id;
   $_SESSION['client'] = $client_db;
  } 
}
else
{
  echo "Unsuccessful";
}


require 'assign_ambulance.php';


if(isset($_POST['go_back']))
{
  header("Location: homepage.php");
}
?>