<?PHP require_once("database_connect.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/main_dynamic_template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">

<!-- InstanceBeginEditable name="document_title_rgn" -->
<title>you cart</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="style.css" type="text/css">
<!-- InstanceBeginEditable name="headers_rgn" -->
<!-- here goes headers headers -->
<!-- InstanceEndEditable -->
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>

</head>
<body> 
<div id="mainLayer" style="position:absolute; width:700px; z-index:1">
<div id="masthead"> 
  <h1 id="siteName"><a href="https://www.acunetix.com/"><img src="images/logo.gif" width="306" height="38" border="0" alt="Acunetix website security"></a></h1>   
  <h6 id="siteInfo">TEST and Demonstration site for <a href="https://www.acunetix.com/vulnerability-scanner/">Acunetix Web Vulnerability Scanner</a></h6>
  <div id="globalNav"> 
      	<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr>
	<td align="left">
		<a href="index.php">home</a> | <a href="categories.php">categories</a> | <a href="artists.php">artists
		</a> | <a href="disclaimer.php">disclaimer</a> | <a href="cart.php">your cart</a> | 
		<a href="guestbook.php">guestbook</a> | 
		<a href="AJAX/index.php">AJAX Demo</a>
	</td>
	<td align="right">
	<?PHP
		if(isset($_COOKIE["login"])){
			$login = explode('/', $_COOKIE["login"]);
			$result = mysql_query("SELECT * FROM users WHERE uname='".$login[0]."' AND pass='".$login[1]."'");

			if (!$result) {
				die('Error: ' . mysql_error());
			}

			if ($row = mysql_fetch_array($result)){
				echo "<a href='logout.php'>Logout ".$row['uname']."</a>";
			}
		}
	?>
	</td>
	</tr></table>
  </div> 
</div> 
<!-- end masthead --> 

<!-- begin content -->
<!-- InstanceBeginEditable name="content_rgn" -->
<div id="content">
	<?PHP
	if ( isset($_COOKIE["login"]) ){
		// already logined
		$br = explode('/', $_COOKIE["login"]);
		$uname = $br[0];
		$pass = $br[1];
		$auth = 0;
		$result = mysql_query("SELECT * FROM users WHERE uname='".$uname."' AND pass='".$pass."'");

		if (!$result) {
			die('Error: ' . mysql_error());
		}

		if ($row = mysql_fetch_array($result)){
			$login 		= $row['uname']."/".$row['pass'];
			$uname 		= $row['uname'];
			$cc			= $row['cc'];
			$address	= $row['address'];
			$cart		= $row['cart'];
			$name		= $row['name'];
			$email		= $row['email'];
			$phone		= $row['phone'];
			$auth		= 1;
		}
		// check out cart
		if ($auth == 1){
			if ( isset($_POST['addcart']) ){
				$result = mysql_query("SELECT * FROM carts WHERE cart_id='$cart' AND item=".$_POST['addcart']);

				if (!$result) {
					die('Error: ' . mysql_error());
				}

				if (! ($row = mysql_fetch_array($result))) 
					mysql_query("INSERT INTO carts (cart_id, item, price) VALUES ('$cart', ".$_POST['addcart'].", ".$_POST['price'].")");
			}
			elseif ( isset($_GET['del']) ){
				mysql_query("DELETE FROM CARTS WHERE item=".$_GET['del']." AND cart_id='$cart'");
			}
			// visualize cart
			echo "<div class='story'>";
			$result = mysql_query("
				SELECT a.*, b.title, c.cname, c.cat_id, d.aname, d.artist_id
					FROM  carts a, pictures b, categ c, artists d
					WHERE 
							a.item = b.pic_id 
						AND b.cat_id = c.cat_id
						AND b.a_id = d.artist_id
						AND a.cart_id = '$cart'
				");

			if (!$result) {
				die('Error: ' . mysql_error());
			}

			echo '<table border="0" cellspacing="1" cellpadding="4">';
			echo '<tr><td width="200"><strong>Product id</strong></td>
	<td width="200"><strong>Title</strong></td><td width="200"><strong>Artist</strong></td>
	<td width="200"><strong>Category</strong></td><td width="100"><strong>Price</strong></td><td>&nbsp;</td></tr>';
			$total = 0;
			if($result)
			while ($row = mysql_fetch_array($result)){
				echo "<tr>";
				echo "<td>".$row["item"]."</td>";
				echo "<td>".$row["title"]."</td>";
				echo "<td><a href='artists.php?artist=".$row["artist_id"]."'>".$row['aname']."</a></td>";
				echo "<td><a href='listproducts.php?cat=".$row["cat_id"]."'>".$row["cname"]."</a></td>";
				echo "<td>\$".$row["price"]."</td>";
				$total += $row["price"];
				echo "<td><a href='cart.php?del=".$row["item"]."'>delete</a></td>";
				echo "</tr>";
			}
			echo "</table></div>";
			echo "<div class='story'>";
			echo "<h3 align='right'>Total: \$$total</h3>";
			echo "</div>";
		}
		if ($total > 0){
			echo "<form name='getstuff' method='POST' action='sendcommand.php'>";
			echo "<input type='hidden' value='$cart' name='cart_id'>";
			echo "<input type='submit' name='submitForm' value='place a command for these items'>";
			echo "</form>";
		}
	}
	else {
		echo "
			<h2 id='pageName'>Error</h2>
			  <div class='story'>
				<p>You are not logged on. To log on please visit our <a href='login.php'>login page</a></p>
			  </div>
			";
	}
	?>
</div>
<!-- InstanceEndEditable -->
<!--end content -->

<div id="navBar"> 
  <div id="search"> 
    <form action="search.php?test=query" method="post"> 
      <label>search art</label> 
      <input name="searchFor" type="text" size="10"> 
      <input name="goButton" type="submit" value="go"> 
    </form> 
  </div> 
  <div id="sectionLinks"> 
    <ul> 
      <li><a href="categories.php">Browse categories</a></li> 
      <li><a href="artists.php">Browse artists</a></li> 
      <li><a href="cart.php">Your cart</a></li> 
      <li><a href="login.php">Signup</a></li>
	  <li><a href="userinfo.php">Your profile</a></li>
	  <li><a href="guestbook.php">Our guestbook</a></li>
		<li><a href="AJAX/index.php">AJAX Demo</a></li>
	  <?PHP if (isset($_COOKIE["login"]))echo '<li><a href="../logout.php">Logout</a>'; ?></li> 
    </ul> 
  </div> 
  <div class="relatedLinks"> 
    <h3>Links</h3> 
    <ul> 
      <li><a href="http://www.acunetix.com">Security art</a></li> 
	  <li><a href="https://www.acunetix.com/vulnerability-scanner/php-security-scanner/">PHP scanner</a></li>
	  <li><a href="https://www.acunetix.com/blog/articles/prevent-sql-injection-vulnerabilities-in-php-applications/">PHP vuln help</a></li>
	  <li><a href="http://www.eclectasy.com/Fractal-Explorer/index.html">Fractal Explorer</a></li> 
    </ul> 
  </div> 
  <div id="advert"> 
    <p>
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="107" height="66">
        <param name="movie" value="Flash/add.swf">
        <param name=quality value=high>
        <embed src="Flash/add.swf" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="107" height="66"></embed>
      </object>
    </p>
  </div> 
</div> 

<!--end navbar --> 
<div id="siteInfo">  <a href="http://www.acunetix.com">About Us</a> | <a href="privacy.php">Privacy Policy</a> | <a href="mailto:wvs@acunetix.com">Contact Us</a> | &copy;2019
  Acunetix Ltd 
</div> 
<br> 
<div style="background-color:lightgray;width:100%;text-align:center;font-size:12px;padding:1px">
<p style="padding-left:5%;padding-right:5%"><b>Warning</b>: This is not a real shop. This is an example PHP application, which is intentionally vulnerable to web attacks. It is intended to help you test Acunetix. It also helps you understand how developer errors and bad configuration may let someone break into your website. You can use it to test other tools and your manual hacking skills as well. Tip: Look for potential SQL Injections, Cross-site Scripting (XSS), and Cross-site Request Forgery (CSRF), and more.</p>
</div>
</div>
</body>
<!-- InstanceEnd --></html>
