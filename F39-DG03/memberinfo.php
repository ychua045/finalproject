<!--
-->
<?php 
session_start();
include "connectdb.php";

// $curinfo all "" at first. 
// If member_id is set and exists in the database, update $curinfo for member email, name, hp, password, card. 

// If _Post[...], $tmpinfo = $curinfo. change $tmpinfo with post. 
// If email not unique. Alert and change $tmpinfo['member_email'] back to $curinfo['member_email']. 
// If card not valid. Alert and change $tmpinfo['member_card'] back to $curinfo['member_card']. 
// $curinfo = $tmpinfo. 
// If everything correct, update the dataset(insert or update). Set the _session[member_id]. Alert that it's successful. Jump to member.php.

// Show the form to input info. 
// Prefill with $curinfo. 
// Js check password length and struct, password consistency, email format, phone format, card format, name format. If not valid, prevent submit (with alert). 
// submit and cancel. cancel: jump to member.php

$curinfo = array();
$curinfo['member_name'] = "";
$curinfo['member_password'] = "";
$curinfo['member_email'] = "";
$curinfo['member_hp'] = "";
$curinfo['member_card'] = "";

if (isset($_SESSION['member_id'])) {
	$query = "select * from memberlist where member_id = ".$_SESSION['member_id'];
	$result = $db->query($query);
	$num_row = $result->num_rows;
	if ($num_row == 0) {
		unset($_SESSION['member_id']); ?>
		<script>
		window.location.href="member.php";
		</script>
		<?php
		exit();
	}
	$curinfo = $result->fetch_assoc();
}

if (isset($_POST['memEmail'])) {
	$tmpinfo = $curinfo;
	$tmpinfo['member_name'] = $_POST['memName'];
	$tmpinfo['member_password'] = $_POST['memPassword'];
	$tmpinfo['member_email'] = $_POST['memEmail'];
	$tmpinfo['member_hp'] = $_POST['memHp'];
	$tmpinfo['member_card'] = $_POST['memCard'];
	
	$email_unique = 1;
	$query = "select * from memberlist where member_email = '".$tmpinfo['member_email']."'";
	$result = $db->query($query);
	$num_row = $result->num_rows;
	if ($num_row != 0) {
		if (isset($_SESSION['member_id'])) {
			if ($result->fetch_assoc()['member_id'] != $_SESSION['member_id']) {
				$email_unique = 0;
			}
		}
		else {
			$email_unique = 0;
		}
	}
	/*
	$card_valid = 1;
	$query = "select * from cardlist where card_number = '".$tmpinfo['member_card']."'";
	$result = $db->query($query);
	$num_row = $result->num_rows;
	if ($num_row == 0) {
		$card_valid = 0;
	}
	*/
	if (!$email_unique) { 
		$tmpinfo['member_email'] = $curinfo['member_email'];
		?>
		<script> 
		alert("The email is already used by another account. Please enter an unused email. "); 
		</script>
	<?php }
	/*
	if (!$card_valid) { 
		$tmpinfo['member_card'] = $curinfo['member_card'];
		?>
		<script> 
		alert("The card is not valid for payment. "); 
		</script>
	<?php }
	*/
	$curinfo = $tmpinfo;
	
	//if ($card_valid && $email_unique) {
	if ($email_unique) {
		if (isset($_SESSION['member_id'])) {
			$query = "UPDATE memberlist SET member_name = '".$tmpinfo['member_name']."', member_password = '".$tmpinfo['member_password']."', 
						member_email = '".$tmpinfo['member_email']."', member_hp = '".$tmpinfo['member_hp']."', member_card = '".$tmpinfo['member_card']."' 
					  WHERE member_id = ".$_SESSION['member_id'];
			$db->query($query);
			?>
			<script> 
			alert("Your change of particulars was successful. "); 
			window.location.href="member.php";
			</script>
			<?php 
			exit();
		}
		else {
			$cur_date = date("Y-m-d");
			$query = "INSERT INTO memberlist (member_name, member_password, member_email, member_hp, member_card, register_date) VALUES 
						('".$tmpinfo['member_name']."', '".$tmpinfo['member_password']."', '".$tmpinfo['member_email']."', 
						 '".$tmpinfo['member_hp']."', '".$tmpinfo['member_card']."', '".$cur_date."')";
			$db->query($query);
			$query = "select * from memberlist where member_email = '".$tmpinfo['member_email']."'";
			$result = $db->query($query);
			$_SESSION['member_id'] = $result->fetch_assoc()['member_id'];
			?>
			<script> 
			alert("Your registration was successful. "); 
			window.location.href="member.php";
			</script>
			<?php 
			exit();
		}	
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
		            <li><a href="member.php">Account</a></li>
		            <li><a href="contact.php">Contact Us</a></li>		            		           
		          </ul>      
		        </div>
	        </div>
	    </div>
	</div>
	
	<div id="login">
		<form id="RegisterForm" method="post" action="memberinfo.php">
	  		<div class="div" style="gap:10px">
				<?php if (! isset($_SESSION['member_id'])) { ?>
					<div class="loginlabel">Registration</div>
					<p class="regdesc"> Join us as a member today! </p>
				<?php }
				else { ?>
					<div class="loginlabel">Change Particulars</div>
					<p class="regdesc"> You can change your particulars here.  </p>
	        	<?php }?>
	        	<div class="div-2">
	          		<div class="div-wrapper">
						<input type="text" class="form-control" name="memName" id="memName" placeholder="Enter your name" required value = "<?php echo $curinfo['member_name']; ?>" onchange="chkName()">		
						<p id="nameError" class="errormsg"></p>
					</div>
					
	          		<div class="div-wrapper">
						<input type="text" class="form-control" name="memHp" id="memHp" placeholder="Enter your phone number" required value = "<?php echo $curinfo['member_hp']; ?>" onchange="chkHp()">		
						<p id="hpError" class="errormsg"></p>
				    </div>		
					
	          		<div class="div-wrapper">
						<input type="text" class="form-control" name="memEmail" id="memEmail" placeholder="Enter your email" required value = "<?php echo $curinfo['member_email']; ?>" onchange="chkEmail()">		
						<p id="emailError" class="errormsg"></p>
					</div>
					
	          		<div class="div-wrapper">
						<input type="text" class="form-control" name="memCard" id="memCard" placeholder="1234123412341234" required value = "<?php echo $curinfo['member_card']; ?>" onchange="chkCard()">		
						<p id="cardError" class="errormsg"></p>
					</div>
					
	          		<div class="div-wrapper">
						<input type="password" class="form-control" name="memPassword" id="memPassword" placeholder="Enter your password" required value = "<?php echo $curinfo['member_password']; ?>" onchange="chkPassword(1)">		
						<p id="passwordError" class="errormsg"></p>
					</div>
					
					<div class="div-wrapper">
						<input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm your password" required value = "<?php echo $curinfo['member_password']; ?>" onchange="chkConfirmPassword()">		
						<p id="confirmpasswordError" class="errormsg"></p>
					</div>
	        	</div>
	      	</div>
	      	<div class="div-5">
	      		<button type="button" class="cancelbutton" id="cancelbutton" onclick="window.location.href='member.php'">Cancel</button>
	      		<button type="button" class="submitbutton" id="submitbutton" onclick="registerSubmit()">Confirm</button>				
	      	</div>
      </form>    
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