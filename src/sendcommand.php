<?PHP require_once("database_connect.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>add new user</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="masthead"> 
  <h1 id="siteName">ACUNETIX ART</h1> 
</div>
<div id="content">
	<div class="story">
	<?PHP 
		if(isset($_POST['cart_id'])){
			$result = mysql_query("DELETE FROM carts WHERE cart_id='".$_POST['cart_id']."'");

			if (!$result) {
				die('Error: ' . mysql_error());
			}

			echo "<h2>Your command has been processed ...</h2>";
		}
		else {
			echo "<h2>Error processing command.</h2>";
		}
	?>	
	<p><a href="index.php">Back to homepage</a></p>
	</div>
</div>
</body>
</html>
