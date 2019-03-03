
<?php
 session_start();
 mysql_connect('localhost','root','') or die('error');
 mysql_select_db('tarsd6701') or die('Could not connect');
 
 if(!empty($_POST['uid']) && !empty($_POST['client_name']) && !empty($_POST['mobile']))
 {
   $id = $_POST['uid'];
   
   $query0 = "SELECT `clientname`,`id`,`mobile`,`status` FROM `patient` WHERE `id`='$id'";

   if($handle0 = mysql_query($query0))
   {
     $query_row0 = mysql_fetch_assoc($handle0);
     $clientname = $query_row0['clientname'];
     $id_db = $query_row0['id'];
     $mobile = $query_row0['mobile'];
     $status = $query_row0['status'];
     
     if(($id_db == $id) && ($_POST['client_name'] == $clientname) && ($_POST['mobile'] == $mobile))
     {

      $query2 = "DELETE FROM patient WHERE id='$id'";
      if($handle2 = mysql_query($query2))
      {
        echo "Your Request has been cancelled<br>";
      }
      
      $query3 = "SELECT latitude,longitude FROM ambulance WHERE id='$id'";
      $handle3 = mysql_query($query3);
      $query_row3 = mysql_fetch_assoc($handle3);
      $latitude = $query_row3['latitude'];
      $longitude = $query_row3['longitude'];


      $query1 = "UPDATE ambulance SET id=0,status=0 WHERE id='$id'";
      @$handle1 = mysql_query($query1);
      if($status == 1)
      {
        //echo "AMBULANCE WAS ASSIGNED TO THIS CLIENT"; 
        
        $query4 = "SELECT clientname,id,mobile,( 6371 * acos( cos( radians('$latitude') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( latitude ) ) ) ) AS distance FROM patient WHERE status = 0 HAVING distance < 300 ORDER BY distance LIMIT 0 , 1";
        $handle4 = mysql_query($query4);
        if(mysql_num_rows($handle4) != 0)
       {
        $query_row4 = mysql_fetch_assoc($handle4);
        $new_client = $query_row4['clientname'];
        $new_id = $query_row4['id'];
        $new_mobile = $query_row4['mobile'];
        $distance = $query_row4['distance'];
      
        $query5 = "UPDATE patient SET status=1 WHERE id='$new_id'";
        if($handle5 = mysql_query($query5))
        {
         //echo "Request has been given to new customer<br>";
        }
       
        $query6 = "UPDATE ambulance SET id='$new_id',status=1 WHERE latitude='$latitude' AND longitude ='$longitude'";
        @$handle6 = mysql_query($query6);
       }
        else
       {
        $query7 = "UPDATE ambulance SET id=0,status=0 WHERE latitude='$latitude' AND longitude ='$longitude'";
        @$handle7 = mysql_query($query7);
       }
      }
      else
      {
        //echo "AMBULANCE WAS NOT ASSIGNED TO THIS CLIENT";
      }
      session_destroy();
     }
   }
  }
  else
  {
    //echo "INVALID ENTRY"; 
  }
?>
 <html>
  <head>
      <title>Patient Form</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	  <link href="css/style.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="end_query">

    <form class="getting_user_location"   method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" > 
      <label>Enter Your Unique-Id :</label>
      <input type="text"  name="uid" >
     <label>Enter Your Name :</label>
      <input type="text"  name="client_name">
      <label>Enter Your Mobile :</label>
      <input type="tel"  name="mobile">
      <input type="submit" class="getting-btn" value="END REQUEST">
   </form>
</body>
</html>


 