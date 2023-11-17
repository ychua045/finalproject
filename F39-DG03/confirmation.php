<!--
--><!--
-->
<?php 
session_start();
include "connectdb.php";

/*
1. An order session is limited to 10 minutes. If users don't confirm their order in 10 minutes, they will receive an alert and be redirected to home page. 
2. A user can only process one booking at a time. If multiple bookings are opened but not confirmed by a user, only the last opened one will be valid. 
3. If a booking session expires / the user manually cancels it / the user has opened another booking: 
   This booking is canceled. All seats reserved but not confirmed for this booking are made available again to other users.
*/

/*
Check if user is logged in. If not logged in, alert and return to the home page. 

if $_GET['orderid'] is set: 
	Check if this order belongs to the current user. If not, alert and redirect to member.php. 
	if $_GET['email'] is set: send email, Alert and Return to confirmation.php?orderid=xxx.
	Set all variables for display from this order_id. 
	$displaymode = "confirmed";
else:
	if $_SESSION['start_dt'] is not set: No booking is being processed. Alert and return to home page. 
	if $_SESSION['start_dt'] is set and session exceeds 10 minutes, delete booking. Alert and return to home page. 
	if $_GET['confirm'] is set: Delete booking. Return to home page. 
	if $_GET['confirm'] is set:
		Check if number of seats = 0, if so, alert and redirect to seatselection.php. 
		delete from tmpseats. update orderlist, orderseat, orderaddon. 
		Alert and Redirect to confirmation.php?orderid=xxx.
	$displaymode = "temporary";
	set all variables for display from $_SESSION.
	
In temporary mode there will be confirm booking button, cancel booking button. No Booking id displayed.
In confirmed mode there will be send email button, close button. Booking id displayed.
*/

$time_expire = 10;

