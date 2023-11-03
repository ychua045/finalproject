<!--
-->
<?php 
session_start();
include "connectdb.php";

// Clear all _session except member id.  
// $currentinfo all "" at first. 
// If member exists, update $currentinfo for member email, name, hp, password, card. 

// If _Post[...], update $currentinfo. 
// If email not unique. Alert and clear $currentinfo['email']. 
// If card not valid. Alert and clear $currentinfo['card']. 
// else, update the dataset(insert or update). Alert that it's successful. Set the _session[memberid]. Jump to member.php.

// Show the form to input info. 
// Prefill with $currentinfo. Email cannot change if it's update not register. 
// Js check password length and struct, password consistency, email format, phone format, card format, name format. If not valid, prevent submit (with alert). 
// submit and cancel. cancel jump to member.php
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