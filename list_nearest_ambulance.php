<html>
  <head>
      <title>Patient Form</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	  <link href="css/style.css" rel="stylesheet" type="text/css" />
  </head>
<body class="list_nearest_ambulance">
<?php

mysql_connect('localhost','root','') or die('error');
mysql_select_db('tarsd6701') or die('Could not connect');
//echo('Connected Successfully');

$query = "SELECT driver_name,City,( 6371 * acos( cos( radians(30.9010) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(75.8573) ) + sin( radians(30.9010) ) * sin( radians( latitude ) ) ) ) AS distance FROM ambulance HAVING distance < 100 ORDER BY distance LIMIT 0 , 20";
$handle = mysql_query($query);

 echo '<table border="3">
        <th>Driver</th>
        <th>City</th>
        <th>Distance</th>
      ';
 while($query_row = mysql_fetch_assoc($handle))
 { 
   $driver = $query_row['driver_name'];
   $city = $query_row['City'];
   $distance = $query_row['distance'];

   echo '<tr>';
   echo '<td>'.$driver.'</td>';
   echo '<td>'.$city.'</td>';
   echo '<td>'.$distance.'</td>';
   echo '</tr>';

 }

 echo '</table>';
?>

</body>
</html>