if (!isset($_SESSION['member_id'])) {?>
	<script> 
	alert("Please log in or register an account first. "); 
	window.location.href="member.php";
	</script>
	<?php
	exit();
}
if (isset($_GET['orderid'])) {
	$query = "select * from memberlist where member_id = ".$_SESSION['member_id'];
	$result = $db->query($query);
	$member_details = $result->fetch_assoc();
	
	if (isset($_GET['email'])) {
		$confirmationPageUrl = "http://localhost:8000".$_SERVER['PHP_SELF']."?orderid=".$_GET['orderid'];
		$to = $member_details['member_email']; 
		$subject = '[ChuaNGu Cinematics] Movie Booking Details'; 
		$message = "Dear ".$member_details['member_name'].":\n\nAs requested, here is the link for your booking details. \n"
					.$confirmationPageUrl."\nThank you and have a great day ahead!\n\nChuaNGu Cinematics\n"; 
		$headers = 'From: chuangu@localhost' . "\r\n" . 'Reply-To: chuangu@localhost' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
		mail($to, $subject, $message, $headers, '-fchuangu@localhost');
		?>
		<script> 
		alert("Email sent successfully. "); 
		window.location.href="confirmation.php?orderid=<?php echo $_GET['orderid'];?>";
		</script>
		<?php
		exit();
	}
	$query = "select * from orderlist where order_id = ".$_GET['orderid'];
	$result = $db->query($query);
	$num_row = $result->num_rows;
	if ($num_row == 0) {
		?>
		<script> 
		alert("This booking ID does not exist. Redirecting to home page. "); 
		window.location.href="index.php";
		</script>
		<?php
		exit();
	}
	$orderdetail = $result->fetch_assoc();
	
	if ($orderdetail['account_id'] != $_SESSION['member_id']) {
		?>
		<script> 
		alert("This booking does not belong to your account. Redirecting to home page. "); 
		window.location.href="index.php";
		</script>
		<?php
		exit();
	}
	
	$query = "select * from showinfo where show_id = ".$orderdetail['show_id'];
	$result = $db->query($query);
	$showdetail = $result->fetch_assoc();	
	
	$query = "select * from movieinfo where movie_id = ".$showdetail['movie_id'];
	$result = $db->query($query);
	$moviedetail = $result->fetch_assoc();
	
	$seats = array();
	$query = "select seat_row, seat_col from orderseat where order_id = ".$orderdetail['order_id'];
	$result = $db->query($query);
	$num_row = $result->num_rows;
	for ($j=0; $j <$num_row; $j++) {
		$seats[] = $result->fetch_assoc();
	}
	$num_tickets = count($seats);

	$tmp_total = 0;
	$addons = array();
	$query = "select * from orderaddon where order_id = ".$orderdetail['order_id'];
	$result = $db->query($query);
	$num_row = $result->num_rows;
	for ($j=0; $j <$num_row; $j++) {
		$addons[] = $result->fetch_assoc();
		$addons[$j]['subtotal'] = $addons[$j]['meal_price'] * $addons[$j]['meal_quantity'];
		$tmp_total += $addons[$j]['subtotal'];
	}
	$seat_subtotal = $num_tickets * $showdetail['ticket_price'];
	$tmp_total += $seat_subtotal;
	$order_subtotal = $tmp_total;
	
	$cinemas = array();
	$query = "select cinema_name from cinemainfo";
	$result = $db->query($query);
	$num_cinemas = $result->num_rows;
	for ($i=0; $i <$num_cinemas; $i++) {
		$cinemas[] = $result->fetch_assoc()['cinema_name'];
	}
	
	$displaymode = "confirmed";
}
else {
	if (!isset($_SESSION['start_dt'])) {
		?>
		<script> 
		alert("You don't have a booking in process. Please select a show from the home page to start your booking.");
		window.location.href="index.php";
		</script>
		<?php
		exit();
	}
	$cur_dt = date("Y-m-d H:i:s"); 
	$from_time = strtotime($_SESSION['start_dt']); 
	$to_time = strtotime($cur_dt); 
	$diff_minutes = round(abs($from_time - $to_time) / 60,2);
	if ($diff_minutes > $time_expire) {
		if (isset($_SESSION['member_id'])) $memberid = $_SESSION['member_id'];
		$_SESSION = [];
		if (isset($memberid)) $_SESSION['member_id'] = $memberid;
		$query = "delete from tmpseats where member_id = ".$_SESSION['member_id'];
		$db->query($query);
		?>
		<script> 
		alert("<?php echo "Your booking has expired. The limit time for a booking is ".$time_expire." minutes.";?>");
		window.location.href="index.php";
		</script>
		<?php
		exit();
	}
	if (isset($_GET['cancel'])) {
		if (isset($_SESSION['member_id'])) $memberid = $_SESSION['member_id'];
		$_SESSION = [];
		if (isset($memberid)) $_SESSION['member_id'] = $memberid;
		$query = "delete from tmpseats where member_id = ".$_SESSION['member_id'];
		$db->query($query);
		?>
		<script>
		window.location.href="index.php";
		</script>
		<?php
		exit();
	}
	$seats = array();
	$query = "select seat_row, seat_col from tmpseats where show_id = ".$_SESSION['show_details']['show_id']." and member_id = ".$_SESSION['member_id'];
	$result = $db->query($query);
	$num_row = $result->num_rows;
	for ($i=0; $i <$num_row; $i++) {
		$seats[] = $result->fetch_assoc();
	}
	$num_tickets = count($seats);
	
	if (isset($_GET['confirm'])) {
		if ($num_tickets == 0) {
			?>
			<script> 
			alert("Please select at least one seat for your order. ");
			window.location.href="seatselection.php";
			</script>
			<?php
			exit();
		}
		/*validate and make the card payment. if not successful, alert and redirect to confirmation.php. */
		$query = "delete from tmpseats where show_id = ".$_SESSION['show_details']['show_id']." and member_id = ".$_SESSION['member_id'];
		$db->query($query);
		$query = "insert into orderlist (order_dt, account_id, show_id, num_tickets, ticket_price) values 
				('".$cur_dt."', ".$_SESSION['member_id'].", ".$_SESSION['show_details']['show_id'].", 
				".$num_tickets.", ".$_SESSION['show_details']['ticket_price'].")";
		$db->query($query);
		
		$query = "select order_id from orderlist where order_dt = '".$cur_dt."' and account_id = ".$_SESSION['member_id'];
		$result = $db->query($query);
		$order_id = $result->fetch_assoc()['order_id'];
		
		for ($i=0; $i<count($seats); $i++) {
			$query = "insert into orderseat values 
				(".$order_id.", ".$seats[$i]['seat_row'].", ".$seats[$i]['seat_col'].")";
			$db->query($query);
		}
		for ($i=0; $i<count($_SESSION['addons']); $i++) {
			if ($_SESSION['addons'][$i]['meal_quantity'] == 0) continue;
			$query = "insert into orderaddon values 
				(".$order_id.", '".$_SESSION['addons'][$i]['meal_name']."', 
				".$_SESSION['addons'][$i]['meal_price'].", ".$_SESSION['addons'][$i]['meal_quantity'].")";
			$db->query($query);
		}	
		if (isset($_SESSION['member_id'])) $memberid = $_SESSION['member_id'];
		$_SESSION = [];
		if (isset($memberid)) $_SESSION['member_id'] = $memberid;
		?>
		<script> 
		alert("Your booking was successful. ");
		window.location.href="confirmation.php?orderid=<?php echo $order_id; ?>";
		</script>
		<?php
		exit();
	}
	
	$query = "select * from memberlist where member_id = ".$_SESSION['member_id'];
	$result = $db->query($query);
	$member_details = $result->fetch_assoc();
	
	$showdetail = $_SESSION['show_details'];
	$moviedetail = $_SESSION['movie_details'];

	$tmp_total = 0;
	$addons = array();
	for ($i=0; $i<count($_SESSION['addons']); $i++) {
		if ($_SESSION['addons'][$i]['meal_quantity'] == 0) continue; 
		$addons[] = $_SESSION['addons'][$i];
	}
	for ($j=0; $j <count($addons); $j++) {
		$addons[$j]['subtotal'] = $addons[$j]['meal_price'] * $addons[$j]['meal_quantity'];
		$tmp_total += $addons[$j]['subtotal'];
	}
	$seat_subtotal = $num_tickets * $showdetail['ticket_price'];
	$tmp_total += $seat_subtotal;
	$order_subtotal = $tmp_total;
	
	$cinemas = array();
	$query = "select cinema_name from cinemainfo";
	$result = $db->query($query);
	$num_cinemas = $result->num_rows;
	for ($i=0; $i <$num_cinemas; $i++) {
		$cinemas[] = $result->fetch_assoc()['cinema_name'];
	}
	
	$displaymode = "temporary";
}
?>
<!-- index.html -->
<html lang="en">
<head>
	<title> CHUAN'GU Cinematics - Book Your Tickets</title>
	<meta charset = "utf-8">
	<link rel="stylesheet" href="css/confirmation.css">
	<!-- fonts/icons -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter&family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
	<script> 
		document.addEventListener("visibilitychange", () => {
		  if (document.visibilityState == "visible") {
			//alert("You have lefted this page. Contents will be reloaded. ");
			location.reload();
		  }
		});
		function checkcancel() {
			if (confirm("Cancel this booking?") == true) {
				window.location.href="confirmation.php?cancel=1; ?>";
			}
		}
		function checkconfirm() {
			if (confirm("Confirm and pay for this booking?") == true) {
				window.location.href="confirmation.php?confirm=1; ?>";
			}
		}	
	</script> 
