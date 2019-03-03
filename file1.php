<?php

mysql_connect('localhost','root','') or die('error');
mysql_select_db('tarsd6701') or die('Could not connect');

if (isset($_POST['check'])) 
{
     $x = $_POST['check'];
     //print_r($x);
     
     $clientname = $x[0];
     $latitude = $x[1];
     $longitude = $x[2];
     $mobile = $x[3];
     $query = "INSERT INTO patient(clientname, latitude, longitude,mobile) VALUES ('$clientname','$latitude','$longitude','$mobile')";
     if($test = mysql_query($query))
     {
        //echo 'Successful';
     }
     else
     {
        //echo 'Unsuccessful';
     }
 
	
	 //$q = mysqli_query( $connection,"INSERT INTO `user11`(`userid`,`username`,`Player1`, `Player2`, `Player3`, `Player4`, `Player5`, `Player6`, `Player7`, `Player8`, `Player9`, `Player10`, `Player11`,`score`) VALUES ('123','abc',$x[0],$x[1],$x[2],$x[3],$x[4],$x[5],$x[6],$x[7],$x[8],$x[9],$x[10],0)");
	
	 //header('Location:done.php?');
         //echo "ok";
}
else
{
     //echo 'no variable received';
}
?>