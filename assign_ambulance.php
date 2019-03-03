<?php

mysql_connect('localhost','root','') or die('error');
mysql_select_db('tarsd6701') or die('Could not connect');

@$client = $_SESSION['client'];
@$mobile = $_SESSION['mobile'];
@$id = $_SESSION['id'];



/*@$client = "Ramdin";
@$mobile = "2147483647";
@$id = 2; */


@$query1 = "SELECT `latitude`, `longitude`, `status` FROM `patient` WHERE `id` = '$id' AND `clientname` = '$client' AND `mobile` = '$mobile'";
@$handle1 = mysql_query($query1);
$flag = 0;
if(mysql_num_rows($handle1) == 1)
{
  $query_row1 = mysql_fetch_assoc($handle1);
  $latitude = $query_row1['latitude'];
  $longitude = $query_row1['longitude'];
  
  $query = "SELECT driver_name,City,status,mobile,( 6371 * acos( cos( radians('$latitude') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( latitude ) ) ) ) AS distance FROM ambulance HAVING distance < 300 ORDER BY distance LIMIT 0 , 20";
  $handle = mysql_query($query);
  
  
  while($query_row = mysql_fetch_assoc($handle))
  { 
   $driver = $query_row['driver_name'];
   $city = $query_row['City'];
   $distance = $query_row['distance'];
   $status = $query_row['status'];
   $driver_mobile = $query_row['mobile'];
      
   if($status == 0)
   {
     $flag = 1;
     $query3 = "UPDATE ambulance SET id='$id',status= 1 WHERE driver_name='$driver' AND mobile='$driver_mobile'";
     if(mysql_query($query3))
     {
       echo "AMBULANCE ASSIGNED. DRIVER DETAILS ARE<br>";

       echo '<table border="3">
        <th>Driver</th>
        <th>City</th>
        <th>Distance</th>
        <th>Mobile</th>
      ';
       echo '<tr>';
       echo '<td>'.$driver.'</td>';
       echo '<td>'.$city.'</td>';
       echo '<td>'.$distance.'</td>';
       echo '<td>'.$driver_mobile.'</td>';
       echo '</tr>';

       $query4 = "UPDATE patient SET status=1 WHERE clientname='$client' AND id='$id'";
       mysql_query($query4);
     }
     break;
   }

  }

  echo '</table>';

  if($flag == 0)
  {
    echo "SORRY, YOUR REQUEST IS KEPT PENDING";
  }
}
else
{
  //echo "Unsuccessful";
}



?>

