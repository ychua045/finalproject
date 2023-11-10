<!--
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

//Check if user is logged in. If not logged in, alert and return to the home page. 
//if $_SESSION['start_dt'] is not set: No booking is being processed. Alert and return to home page. 
//if $_SESSION['start_dt'] is set and session exceeds 10 minutes, delete booking. Alert and return to home page. 
$time_expire = 10;
if (!isset($_SESSION['member_id'])) {?>
	<script> 
	alert("Please log in or register an account before booking. "); 
	window.location.href="member.php";
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
if (isset($_GET['itemid'])) {
	if ($_GET['itemaction'] == '1') {
		$_SESSION['addons'][$_GET['itemid']]['meal_quantity'] += 1;
	}
	else {
		$_SESSION['addons'][$_GET['itemid']]['meal_quantity'] -= 1;
		if ($_SESSION['addons'][$_GET['itemid']]['meal_quantity'] < 0) $_SESSION['addons'][$_GET['itemid']]['meal_quantity'] = 0;
	}
	?>
	<script> 
	window.location.href="addon.php";
	</script>
	<?php
	exit();
}
?>
<!-- index.html -->
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
		document.addEventListener("DOMContentLoaded", function (event) {
			var scrollpos = localStorage.getItem("scrollpos");
			if (scrollpos) window.scrollTo(0, scrollpos);
		});

		window.onscroll = function (e) {
			localStorage.setItem("scrollpos", window.scrollY);
		};
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
			<p class="inactive">
				<a href="seatselection.php" class="inactive"> Seat Selection</a>
				<span>&nbsp;</span>
				<span>/</span>
			</p>

	        <a href="addon.php" class="active">Add-On Deals</a>

	        <p class="inactive" style="color: #9d9d9d;">
	        	<span>/</span> 
	        	<span>Confirmation</span>
	        </p>
		</div>


        <div class="combos">
            <div class="labelHeader">Add-On Deals</div>
            <div class="combocontainer">
			<?php for($i=0; $i<count($_SESSION['addons']); $i++) { ?>
				<div class="indivcombo">
				  <img class="img" src="<?php echo "image/".$_SESSION['addons'][$i]['meal_image']; ?>" />
				  <p class="comboname"><?php echo "Combo ".($i+1).": ".$_SESSION['addons'][$i]['meal_name']; ?></p>
				  <div class="comboprice"><?php echo "$".$_SESSION['addons'][$i]['meal_price']; ?></div>
				  <div class="quantitycontainer">
					<a href="<?php echo "addon.php?itemid=".$i."&itemaction=0";?>" class="decrement">
						<span class="selector"> - </span>
					</a>
					<div class="quantity">
						<input type="text" inputmode="numeric" onfocus="this.blur()" class="foodQuantity" value="<?php echo $_SESSION['addons'][$i]['meal_quantity'];?>">
					</div>
					<a href="<?php echo "addon.php?itemid=".$i."&itemaction=1";?>" class="decrement">
						<span class="selector"> + </span>
					</a>
				  </div>
				</div>
			<?php } ?>
            </div>
        </div>
		<a class="next" href="confirmation.php">
			<span>Proceed</span>
		</a>
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