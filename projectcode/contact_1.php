<!--
-->
<?php 
session_start();
include "connectdb.php";

?>
<!-- index.html -->
<html lang="en">
<head>
	<title> CHUAN'GU Cinematics - Book Your Tickets</title>
	<meta charset = "utf-8">
	<link rel="stylesheet" href="css/contact.css">
	<!-- fonts/icons -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter&family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">

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
		            <li><a href="index.php#movies">Movies</a></li>
		            <li><a href="member.php">Account</a></li>
		            <li><a href="contact.php" style="color: #FFFFFF;">Contact Us</a></li>		            		           
		          </ul>      
		        </div>
	        </div>
	    </div>
	</div>
	
	<div id="contact">
      <div class="labelHeader">Contact Us</div>
      <p class="contactDesc">
        Have any inquiries? Feel free to reach out to us! We’d love to provide you with the assistance you need.
      </p>
      <div class="contactcontainer">
        <div class="contactInfo">
          <div class="contactItems">
            <div class="contactLabel">Visit&nbsp;us:</div>
            <p class="contactContent">123&nbsp;Orchard Road,&nbsp;Singapore&nbsp;12345</p>
          </div>
          <div class="contactItems">
            <div class="contactLabel">Operating&nbsp;hours:</div>
            <p class="contactContent">Monday&nbsp;to&nbsp;Sunday,&nbsp;0900&nbsp;-&nbsp;1930</p>
          </div>
          <div class="contactItems">
            <div class="contactLabel">Contact&nbsp;number:</div>
            <div class="contactContent">6123&nbsp;4567</div>
          </div>
          <div class="contactItems">
            <div class="contactLabel">Email:</div>
            <div class="contactContent">chuangu@gmail.com</div>
          </div>
          <div class="contactItems">
          	<div class="socialsContact">
	    		<a href="https://instagram.com" target="_blank"><img src="image/insta.png" title="insta"></a>
	    		<a href="https://facebook.com" target="_blank"><img src="image/fb.png" title="fb"></a> 
	    	</div>         	
          </div>
        </div>

        <div class="contactForm">
			<form id="contactForm" action="#"> 
				<div class="contactFormField">
					<div class="contactFormIndiv">
						<input type="text" class="form-control" id="contactName" placeholder="Enter your name" required>	
					</div>

					<div class="contactFormIndiv">
						<input type="text" class="form-control" id="contactPhone" placeholder="Enter your phone number" required>	
					</div>

					<div class="contactFormIndiv">
						<input type="email" class="form-control" id="contactEmail" placeholder="Enter your email" required>
					</div>

					<div class="contactFormIndiv">
							<textarea id="contactComment" rows="4" cols="50" placeholder="Write your inquiries here" required></textarea>
					</div>
				</div>
				<div class="div-5">
					<a href ="#" style="text-decoration: none;">
						<button type="reset" class="reset" id="reset">Clear</button>
					</a>

					<a href ="#" style="text-decoration: none;">
						<button type="submit" class="submit" id="submit">Register</button>
					</a>				
				</div>
      		</form>
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
			  	<div class="footerdesc">chuangu@gmail.com</div>
				<div class="socials">
					<a href="https://instagram.com" target="_blank"><img src="image/insta.png" title="insta"  width="30px" height="30px"></a>
					<a href="https://facebook.com" target="_blank"><img src="image/fb.png" title="fb"  width="30px" height="30px"></a>
				</div>
	        </div>
	      </div>
	      <hr>
	      <p class="copyright">&copy Copyright 2023 ChuaN’Gu Cinematics</p>
	    </div>
    </footer>


</body>
</html>