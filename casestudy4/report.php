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

$products = array();
$result = $db->query($query);
$num_products = $result->num_rows;
for ($i=0; $i <$num_products; $i++) {
 $products[] = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
	if (isset($_POST["option"])) $reporttype = $_POST["option"];
	else $reporttype = $_SESSION['reporttype'];
	$reportdate = $_POST["date"];
	$_SESSION['reporttype'] = $reporttype;
	$_SESSION['reportdate'] = $reportdate;
	$table_array = array();
	$most_popular = 0;
	$decimal_place = 2;
	if ($_SESSION["reporttype"] == "quantity") $decimal_place = 0;
	for ($i = 0; $i < $num_products; $i ++) {
	    $tmp = array();
		$tmp[] = $products[$i]["name"];
		$item_subtotal = 0;
		for ($j = 0; $j < 3; $j ++) {
			if ($products[$i][$pricecol[$j]] == Null) {
				$tmp[] = "/";
			}
			else {
				$cur_itemid = $i + 1;
				if ($_SESSION["reporttype"] == "quantity") {
					$query = 'select sum(quantity) as total from purchaselist where orderdate = \''.$reportdate.'\' and itemid = '.$cur_itemid.' and itemtype = '.$j.';';
					$itemtype_num = $db->query($query)->fetch_assoc()["total"];
					if ($itemtype_num == Null) $itemtype_num = 0;					
				}
				else {
					$query = 'select sum(subtotal) as total from purchaselist where orderdate = \''.$reportdate.'\' and itemid = '.$cur_itemid.' and itemtype = '.$j.';';
					$itemtype_num = $db->query($query)->fetch_assoc()["total"];
					if ($itemtype_num == Null) $itemtype_num = 0;	
				}
				$tmp[] = number_format($itemtype_num, $decimal_place);
				$item_subtotal += $itemtype_num;
				$most_popular = max($most_popular, $itemtype_num);
			}
		}
		$tmp[] = number_format($item_subtotal, $decimal_place);
		$table_array[] = $tmp;
	}
	$tmp = array();
	$tmp[] = "Total";
	$col_cnt = 5;
	for ($j = 1; $j < $col_cnt; $j ++) {
		$col_subtotal = 0;
		for ($i = 0; $i < $num_products; $i ++) if ($table_array[$i][$j] != "/") $col_subtotal += $table_array[$i][$j];
		$tmp[] = number_format($col_subtotal, $decimal_place);
	}
	$table_array[] = $tmp;
	$color_array = array();
	for ($i = 0; $i < $num_products; $i ++) {
		$tmp_color = array();
		for ($j = 0; $j < $col_cnt; $j ++) $tmp_color[] = "#000000";
		for ($j = 1; $j < $col_cnt - 1; $j ++) {
			if ($table_array[$i][$j] == $most_popular) $tmp_color[$j] = "#FF0000";
		}
		$color_array[] = $tmp_color;
	}
	$table_header = array("Category", "Endlees Cup", "Single", "Double", "Subtotal");
	$header_id = array("Category", "Endlees", "Single", "Double", "Subtotal");
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
table, th, td {border: #f5f5dd; text-align: center;}
th, td {height: 40px;}
tbody td { border-bottom: 2px dashed #000000;}
thead th { border-bottom: 2px solid #000000;}
tbody tr:last-child td { border-bottom: 4px double #000000;}
tr td:first-child { font-weight: bold;}
tr td:last-child { font-weight: bold;}
tfoot td { font-weight: bold;}
textarea {
	resize:none;
	}
.reportheading {
	 font-size: 110%; 
	 font-weight: bold;
}

</style>
<script type="text/javascript">
	function submitForm() {
		var date = document.getElementById('date').value;
		<?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
			if (date) document.getElementById('reportForm').submit();
		<?php } 
		else {?>
			var radioInput = document.querySelector('input[name="option"]:checked');
			if (date && radioInput) {
				document.getElementById('reportForm').submit();
			}
		<?php } ?>
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
	<?php if ($_SERVER["REQUEST_METHOD"] == "POST") { 
		if ($_SESSION["reporttype"] == "dollar") { ?>
			<div class="reportheading"> Total dollar sales by product items </div>
		<?php } else { ?>
			<div class="reportheading"> Sales quantities by product categories </div>
		<?php }?>
		<form id="reportForm" action="report.php" method="post">
			<br>
			<label for="date"> Date:</label>
			<input type="date" id="date" name="date" value="<?php echo $reportdate;?>" onchange="submitForm()"> 
			<br><br>
		</form> 
		<table> 
		<thead>
		<tr>
			<?php for ($i=0; $i<$col_cnt; $i ++) { ?>
				<th id = <?php echo $header_id[$i]; ?>> <?php echo $table_header[$i]; ?> </th>
			<?php } ?>
		</tr>
		</thead>
		<tbody> 
		<?php for ($j=0; $j<count($products); $j ++) { ?>
			<tr>
			<?php for ($i=0; $i<$col_cnt; $i ++) { ?>
				<td headers = <?php echo $header_id[$i]; ?> style="color: <?php echo $color_array[$j][$i]; ?>;"> 
				<?php echo $table_array[$j][$i]; ?> 
				</td>
			<?php } ?>
			</tr>
		<?php } ?>
		</tbody>
		<tfoot>
		<tr>
			<?php for ($i=0; $i<$col_cnt; $i ++) { ?>
				<td headers = <?php echo $header_id[$i]; ?>> <?php echo $table_array[count($products)][$i]; ?> </td>
			<?php } ?>
		</tr>
		</tfoot> 
		</table>
	<?php }  
	else {?>
	    <div class="reportheading">Click to generate daily sales report: </div> <br>
	    <form id="reportForm" action="report.php" method="post">
			<label for="date"> Date:</label>
			<input type="date" id="date" name="date" onchange="submitForm()"> <br><br>
			
			<input type="radio" id="option1" name="option" value="dollar" onchange="submitForm()">
			<div class="reportheading" style="display: inline-block;">Total dollar sales by product items </div> <br><br>

			<input type="radio" id="option2" name="option" value="quantity" onchange="submitForm()">
			<div class="reportheading" style="display: inline-block;">Sales quantities by product categories </div> <br><br>
		</form>
	<?php } ?>
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