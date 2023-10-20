<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "javajam1";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$javaNew=$_POST['JavaNew'];
$CafeSingleNew=$_POST['CafeSingleNew'];
$CafeDoubleNew=$_POST['CafeDoubleNew'];
$IcedSingleNew=$_POST['IcedSingleNew'];
$IcedDoubleNew=$_POST['IcedDoubleNew'];

if ($javaNew != NULL) {
		
		$javaNew = addslashes($javaNew);
			
	$query = "UPDATE javajam1 SET Price = '".$javaNew."' WHERE Name='just_java'";
	$result = $conn->query($query);		
}

if ($CafeSingleNew != NULL) {
		
		$CafeSingleNew = addslashes($CafeSingleNew);
			
	$query = "UPDATE javajam1 SET Price = '".$CafeSingleNew."' WHERE Name='cafe_single'";
	$result = $conn->query($query);		
}

if ($CafeDoubleNew != NULL) {
		
		$CafeDoubleNew = addslashes($CafeDoubleNew);
			
	$query = "UPDATE javajam1 SET Price = '".$CafeDoubleNew."' WHERE Name='cafe_double'";
	$result = $conn->query($query);		
}

if ($IcedSingleNew != NULL) {
		
		$IcedSingleNew = addslashes($IcedSingleNew);
			
	$query = "UPDATE javajam1 SET Price = '".$IcedSingleNew."' WHERE Name='iced_single'";
	$result = $conn->query($query);		
}

if ($IcedDoubleNew != NULL) {
		
		$IcedDoubleNew = addslashes($IcedDoubleNew);
			
	$query = "UPDATE javajam1 SET Price = '".$IcedDoubleNew."' WHERE Name='iced_double'";
	$result = $conn->query($query);		
}

@ $db = new mysqli('localhost', 'root', '', 'javajam');

?>

<?php

// show Price

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "javajam";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

@ $db = new mysqli('localhost', 'root', '', 'javajam');

$query = "SELECT * FROM `javajam1` WHERE Name='just_java'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$priceJava = stripslashes($row['Price']);

$query = "SELECT * FROM `javajam1` WHERE Name='cafe_single'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$priceCafeSingle = stripslashes($row['Price']);

$query = "SELECT * FROM `javajam1` WHERE Name='cafe_double'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$priceCafeDouble = stripslashes($row['Price']);

$query = "SELECT * FROM `javajam1` WHERE Name='iced_single'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$priceIcedSingle = stripslashes($row['Price']);

$query = "SELECT * FROM `javajam1` WHERE Name='iced_double'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$priceIcedDouble = stripslashes($row['Price']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>JavaJam Coffee House</title>
<!-- Script for the event handlers -->
<script type="text/javascript">

function calc(){
  var j1 = document.getElementById("j1").value;
  var c1 = document.getElementById("c1").value;
  var c2 = document.getElementById("c2").value;
  var i1 = document.getElementById("i1").value;
  var i2 = document.getElementById("i2").value;
  var jqty = document.getElementById('jqty').value;
  var cqty = document.getElementById('cqty').value;
  var iqty = document.getElementById('iqty').value;
  var jprice = document.getElementById('jprice').value=jpricesubtotal=j1*jqty;
	
  
	var c1;
	var cafes=document.getElementsByName("cafe");
	for(var i=0;i<cafes.length;i++){
	if(cafes[i].checked){
	c1=cafes[i].value;
	}
	}
	var cprice=c1*cqty;
	document.getElementById("cprice").value=cprice;
	
	var i1;
	var ices=document.getElementsByName("ice");
	for(var i=0;i<ices.length;i++){
	if(ices[i].checked){
	i1=ices[i].value;
	}
	}
	var iprice=i1*iqty;
	document.getElementById("iprice").value=iprice;


	
	  
  
  
  

// Compute the cost

  document.getElementById("tprice").value = 
  totalCost = jprice+cprice+iprice;

}

</script>








<meta charset="utf-8">
<style>
body {font-family:Verdana, Arial, sans-serif;
      background-color: #f9ebb6;
}
#wrapper { background-color: #F5F5DC; 
           width: 80%;
		   margin: auto;
           min-width: 800px;		   
} 
#leftcolumn { 	margin: auto;
             float: left;
			 background-color: #ccbbaa;
			 font-weight: bold;
			 font-size: 16px;
			 font-family: Arial, sans-serif;
			 text-align:left-center;
			 min_width: 800px;
			 width: 18.5%;
			 padding:auto;
			 height: 480px;
			 z-index:10;
			 overflow: hidden;}
