<?php  
session_start();

@ $db = new mysqli('localhost', 'root', '', 'productdata');
if (mysqli_connect_errno()) {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

$pricename = array("Endless Cup", "Single", "Double");
$pricecol = array("endlessprice", "singleprice", "doubleprice");
$query = "select * from productlist";
$result = $db->query($query);

$products = array();
$result = $db->query($query);
$num_results = $result->num_rows;
for ($i=0; $i <$num_results; $i++) {
 $products[] = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$datenow = date("Y-m-d");
	$querybase = "INSERT INTO purchaselist 
		(orderdate, itemid,  itemtype, quantity, subtotal) 
		VALUES ('".$datenow."', ";
	for ($i=0; $i<$num_results; $i++) {
		$itemid = $i + 1;
		$itemtype = 0;
		if ($i) $itemtype = intval($_POST["type_".$itemid]);
		$quantity = intval(trim($_POST["Quantity_".$itemid]));
		$subtotal = floatval(trim($_POST["Sub_".$itemid]));
		$query = $querybase."'".$itemid."', '".$itemtype."', '".$quantity."', '".$subtotal."');";
		if ($quantity == 0) continue;
		$db->query($query);
	}
}
?>

<!doctype html>
<html lang="en">
<head>
<title>JavaJam Coffee House</title>
<meta charset=“utf-8”>

<style>
body {font-family:Verdana, Arial, sans-serif;
      background-color: #e9e2af;
}
#wrapper { background-color: #e2d1b3; 
           color: #5b3b20;
           width: 80%;
		   margin: auto;
           min-width:800px;
} 
#leftcolumn { float: left;
	          width: 150px;
			  background-color: #e2d1b3;
} 
#rightcolumn { margin-left: 150px;
               background-color: #f5f5dd;
               color: #2b0011;
			   min-height: 100px;
			   overflow: hidden;
} 
header{ background-color: #d1b38e;
        color: #5b3b20; 
        font-size: 150%; 
        padding: 10px 10px 10px 155px;

}
h2 { font-family: arial, sans-serif;
     
}
.content {padding: 20px 20px 20px 20px; 
} 


footer { background-color: #d1b38e;
		 font-size:70%;
         text-align: center;
		 clear: right;
         padding-bottom:20px;
		 float: center;
		 padding: 20px 0px 20px 0px; 
}	
nav ul { list-style-type: none;
}
nav a {text-decoration: none;
}
a:link {
  color: #784e3c;
}

