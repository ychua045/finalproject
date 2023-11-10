<!--
-->
<?php 
session_start();
include "connectdb.php";

// If _get['logout'], unset _session member id and refresh page. 
// If _post['memEmail']. Check if member exists. Check password. If correct: set _session['member_id']. Otherwise, alert. (two types). 
// if logged in. Show links to logout, and change particulars page. 
// Not logged in. Show the link to register.php. Show the form to enter email and password. JS check format and length until correct. 

if (isset($_GET['logout'])) {
	if (isset($_SESSION['member_id'])) {
		$query = "delete from tmpseats where member_id = ".$_SESSION['member_id'];
		$db->query($query);
	}
	$_SESSION = [];
	?>
	<script> 
	alert("You have been logged out."); 
	window.location.href="member.php";
	</script>
	<?php 
	exit();
}

if (isset($_POST['memEmail'])) {
	$query = "select * from memberlist where member_email = '".$_POST['memEmail']."'";
	$result = $db->query($query);
	$num_row = $result->num_rows;
	if ($num_row == 0) {?>
		<script> 
		alert("Sorry, your account does not exist. "); 
		window.location.href="member.php";
		</script>
		<?php 
		exit();
	}
	for ($i=0; $i <$num_row; $i++) {
		$memberdetails = $result->fetch_assoc();
	}
	if ($memberdetails['member_password'] != $_POST['memPassword']) { ?> 
		<script> 
		alert("Sorry, your password is incorrect. "); 
		window.location.href="member.php";
		</script>
		<?php 
		exit();
	}
	$_SESSION['member_id'] = $memberdetails['member_id'];
}
if (isset($_SESSION['member_id'])) {
	$query = "select * from memberlist where member_id = ".$_SESSION['member_id'];
	$result = $db->query($query);
	$num_row = $result->num_rows;
	$member_details = $result->fetch_assoc();
	
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
		$tmp_total = 0;
		$orders[$i]['addons'] = array();
		$query = "select * from orderaddon where order_id = ".$orders[$i]['order_id'];
		$result = $db->query($query);
		$num_row = $result->num_rows;
		for ($j=0; $j <$num_row; $j++) {
			$orders[$i]['addons'][] = $result->fetch_assoc();
			$orders[$i]['addons'][$j]['subtotal'] = $orders[$i]['addons'][$j]['meal_price'] * $orders[$i]['addons'][$j]['meal_quantity'];
			$tmp_total += $orders[$i]['addons'][$j]['subtotal'];
		}
		$orders[$i]['seat_subtotal'] = $orders[$i]['num_tickets'] * $orders[$i]['ticket_price'];
		$tmp_total += $orders[$i]['seat_subtotal'];
		$orders[$i]['order_subtotal'] = $tmp_total;
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
	<link rel="stylesheet" href="css/confirmation.css">
	<!-- fonts/icons -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter&family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
	<script type="text/javascript" src="formvalidation.js"></script>
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
		            <li><a href="index.php#movies">Movies</a></li>
		            <li><a href="member.php" style="color: #FFFFFF;">Account</a></li>
		            <li><a href="contact.php">Contact Us</a></li>		            		           
		          </ul>      
		        </div>
	        </div>
	    </div>
	</div>

	<?php if (isset($_SESSION['member_id'])) { ?>
		<div id="account">
    	<div class="profile">
			<img class="mask-group" src="image/kuromi.png" />
			<div class="profDetails">
				<span class="memberName" id="memberName"> <?php echo $member_details['member_name']; ?></span>
				<span class="memberJoinDate" id="memberJoinDate"> <?php echo "Member since ".substr($member_details['register_date'], 0, 4); ?> </span>	
				<a href="memberinfo.php" id="changeParticulars" class="changeParticulars"> Change Particulars</a>		
			</div>
			<a class="logout" id="logout" href="member.php?logout=1">
				<span>Log Out</span>
			</a>  			
    	</div>

		<div class="pageOrder">
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

			<div class="orderSummary">
		      <div class="labelHeader">My Bookings</div>
			  <?php for($i=0; $i<$num_orders; $i++) { ?>
				<table class="summary">
					<tr>
						<th class="left" colspan="2">
							<span class="bookingID" id="bookingDate" style="color:#fff"> <?php echo $orders[$i]['order_dt']; ?> </span>
						</th>

						<th class="right" colspan="2">
							<span class="bookingID" id="bookingID" style="color:#fff"> <?php echo "Booking ID: ".sprintf("%09d", $orders[$i]['order_id']); ?> </span>
						</th>	
					</tr>

					<tr>
						<td class="movietitle" colspan="4">
							<span> <?php echo $orders[$i]['moviedetail']['movie_name']; ?> </span>
						</td>
					</tr>					

					<tr class="orderItems">
						<td class="orderInfo" colspan="4">
					      <div class="div-4">
					        <img src="image/<?php echo $orders[$i]['moviedetail']['poster']; ?>"/>
					        <div class="div-5">
					          <div class="div-6">
					            <div class="movielabels" style="color:#B15EFF">Showing on:</div>
					            <div class="desc" style="color:#FFF"><?php echo $orders[$i]['showdetail']['show_date']; ?></div>
					            <div class="desc" style="color:#FFF"><?php echo $orders[$i]['showdetail']['show_time']; ?></div>
					            <div class="desc" style="color:#FFF"><?php echo $cinemas[$orders[$i]['showdetail']['cinema_id'] - 1]." Theatre"; ?></div>
								<div class="desc" style="color:#FFF"><?php echo "Hall ".$orders[$i]['showdetail']['hall_id']; ?></div>
					          </div>
					          <div class="div-6">
					            <div class="movielabels"style="color:#B15EFF">Number of tickets:</div>
					            <div class="desc"style="color:#FFF"><?php echo $orders[$i]['num_tickets']; ?></div>
								<?php for ($j=0; $j<$orders[$i]['num_tickets']; $j++) { ?>
									<div class="desc"style="color:#FFF">
									<?php echo "Row ".$orders[$i]['seats'][$j]['seat_row']." Seat ".$orders[$i]['seats'][$j]['seat_col']; ?>
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
							<span class="orderBody"> <?php echo "$".$orders[$i]['ticket_price']; ?> </span>
						</td>

						<td class="mid">
							<span class="orderBody"> <?php echo $orders[$i]['num_tickets']; ?> </span>
						</td>

						<td class="right">
							<span class="orderBody"> <?php echo "$".$orders[$i]['seat_subtotal']; ?> </span>
						</td>
					</tr>
					
					<?php for ($j=0; $j<count($orders[$i]['addons']); $j++) { ?>
						<tr>
							<td class="left">
								<span class="orderBody"> <?php echo $orders[$i]['addons'][$j]['meal_name']; ?> </span>
							</td>

							<td class="mid">
								<span class="orderBody"> <?php echo "$".$orders[$i]['addons'][$j]['meal_price']; ?> </span>
							</td>

							<td class="mid">
								<span class="orderBody"> <?php echo $orders[$i]['addons'][$j]['meal_quantity']; ?> </span>
							</td>

							<td class="right">
								<span class="orderBody"> <?php echo "$".$orders[$i]['addons'][$j]['subtotal']; ?> </span>
							</td>
						</tr>
					<?php } ?>

					<tr class="orderItems">
						<td class="left" colspan="2">
							<span class="orderHeader" style="color:#fff"> TOTAL COST </span>
						</td>

						<td class="right" colspan="2">
							<span class="totalPrice"> <?php echo "$".$orders[$i]['order_subtotal']; ?> </span>
						</td>					
					</tr>
				</table>
			  <?php } ?>
			</div>
	    </div>  
			
    </div>
		
		
		
		
		
	<?php } else { ?>
		<div id="login">
			<form id="LoginForm" method="post" action="member.php"> 
				<div class="div">
					<div class="loginlabel">LOGIN</div>
					<div class="div-2">
						<div class="div-wrapper">
							<input type="email" class="form-control" name="memEmail" id="memEmail" placeholder="Enter your email" required onchange="chkEmail()">		
							<p id="emailError" class="errormsg"></p>
						</div>
						
						<div class="div-wrapper">
							<input type="password" class="form-control" name="memPassword" id="memPassword" placeholder="Enter your password" required onchange="chkPassword(0)">		
							<p id="passwordError" class="errormsg"></p>
						</div>
						
					</div>
				</div>
				
				<div class="div-3">
					<button type="button" class="submitbutton" id="submitbutton" onclick="loginSubmit()">Sign In</button>
				</div>
		  </form>
				<div class="div-4">
					<a class="smalllabel" href ="memberinfo.php">Create account here
					</a>
				</div>     
		</div>
	<?php } ?>


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