</head>

<body>
	<div class="container-home">
		<div id="header">  
	      	<div class="main-container">
		        <div id="logo">
		          <a href="index.php">
		            <img src="image/ie4717.png" title="4717">
		          </a>
		        </div>

		        <div id="top-right">
		          <ul class="nav-home">
		            <li><a href="index.php">Home</a></li>
		            <li><a href="index.php#movies" style="color: #FFFFFF;">Movies</a></li>
		            <li><a href="member.php">Account</a></li>
		            <li><a href="contact.php">Contact Us</a></li>		            		           
		          </ul>      
		        </div>
	        </div>
	    </div>
	</div>
	
	<div id="confirmation">
		<?php if ($displaymode == "temporary") { ?>
		<div class="navmovies">
			<p class="inactive">
				<a href="seatselection.php" class="inactive"> Seat Selection</a>
				<span>&nbsp;</span>
				<span>/</span>
			</p>

			<p class="inactive">
				<a href="addon.php" class="inactive"> Add-On Deals</a>
				<span>&nbsp;</span>
				<span>/</span>
			</p>

	        <a href="confirmation.php" class="active">Confirmation</a>
		</div>
		<?php } ?>
		<div class="pageOrder">
			<div class="orderSummary">
				<?php if ($displaymode == "confirmed") { ?>
				<div class="labelHeader">Your Booking</div>
				<p class="bookingDesc"> Your booking is successful! <br>
						You can check all your previous bookings in your 
						<a href="member.php" style="text-decoration: none; color:#9d9d9d;">
						<strong> Account </strong></a> page. <br>
						Thank you for booking your enjoyment with ChuaN’Gu Cinematics! 
				</p>
				<?php } 
				else {?>
				<div class="labelHeader">Your Cart</div>
				<?php } ?>
				<table class="summary">
					<tr>
						<th class="left" colspan="2">
							<?php if ($displaymode == "confirmed") { ?>
							<span class="bookingID" id="bookingDate" style="color:#fff"> <?php echo $orderdetail['order_dt']; ?> </span>
							<?php } ?>
						</th>

						<th class="right" colspan="2">
							<?php if ($displaymode == "confirmed") { ?>
							<span class="bookingID" id="bookingID" style="color:#fff"> <?php echo "Booking ID: ".sprintf("%09d", $orderdetail['order_id']); ?> </span>
							<?php } ?>
						</th>	
					</tr>

					<tr>
						<td class="movietitle" colspan="4">
							<span> <?php echo $moviedetail['movie_name']; ?> </span>
						</td>
					</tr>					

					<tr class="orderItems">
						<td class="orderInfo" colspan="4">
						  <div class="div-4">
							<img src="image/<?php echo $moviedetail['poster']; ?>"/>
							<div class="div-5">
							  <div class="div-6">
								<div class="movielabels" style="color:#B15EFF">Showing on:</div>
								<div class="desc" style="color:#FFF"><?php echo $showdetail['show_date']; ?></div>
								<div class="desc" style="color:#FFF"><?php echo $showdetail['show_time']; ?></div>
								<div class="desc" style="color:#FFF"><?php echo $cinemas[$showdetail['cinema_id'] - 1]." Theatre"; ?></div>
								<div class="desc" style="color:#FFF"><?php echo "Hall ".$showdetail['hall_id']; ?></div>
							  </div>
							  <div class="div-6">
								<div class="movielabels"style="color:#B15EFF">Number of tickets:</div>
								<div class="desc"style="color:#FFF"><?php echo $num_tickets; ?></div>
								<?php for ($j=0; $j<$num_tickets; $j++) { ?>
									<div class="desc"style="color:#FFF">
									<?php echo "Row ".$seats[$j]['seat_row']." Seat ".$seats[$j]['seat_col']; ?>
									</div>
								<?php } ?>
							  </div>
							</div>
						  </div>			    	
						</td>
					</tr>

					<tr class="orderItems">
						<td class="left">
							<span class="orderHeader"> ITEMS </span>
						</td>

						<td class="mid">
							<span class="orderHeader"> COST </span>
						</td>

						<td class="mid">
							<span class="orderHeader"> QTY </span>
						</td>

						<td class="right">
							<span class="orderHeader"> SUB TOTAL </span>
						</td>
					</tr>
					
					<tr>
						<td class="left">
							<span class="orderBody"> Movie ticket </span>
						</td>

						<td class="mid">
							<span class="orderBody"> <?php echo "$".$showdetail['ticket_price']; ?> </span>
						</td>

						<td class="mid">
							<span class="orderBody"> <?php echo $num_tickets; ?> </span>
						</td>

						<td class="right">
							<span class="orderBody"> <?php echo "$".$seat_subtotal; ?> </span>
						</td>
					</tr>
					
					<?php for ($j=0; $j<count($addons); $j++) { ?>
						<tr>
							<td class="left">
								<span class="orderBody"> <?php echo $addons[$j]['meal_name']; ?> </span>
							</td>

							<td class="mid">
								<span class="orderBody"> <?php echo "$".$addons[$j]['meal_price']; ?> </span>
							</td>

							<td class="mid">
								<span class="orderBody"> <?php echo $addons[$j]['meal_quantity']; ?> </span>
							</td>

							<td class="right">
								<span class="orderBody"> <?php echo "$".$addons[$j]['subtotal']; ?> </span>
							</td>
						</tr>
					<?php } ?>

					<tr class="orderItems">
						<td class="left" colspan="2">
							<span class="orderHeader" style="color:#fff"> TOTAL COST </span>
						</td>

						<td class="right" colspan="2">
							<span class="totalPrice"> <?php echo "$".$order_subtotal; ?> </span>
						</td>					
					</tr>
				</table>
			</div>

			<div class="orderSummary">
		      <div class="labelHeader">Particulars</div>

				<div class="particulars">
			  		<div class="indivparticular">
					    <div class="particularLabel">Name:</div>
					    <span class="particularDetails" id="particularName"><?php echo $member_details['member_name']; ?></span>
				  	</div>

			  		<div class="indivparticular">
					    <div class="particularLabel">Email:</div>
					    <span class="particularDetails" id="particularEmail"><?php echo $member_details['member_email']; ?></span>
		  			</div>
  					<div class="indivparticular">
					    <div class="particularLabel">Phone:</div>
					    <div class="particularDetails" id="particularPhone"><?php echo substr($member_details['member_hp'], 0, 4)." ".substr($member_details['member_hp'], 4, 4); ?></div>
		  			</div>
	  				<div class="indivparticular">
					    <div class="particularLabel">Card number:</div>
					    <div class="particularDetails" id="particularCard"><?php echo "**** **** **** ".substr($member_details['member_card'], 12, 4); ?></div>
		  			</div>
				</div>
			</div>
	    </div>
		<?php if ($displaymode == "confirmed") { ?>
      	<div class="div-5">

			<a class="cancelTransaction" id="cancelTransaction" href="index.php">
				<span>Return to home</span>
			</a>

      		<a href ="confirmation.php?orderid=<?php echo $_GET['orderid']; ?>&email=1" style="text-decoration: none;">
				<button type="submit" class="submitTransaction" id="sendEmail">Send to email</button>
			</a>				
      	</div>
		<?php } 
		else { ?>
		<div class="div-5">
			<button type="button" class="cancelTransaction" id="cancelTransaction" onclick="checkcancel()">Cancel</button>
      		<button type="button" class="submitTransaction" id="submitTransaction" onclick="checkconfirm()">Confirm</button>				
      	</div>
		<?php } ?>
	</div>

    <footer>
	    <div id="footer">
	      <div class="footercontent">
	        <div class="footersection1">
	          <div class="footerLabel">About ChuaN’Gu Cinematics</div>
	          <p class="footerdesc"> ChuaN’Gu Cinematics is a fun and exciting cinema that aims to bring you<br/>ultimate joy. Catch the latest
	            movies here!
	          </p>
	        </div>
	        <div class="footersectionmid">
				<div class="footerLabel">Quick Links</div>
				<div class="footersectionmid1">
					<div class="footersectioncol">
						<div class="footerdesc1">
							<a href="index.php">Home</a>
						</div>				
						<div class="footerdesc1">
							<a href="index.php#movies">Movies</a>
						</div>
					</div>

					<div class="footersectioncol">
						<div class="footerdesc1">
							<a href="member.php">Account</a>
						</div>
						<div class="footerdesc1">
							<a href="contact.php">Contact Us</a>
						</div>
					</div>
				</div>
	        </div>
	        <div class="footersectionmid">
				<div class="footerLabel">Visit Us</div>
				<p class="footerdesc">123 Orchard Road, Singapore 12345</p>
				<p class="footerdesc">Monday to Sunday, 0900 - 1930</p>
	        </div>
	        <div class="footersection2">
			  	<div class="footerLabel">Contact Us</div>
			  	<div class="footerdesc">6123 4567</div>
			  	<div class="footerdesc">chuangu@localhost</div>
				<div class="socials">
					<img src="image/insta.png" title="insta"  width="30px" height="30px">
					<img src="image/fb.png" title="fb"  width="30px" height="30px">
				</div>
	        </div>
	      </div>
	      <hr>
	      <p class="copyright">&copy Copyright 2023 ChuaN’Gu Cinematics</p>
	    </div>
    </footer>


</body>
</html>