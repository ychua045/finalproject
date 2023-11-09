<!--
-->
<?php 
session_start();
include "connectdb.php";

/*
We need to handle the situation when multiple customers are booking for a same show. 
1. A seat is reserved after a user selects it and before this user confirms the order. 
2. An order session is limited to 10 minutes. If users don't confirm their order in 10 minutes, they will receive an alert and be redirected to home page. 
3. A user can only process one booking at a time. If multiple bookings are opened but not confirmed by a user, only the last opened one will be valid. 
Information and seat reservations for previous unconfirmed ones are deleted and cannot be assessed. Old pages of . 
4. If a booking session expires or the user manually cancels it, all seats reserved but not confirmed for this user will be made available again to other users.
*/

//Define "Delete booking": Clear all $_SESSION variables except for member_id. Clear all the rows in tmpseats with the same member_id.
//Define "Create booking": Set $_SESSION['start_dt'], ['member_details'], ['show_details'], ['movie_details'], ['addons']. Clear all the rows in tmpseats with the same member_id.

//Check if user is logged in. If not logged in, alert and return to the home page. 
//if $_GET['showid'] is set: a new booking starts. Create booking. Refresh the page to clear $_GET. 
//if $_SESSION['start_dt'] is not set: No booking is being processed. Alert and return to home page. 
//if $_SESSION['start_dt'] is set and session exceeds 10 minutes, delete booking. Alert and return to home page. 
//Clean "tmpseats" in database. Remove all rows exceeding 10 minutes. 
/*
  if $_GET['seatrow'] is set:
  if the (show_id, seat_row, seat_col) already in "tmpseats": if the user_id is the same, delete the row. 
  else, add a row. 
  Refresh the page to clear $_GET. 
*/
//Load seat status from orderseat and tmpseats. Seats are 0=available, 1=currently selected, 2=occupied.

$num_seatrow = 3;
$num_seatcol = 10;
$time_expire = 10;

if (!isset($_SESSION['member_id'])) {?>
	<script> 
	alert("Please log in or register an account before booking. "); 
	window.location.href="member.php";
	</script>
	<?php
	exit();
}
if (isset($_GET['show_id'])) {
	$query = "select * from memberlist where member_id = ".$_SESSION['member_id'];
	$result = $db->query($query);
	$num_row = $result->num_rows;
	$_SESSION['member_details'] = $result->fetch_assoc();
	
	$query = "select * from showinfo where show_id = ".$_GET['show_id'];
	$result = $db->query($query);
	$num_row = $result->num_rows;
	$_SESSION['show_details'] = $result->fetch_assoc();
	
	$query = "select * from movieinfo where movie_id = ".$_SESSION['show_details']['movie_id'];
	$result = $db->query($query);
	$num_row = $result->num_rows;
	$_SESSION['movie_details'] = $result->fetch_assoc();
	
	$cinema_name = array();
	$query = "select * from cinemainfo";
	$result = $db->query($query);
	$num_row = $result->num_rows;
	for ($i=0; $i <$num_row; $i++) {
		$cinema_name[] = $result->fetch_assoc();
	}
	$_SESSION['show_details']['cinema_name'] = $cinema_name[$_SESSION['show_details']['cinema_id'] - 1]['cinema_name'];
	
	$_SESSION['addons'] = array();
	$query = "select * from addonmeals";
	$result = $db->query($query);
	$num_row = $result->num_rows;
	for ($i=0; $i <$num_row; $i++) {
		$_SESSION['addons'][] = $result->fetch_assoc();
		$_SESSION['addons'][$i]['meal_quantity'] = 0;
	}
	?>
	<script> 
	alert("A booking process is started. Time limit is <?php echo $time_expire;?> minutes.\nSelected seats will be reserved for you during this booking.\n\nPlease stay in this booking before confirmation. Starting another booking will cancel this one and all the seat reservation. ");
	</script>
	<?php
	$_SESSION['start_dt'] = date("Y-m-d H:i:s");
	$query = "delete from tmpseats where member_id = ".$_SESSION['member_id'];
	$db->query($query);
	?>
	<script> 
	window.location.href="seatselection.php";
	</script>
	<?php
	exit();
}
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
$query = "delete from tmpseats where TIMESTAMPDIFF(MINUTE, start_dt, '".$cur_dt."') > ".$time_expire;
$db->query($query);
if (isset($_GET['seat_row'])) {
	$query = "select * from tmpseats where seat_row = ".$_GET['seat_row']." and seat_col = ".$_GET['seat_col']." and show_id = ".$_SESSION['show_details']['show_id'];
	$result = $db->query($query);
	$num_row = $result->num_rows;
	if ($num_row == 0) {
		$query = "insert into tmpseats values 
		(".$_SESSION['show_details']['show_id'].", ".$_GET['seat_row'].", ".$_GET['seat_col'].", ".$_SESSION['member_id'].", '".$_SESSION['start_dt']."')";
		$db->query($query);
	}
	else {
		$seatdetails = $result->fetch_assoc();
		if ($seatdetails['member_id'] == $_SESSION['member_id']) {
			$query = "delete from tmpseats where seat_row = ".$_GET['seat_row']." and seat_col = ".$_GET['seat_col']." and show_id = ".$_SESSION['show_details']['show_id'];
			$result = $db->query($query);
		}
	}
	?>
	<script> 
	window.location.href="seatselection.php";
	</script>
	<?php
	exit();
}
$seatstatus = array();
$row = array();
for ($i=0; $i<$num_seatcol; $i++) {
	$row[] = 0;
}
for ($i=0; $i<$num_seatrow; $i++) {
	$seatstatus[] = $row;
}
$seats_occupied = array();
$seats_selected = array();
$query = "select seat_row, seat_col from tmpseats where show_id = ".$_SESSION['show_details']['show_id']." and member_id != ".$_SESSION['member_id'];
$result = $db->query($query);
$num_row = $result->num_rows;
for ($i=0; $i <$num_row; $i++) {
	$seats_occupied[] = $result->fetch_assoc();
}
$query = "select orderseat.seat_row, orderseat.seat_col from orderseat, orderlist 
		  where orderlist.show_id = ".$_SESSION['show_details']['show_id']." and orderlist.order_id = orderseat.order_id";
