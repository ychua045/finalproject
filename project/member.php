<!--
-->
<?php 
session_start();
include "connectdb.php";

// Clear all _session except member id. 
// If _get['logout'], unset _session member id and refresh page. 
// If _post['memEmail']. Check if member exists. Check password. If correct: set _session['member_id']. Otherwise, alert. (two types). 
// if logged in. Show links to logout, and change particulars page. 
// Not logged in. Show the link to register.php. Show the form to enter email and password. JS check format and length until correct. 

if (isset($_SESSION['member_id'])) $memberid = $_SESSION['member_id'];
$_SESSION = [];
if (isset($memberid)) $_SESSION['member_id'] = $memberid;

if (isset($_GET['logout'])) {
	unset($_SESSION['member_id']);
	?>
	<script> 
	alert("You have been logged out."); 
	window.location.href="member.php";
	</script>
<?php }

if (isset($_POST['memEmail'])) {
	$query = "select * from memberlist where member_email = '".$_POST['memEmail']."'";
	$result = $db->query($query);
	$num_row = $result->num_rows;
	if ($num_row == 0) {?>
		<script> 
		alert("Sorry, your account does not exist. "); 
		window.location.href="member.php";
		</script>
	<?php }
	for ($i=0; $i <$num_row; $i++) {
		$memberdetails = $result->fetch_assoc();
	}
	if ($memberdetails['member_password'] != $_POST['memPassword']) { ?> 
		<script> 
		alert("Sorry, your password is incorrect. "); 
		window.location.href="member.php";
		</script>
	<?php }
	$_SESSION['member_id'] = $memberdetails['member_id'];
}
if (isset($_SESSION['member_id'])) {
	$orders = array();
	$query = "select * from orderlist where account_id = ".$_SESSION['member_id']." order by order_dt";
	$result = $db->query($query);
	$num_orders = $result->num_rows;
	for ($i=0; $i <$num_orders; $i++) {
		$orders[] = $result->fetch_assoc();
	}
	for ($i=0; $i <$num_orders; $i++) {
		$query = "select * from showinfo where show_id = ".$orders[$i]['show_id'];
		$result = $db->query($query);
		$num_row = $result->num_rows;
		for ($j=0; $j <$num_row; $j++) {
			$orders[$i]['showdetail'] = $result->fetch_assoc();
		}
		$query = "select * from movieinfo where movie_id = ".$orders[$i]['showdetail']['movie_id'];
		$result = $db->query($query);
		$num_row = $result->num_rows;
		for ($j=0; $j <$num_row; $j++) {
			$orders[$i]['moviedetail'] = $result->fetch_assoc();
		}
		$orders[$i]['seats'] = array();
		$query = "select seat_row, seat_col from orderseat where order_id = ".$orders[$i]['order_id'];
		$result = $db->query($query);
		$num_row = $result->num_rows;
		for ($j=0; $j <$num_row; $j++) {
			$orders[$i]['seats'][] = $result->fetch_assoc();
		}
		$orders[$i]['addons'] = array();
		$query = "select * from orderaddon where order_id = ".$orders[$i]['order_id'];
		$result = $db->query($query);
		$num_row = $result->num_rows;
		for ($j=0; $j <$num_row; $j++) {
			$orders[$i]['addons'][] = $result->fetch_assoc();
		}
	}
	
	$cinemas = array();
	$query = "select cinema_name from cinemainfo";
	$result = $db->query($query);
	$num_cinemas = $result->num_rows;
	for ($i=0; $i <$num_cinemas; $i++) {
		$cinemas[] = $result->fetch_assoc()['cinema_name'];
	}
}
	
?>

<html lang="en">
<head>
	<title> CHUAN'GU Cinematics - Book Your Tickets</title>
	<meta charset = "utf-8">
	<link rel="stylesheet" href="css/style.css">
	<!-- fonts/icons -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter&family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400&family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
	
	<style>
	.errormsg{
		color: red;
		padding-left: 120px;
		margin-top: 0px;
		font-size: 12px;
	}
	</style> 
	<script type="text/javascript" src="formvalidation.js"></script>
</head>