a:visited {
  color: #9e856a;
}
.container {
        width: 37%;
}
img {
        width: 100%;
        height: 100%;
        object-fit: cover;
}
table {margin:auto; width: 85%;}
td {padding: 10px; font-family: Arial, sans-serif; border: 2px solid #f5f5dd;}
tr:nth-of-type(even) {background-color:#f5f5dd;}
tr:nth-of-type(odd) {background-color:#d1b38e;}
td:nth-of-type(odd) {text-align: center;}
textarea {
	resize:none;
	}

</style>
<script type="text/javascript">
function changePrice() {
	q1 = Number(document.getElementById("Quantity_1").value.trim());
	q2 = Number(document.getElementById("Quantity_2").value.trim());
	q3 = Number(document.getElementById("Quantity_3").value.trim());
	box2 = document.getElementsByName("type_2");
	for (var i = 0, length = box2.length; i < length; i++) {
	  if (box2[i].checked) {
		t2 = Number(box2[i].value);
		break;
	  }
	}
	box3 = document.getElementsByName("type_3");
	for (var i = 0, length = box3.length; i < length; i++) {
	  if (box3[i].checked) {
		t3 = Number(box3[i].value);
		break;
	  }
	}
	p1 = <?php echo $products[0]['endlessprice'] ?>; 
	p21 = <?php echo $products[1]['singleprice'] ?>; 
	p22 = <?php echo $products[1]['doubleprice'] ?>; 
	p31 = <?php echo $products[2]['singleprice'] ?>; 
	p32 = <?php echo $products[2]['doubleprice'] ?>; 
	s1 = p1 * q1;
	if (t2 == 1) s2 = p21 * q2;
	else s2 = p22 * q2;
	if (t3 == 1) s3 = p31 * q3;
	else s3 = p32 * q3;
	s = s1 + s2 + s3;
	document.getElementById("Sub_1").value = s1.toString();
	document.getElementById("Sub_2").value = s2.toString();
	document.getElementById("Sub_3").value = s3.toString();
	document.getElementById("Total").value = "$" + s.toString();
}

function checkoutalert() {
	q1 = document.getElementById("Quantity_1").value.trim();
	q2 = document.getElementById("Quantity_2").value.trim();
	q3 = document.getElementById("Quantity_3").value.trim();
	box2 = document.getElementsByName("type_2");
	if (box2[0].checked) t2 = "(Single) x ";
	else t2 = "(Double) x ";
	box3 = document.getElementsByName("type_3");
	if (box3[0].checked) t3 = "(Single) x ";
	else t3 = "(Double) x ";
	if (Number(q1) == 0) s1 = "";
	else s1 = "Just Java x "+q1+"\n";
	if (Number(q2) == 0) s2 = "";
	else s2 = "Cafe au Lait"+t2+q2+"\n";
	if (Number(q3) == 0) s3 = "";
	else s3 = "Iced Cappuccino"+t3+q3+"\n";
	alert(s1 + s2 + s3);
}
</script>
</head>
<body>
<div id="wrapper">
  <header>
    <h1>JavaJam Coffee House</h1>
  </header>
  <div id="leftcolumn">
  <nav>
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="menu.php">Menu</a></li>
      <li><a href="music.html">Music</a></li>
      <li><a href="jobs.html">Jobs</a></li>
	  <li><a href="price.php">Price</a></li>
	  <li><a href="report.php">Report</a></li>
	</ul>
  </nav>	
  </div>
  <div id="rightcolumn">
    <div class="content"> 
	<h2>Coffee at JavaJam</h2>
		<form id="productForm" method="post">
		<table border="0">
		<tr> <td><strong> Just Java</strong></td>
			<td>Regular house blend, decaffeinated coffee. or flavor of the day. <br><br>
				<strong>  Endless Cup $<?php echo $products[0]['endlessprice'] ?> </strong> 
			</td>
			<td> <br> <strong>Quantity</strong> <br><br> <textarea name="Quantity_1" id="Quantity_1" rows="1" cols="3" required onchange="changePrice()">0</textarea> </td>
			<td> <br> <strong>Subtotal</strong> <br><br> <textarea name="Sub_1" id="Sub_1" rows="1" cols="4" required onfocus = "this.blur()";>0</textarea> </td>
		</tr>
		<tr> <td><strong> Cafe au Lait</strong></td>
			<td>House blended coffee infused into a smooth, steamed milk. <br><br>
				<input type="radio" name="type_2" value="1" checked onchange="changePrice()"> <strong> Single $<?php echo $products[1]['singleprice'] ?> </strong> 
				<input type="radio" name="type_2" value="2" onchange="changePrice()"> <strong> Double $<?php echo $products[1]['doubleprice'] ?> </strong> 
			</td>
			<td> <br> <strong>Quantity</strong> <br><br> <textarea name="Quantity_2" id="Quantity_2" rows="1" cols="3" required onchange="changePrice()">0</textarea> </td>
			<td> <br> <strong>Subtotal</strong> <br><br> <textarea name="Sub_2" id="Sub_2" rows="1" cols="4" required onfocus = "this.blur()";>0</textarea> </td>
		</tr>
		<tr> <td><strong> Iced Cappuccino</strong></td>
			<td> Sweetened espresso blended with icy-cold milk and served in a chilled glass.  <br><br> 
				<input type="radio" name="type_3" value="1" checked onchange="changePrice()"> <strong> Single $<?php echo $products[2]['singleprice'] ?> </strong> 
				<input type="radio" name="type_3" value="2" onchange="changePrice()"> <strong> Double $<?php echo $products[2]['doubleprice'] ?> </strong> 
			</td>
			<td> <br> <strong>Quantity</strong> <br><br> <textarea name="Quantity_3" id="Quantity_3" rows="1" cols="3" required onchange="changePrice()">0</textarea> </td>
			<td> <br> <strong>Subtotal</strong> <br><br> <textarea name="Sub_3" id="Sub_3" rows="1" cols="4" required onfocus = "this.blur()";>0</textarea> </td>
		</tr>
		<tr> <td></td><td></td>
		<td style="text-align:right;"> Total:</td>
		<td> <textarea name="Total" id="Total" rows="1" cols="4" required onfocus = "this.blur()";>$0.00</textarea> </td>
		</tr>
		</table>
		<div style="margin:auto; width: 85%;">
			<input style="float:right;" id="billSubmit" type="submit" value="Check Out">
			<br>
		</div>
    </div>
  </div>
    <footer>
	  <i>Copyright &copy; 2014 JamJam Coffee House <br>
	  <a href = "mailto:Chenyang@Gu.com"> Chenyang@Gu.com </a>
	  </i>
    </footer>
</div>
</body>
</html>