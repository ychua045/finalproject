<!--
-->
<?php 
session_start();
include "connectdb.php";

// Clear all _session except member id.  
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

if (isset($_SESSION['member_id'])) $memberid = $_SESSION['member_id'];
$_SESSION = [];
if (isset($memberid)) $_SESSION['member_id'] = $memberid;

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
	
	$card_valid = 1;
	$query = "select * from cardlist where card_number = '".$tmpinfo['member_card']."'";
	$result = $db->query($query);
	$num_row = $result->num_rows;
	if ($num_row == 0) {
		$card_valid = 0;
	}
	
	if (!$email_unique) { 
		$tmpinfo['member_email'] = $curinfo['member_email'];
		?>
		<script> 
		alert("The email is already used by another account. Please enter an unused email. "); 
		</script>
	<?php }
	
	if (!$card_valid) { 
		$tmpinfo['member_card'] = $curinfo['member_card'];
		?>
		<script> 
		alert("The card is not valid for payment. "); 
		</script>
	<?php }
	
	$curinfo = $tmpinfo;
	
	if ($card_valid && $email_unique) {
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
		}
		else {
			$query = "INSERT INTO memberlist (member_name, member_password, member_email, member_hp, member_card) VALUES 
						('".$tmpinfo['member_name']."', '".$tmpinfo['member_password']."', '".$tmpinfo['member_email']."', 
						 '".$tmpinfo['member_hp']."', '".$tmpinfo['member_card']."')";
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
	
	<form id="RegisterForm" method="post" action="memberinfo.php">	
		<div>
		  <label for="memName"> Username:</label>
		  <input type="text" name="memName" id="memName" required value = "<?php echo $curinfo['member_name']; ?>" onchange="chkName()">
	    </div>
	    <p id="nameError" class="errormsg"></p>
		
		<div>
		  <label for="memEmail"> E-mail:</label>
		  <input type="text" name="memEmail" id="memEmail" required value = "<?php echo $curinfo['member_email']; ?>" onchange="chkEmail()">
	    </div>
	    <p id="emailError" class="errormsg"></p>
		
		<div>
		  <label for="memHp"> Phone (+65):</label>
		  <input type="text" name="memHp" id="memHp" required value = "<?php echo $curinfo['member_hp']; ?>" onchange="chkHp()">
	    </div>
	    <p id="hpError" class="errormsg"></p>
		
		<div>
		  <label for="memCard"> Payment Card No.:</label>
		  <input type="text" name="memCard" id="memCard" required value = "<?php echo $curinfo['member_card']; ?>" onchange="chkCard()">
	    </div>
	    <p id="cardError" class="errormsg"></p>
		
		<div>
		  <label for="memPassword"> Password: </label>
		  <input type="password" name="memPassword" id="memPassword" required value = "<?php echo $curinfo['member_password']; ?>" onchange="chkPassword()">
	    </div>
	    <p id="passwordError" class="errormsg"></p>
		
		<div>
		  <label for="confirmPassword"> Confirm Password: </label>
		  <input type="password" name="confirmPassword" id="confirmPassword" required value = "<?php echo $curinfo['member_password']; ?>" onchange="chkConfirmPassword()">
	    </div>
	    <p id="confirmpasswordError" class="errormsg"></p>
		
		<button type="button" onclick="window.location.href='member.php'">Cancel</button>
		<button type="button" onclick="registerSubmit()">Confirm</button>
	</form>
	

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