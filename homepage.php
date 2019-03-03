
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="main-page">
<?php

echo "<h1>Online Ambulance Service Provider</h1>";
 session_start();

if(isset($_SESSION['client']) && isset($_SESSION['id']))
{
  echo "<h3>Hello ".$_SESSION['client'].",Your ID for Request is ".$_SESSION['id']." </h3>";
}

?>

	<!--<h2>CLICK BELOW TO GENERATE REQUEST</h2> -->
	<a href="getting_user_location.php" class="home-page-btn"> Generate Request </a>
	<!--<h2>CLICK BELOW TO END REQUEST</h2> -->
	<a href="end_query.php" class="home-page-btn1"> End Request </a>
</div>
</body>
</html>


