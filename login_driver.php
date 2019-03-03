<!-- FORM FOR AMBULANCE DRIVERS -->

<?php

@$uid = $_POST["uid"];
@$driver_name = $_POST["driver_name"];
@$mobile = $_POST["mobile"];
@$password = $_POST["password"];

mysql_connect('localhost','root','') or die('error');
mysql_select_db('tarsd6701') or die('Could not connect');


$query1 = "SELECT id,status,latitude,longitude FROM ambulance WHERE driver_name = '$driver_name' AND mobile = '$mobile' AND password = '$password'";
$handle1 = mysql_query($query1);

if(mysql_num_rows($handle1) == 1)
{
  //echo 'SUCCESS';
  $query_row1 = mysql_fetch_assoc($handle1);
  $id_db = $query_row1['id'];
  $status_db = $query_row1['status'];
  $latitude = $query_row1['latitude'];
  $longitude = $query_row1['longitude'];
  if(($id_db == $uid) && ($status_db == 1))
  {
    session_start();
    $_SESSION['uid'] = $uid;
    $_SESSION['latitude'] = $latitude;
    $_SESSION['longitude'] = $longitude;
    header("Location: show_route.php");
  }
}


?>

 <html>
  <head>
      <title>Patient Form</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	  <link href="css/style.css" rel="stylesheet" type="text/css" />
  </head>
  <body>

   <form class="getting_user_location" method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
      <h1>Login (for drivers)</h1> 
      <label>Enter Your Unique-Id :</label>
      <input type="text"  name="uid" >
      <label>Enter Your Name :</label>
      <input type="text"  name="driver_name" >
      <label>Enter Your Mobile :</label>
      <input type="tel"  name="mobile" >
      <label>Enter Your Password :</label>
      <input type="password"  name="password">
      <input class="getting-btn" type="submit" value="LOGIN">
   </form>
 </body>
 </html>