#rightcolumn { background-color: #F5F5DC;
				color: #654321;
				text-align: left;
				
				z-index:9;
				padding: auto;
				float: right;
			  width: auto;
			  font-size:15px;
			 margin: auto;
			 overflow: hidden;
} 
header { background-image: url(headerimage.png);
		background-repeat: no-repeat;
		background-position: center;
		background-color: #C4A484;
        font-size: 150%; 
        padding: auto;
		width: default;

		
		text-align: center;
		
        
		
}
.content {padding: auto;
			float:right;
			margin-right: 180px;
}  
} 
#floatright { margin: auto;
             float: center;
}

footer { position: relative;
		font-size:16px;
         text-align: center;
		 clear: right;
         padding:auto;
		 margin-left:40px;
		 margin-right:40px;
		 background-color: #C4A484;
		background-repeat: no-repeat;
		background-position: center;
}		
ul { list-style-type: none; }
a { text-decoration: none; }
nav { position:fixed;}
h2 {position: fixed;
	
	font-size: 30px;
	font-weight: bold;
	color: #180000;
}
a:link {color:#3d251e;}
a:visited {color:#987654;}
a:focus {color:#f5f1ee;}
a:hover {color:#ff0000;}
a:active {color:#e6e8e3;}
table { margin: auto; border: 5px; width: 600px; border-spacing: 5px;}
td, th { padding: 5px; font-family: Arial, sans-serif; border-style: 5px solid #ccbbaa;
	font-size: 1.1em; border-style: none;}
tr:nth-of-type(even) { background-color: #FFFDD0;}
tr:first-of-type { background-color: #C4A484;}
tr:nth-of-type(odd) { background-color: #C4A484;}
.btn {
			width: 30px;
			height: 30px;
			background: none;
			border: 2px solid #f9ebb6;
			color: white;
		}
		
		.first_column {
			tr:nth-of-type(even) { background-color: #FFFDD0;}
tr:first-of-type { background-color: #C4A484;}
tr:nth-of-type(odd) { background-color: #C4A484;}
			padding-right: 20px;
			padding-left: 20px;
		}
#container {background-color: #f9ebb6; margin-left: 300px; width:80%; min-width: 800px;}
</style>
</head>
<body>
<nav>
<div id='container'>
<div id = "wrapper">
<header>
	<img src="headerimage.png">
</header>
<div id='leftcolumn'>
<nav>
	<ul>
	<li><b><a href="index.html">Home</a></li> 
	<li><a href="menu.html">Menu</a></li> 
	<li><a href="music.html">Music</a></li> 
	<li><a href="jobs.html">Jobs</a></li> 
	<li><a href="price_update.php">Update Price</a></li>
	<li><a href="report.html">Report</a></li>
	</b></ul>
</nav>
</div>
<div id='rightcolumn'>
	<form action="price_update_cont.php" method="post">
	<h2> Coffee at JavaJam </h2><br><br><br><br>
	<table>
	<tr><td class="first_column"> new value: <input type="text" name="JavaNew"> </td>
		<td> Just Java </td>
		<td> Regular house blend, decaffeinated coffee, or flavor of the day.<br>
		<b>Endless Cup $<?php echo number_format($priceJava,2);?></b></td>
	</tr>
	<tr><td class="first_column"> new Single: <input type="text" name="CafeSingleNew" id="by_product"><br> new Double: <input type="text" name="CafeDoubleNew"></td>
		<td> Cafe Au Lait </td>
		<td> House blended coffee infused into a smooth, steamed milk.<br>
		<b>Single $<?php echo number_format($priceCafeSingle,2);?>
		Double $<?php echo number_format($priceCafeDouble,2);?></b></td>
	</tr>
	<tr><td class="first_column">new Single: <input type="text" name="IcedSingleNew"><br>
					new Double: <input type="text" name="IcedDoubleNew"> </td>
		<td> Iced Cappuccino </td>
		<td> Sweetened espresso blended with icy-cold milk and served in a chilled glass.<br>
		<b>Single $<?php echo number_format($priceIcedSingle,2);?>
		Double $<?php echo number_format($priceIcedDouble,2);?></b></td>
	</tr>
	</table>
	<br>
	<h3>
	<input style="float:right; margin-right: 200px" type="submit" value="Update"><br>
	</div></h3>
	</div>

<footer>
<em><div style='padding: 0 0 0 0;'>Copyright &copy 2014 JavaJam Coffee House<br><div style='text-decoration: underline'><a href="Felicia@Ang.com">Felicia@Ang.com</em></a></div></div>
</footer>

</div>
</div>
</nav>
</form>
</body>
</html>	