$result = $db->query($query);
$num_row = $result->num_rows;
for ($i=0; $i <$num_row; $i++) {
	$seats_occupied[] = $result->fetch_assoc();
}
$query = "select seat_row, seat_col from tmpseats where show_id = ".$_SESSION['show_details']['show_id']." and member_id = ".$_SESSION['member_id'];
$result = $db->query($query);
$num_row = $result->num_rows;
for ($i=0; $i <$num_row; $i++) {
	$seats_selected[] = $result->fetch_assoc();
}
for ($i=0; $i<count($seats_occupied); $i++) {
	$seatstatus[$seats_occupied[$i]['seat_row'] - 1][$seats_occupied[$i]['seat_col'] - 1] = 2;
}
for ($i=0; $i<count($seats_selected); $i++) {
	$seatstatus[$seats_selected[$i]['seat_row'] - 1][$seats_selected[$i]['seat_col'] - 1] = 1;
}
$num_tickets = count($seats_selected);
?>

<html lang="en">
<head>
	<title> CHUAN'GU Cinematics - Book Your Tickets</title>
	<meta charset = "utf-8">
	<link rel="stylesheet" href="css/seatncombo.css">
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


    <div id="seatselection">
		<div class="navmovies">
	        <a href="seatselection.php" class="active">Seat Selection</a>

	        <p class="inactive" style="color: #9d9d9d;">
	          <span>/</span>
	          <span>&nbsp;</span>
	          <span>Add-On Deals</span>
	        </p>

	        <p class="inactive" style="color: #9d9d9d;">
	        	<span>/</span> 
	        	<span>Confirmation</span>
	        </p>
		</div>



      <div class="movieinfo">
        <div class="theatreinfo">
          <div class="labelHeader"><?php echo $_SESSION['movie_details']['movie_name']; ?></div>
          <div class="div-4">
            <img src="<?php echo "image/".$_SESSION['movie_details']['poster']; ?>"/>
            <div class="div-5">
              <div class="div-6">
                <div class="movielabels" style="color:#B15EFF">Showing on:</div>
                <div class="desc" style="color:#FFF"><?php echo $_SESSION['show_details']['show_date']; ?></div>
                <div class="desc" style="color:#FFF"><?php echo $_SESSION['show_details']['show_time']; ?></div>
				<div class="desc" style="color:#FFF"><?php echo $_SESSION['show_details']['cinema_name']." Theatre"; ?></div>
				<div class="desc" style="color:#FFF"><?php echo "Hall ".$_SESSION['show_details']['hall_id']; ?></div>
              </div>
              <div class="div-6">
                <div class="movielabels"style="color:#B15EFF">Number of tickets:</div>
                <div class="desc"style="color:#FFF"><?php echo $num_tickets; ?></div>
              </div>
            </div>
          </div>
        </div>

        <div class="theatreinfo">
          <div class="labelHeader">Seat Selection</div>
          <div class="arrangement">
            <div class="screen">
            	<div class="theatrelabel">Movie screen</div>
            </div>
            <div class="placement">
			  <?php for ($i=0; $i<$num_seatrow; $i++) { ?>
				<div class="row1">
					<?php for ($j=0; $j<$num_seatcol; $j++) { 
						if ($seatstatus[$i][$j] == 2) {?>
							<img class="seat" src="<?php echo "image/seat_".$seatstatus[$i][$j].".png"; ?>"/>
						<?php } 
						else { ?>
							<a href="<?php echo "seatselection.php?seat_row=".($i + 1)."&seat_col=".($j + 1); ?>">
								<img class="seat" src="<?php echo "image/seat_".$seatstatus[$i][$j].".png"; ?>"/>
							</a>
						<?php } 
					} ?>
				</div>
			  <?php } ?>
            </div>
            <a class="next" href="addon.php">
				<span>Next</span>
            </a>

            <div class="legend">
              <div class="label">Legend</div>
              <div class="legendtype">
                <div class="indicate">Occupied</div>
                <img class="img" src="image/seat_2.png" />
              </div>
              <div class="legendtype">
                <div class="indicate">Available</div>
                <img class="img" src="image/seat_0.png" />
              </div>
              <div class="legendtype">
                <div class="indicate">Selected</div>
                <img class="img" src="image/seat_1.png" />
              </div>
            </div>
          </div>
        </div>
      </div>
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