<body>
	<div class="container-home">
		<div id="header">  
	      	<div class="main-container">
		        <div id="logo">
		          <a href="index.php">
		            <img src="image/ie4717.png" title="4717" width= "150px" height= "150px">
		          </a>
		        </div>

		        <div id="top-right">
		          <ul class="nav-home">
		            <li><a href="index.php">Home</a></li>
		            <li><a href="movie.php">Movies</a></li>
		            <li><a href="member.php">Account</a></li>
		            <li><a href="contact.php">Contact Us</a></li>		            		            
		          </ul>      
		        </div>
	        </div>
	    </div>
	</div>
	<?php if (isset($_SESSION['member_id'])) { ?>
		<br><br>
		<button type="button" onclick="window.location.href='member.php?logout=1'">Log out</button>
		
		<?php for($i=0; $i<$num_orders; $i++) { ?>
			
			<table> 
			<tr> <td> <img src="image/<?php echo $orders[$i]['moviedetail']['poster']; ?>"> </td> </tr>
			<tr> <td> <?php echo $orders[$i]['moviedetail']['movie_name']; ?> </td> </tr>
			<tr> <td> <?php echo $cinemas[$orders[$i]['showdetail']['cinema_id'] - 1]; ?> </td> </tr>
			<tr> <td> <?php echo "Hall ".$orders[$i]['showdetail']['hall_id']; ?> </td> </tr>
			<tr> <td> <?php echo $orders[$i]['showdetail']['show_date']; ?> </td> </tr>
			<tr> <td> <?php echo $orders[$i]['showdetail']['show_time']; ?> </td> </tr>
			<tr> <td> Number of Tickets: <?php echo $orders[$i]['num_tickets']; ?> </td> </tr>
			
			<?php for ($j=0; $j<$orders[$i]['num_tickets']; $j++) { ?>
				<tr> <td> <?php echo "Row ".$orders[$i]['seats'][$j]['seat_row']." Seat ".$orders[$i]['seats'][$j]['seat_col']; ?> </td> </tr>
			<?php } ?>
			<?php for ($j=0; $j<count($orders[$i]['addons']); $j++) { ?>
				<tr> <td> <?php echo $orders[$i]['addons'][$j]['meal_name']." ".$orders[$i]['addons'][$j]['meal_price']." ".$orders[$i]['addons'][$j]['meal_quantity']; ?> </td> </tr>
			<?php } ?>
			</table>
		<?php } ?>
		
	<?php } else { ?>
		<form id="LoginForm" method="post" action="member.php">	
		<div>
		  <label for="memEmail"> E-mail:</label>
		  <input type="email" name="memEmail" id="memEmail" required placeholder = "Enter your Email here" onchange="chkEmail()">
	    </div>
	    <p id="emailError" class="errormsg"></p>
		
		<div>
		  <label for="memPassword"> Password: </label>
		  <input type="password" name="memPassword" id="memPassword" required placeholder = "Enter your password here" onchange="chkPassword()">
	    </div>
	    <p id="passwordError" class="errormsg"></p>
		<button type="button" onclick="window.location.href='memberinfo.php'">Sign up</button>
		<button type="button" onclick="loginSubmit()">Log in</button>
		</form>
	<?php } ?>
	
    <footer>
		<div id="footer">
			<div class="footersection">
				<p class="labels"> About ChuaN’Gu Cinematics </p>
				<p class="wording">ChuaN’Gu Cinematics is a fun and exciting cinema that aims to bring you ultimate joy. Catch the latest movies here! </p>
			</div>

			<div class="footersection">
				<p class="labels"> Quick Links </p>
		    	<a class="wording" href="movie.php">Movies</a>
		    	<a class="wording" href="member.php">Account</a>
		    	<a class="wording" href="contact.php">Contact us</a>
			</div>	

			<div class="footersection">
		    	<p class="labels"> Keep In Touch </p>
		    	<p class="wording"> +65 9123 4567 <br> chuangu@gmail.com </p>
		    	<div class="socials">
		    		<a href="https://instagram.com" target="_blank"><img src="image/insta.png" title="insta"  width="30px" height="30px"></a>
		    		<a href="https://facebook.com" target="_blank"><img src="image/fb.png" title="fb"  width="30px" height="30px"></a>
		    	</div>
			</div>	
		</div>
    </footer>
</body>
</html>