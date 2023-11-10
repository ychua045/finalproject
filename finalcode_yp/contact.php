<!--
-->
<?php 
session_start();
include "connectdb.php";

if (isset($_POST['contactName'])) {
	$to = 'comments@localhost'; 
	$subject = 'Customer Feedback ['.$_POST['contactName'].']'; 
	$message = "Customer comment received: \n\nUsername: ".$_POST['contactName']."\nEmail: ".$_POST['contactEmail']."\nPhone: ".$_POST['contactPhone']."\nComment: \n".$_POST['contactComment']; 
	$headers = 'From: chuangu@localhost' . "\r\n" . 'Reply-To: chuangu@localhost' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
	mail($to, $subject, $message, $headers, '-fchuangu@localhost');
	?>
	<script> 
	alert("Your feedback is sent to us successfully. We will proceed your request and get back to you as soon as possible. "); 
	window.location.href="contact.php";
	</script>
	<?php
	exit();
}

$curinfo = array();
$curinfo['member_name'] = "";
$curinfo['member_email'] = "";
$curinfo['member_hp'] = "";

if (isset($_SESSION['member_id'])) {
	$query = "select * from memberlist where member_id = ".$_SESSION['member_id'];
	$result = $db->query($query);
	$num_row = $result->num_rows;
	if ($num_row != 0) {
		$curinfo = $result->fetch_assoc();
	}
}


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
            <div class="contactContent">chuangu@localhost</div>
          </div>
          <div class="contactItems">
          	<div class="socialsContact">
							<img src="image/insta.png" title="insta">
							<img src="image/fb.png" title="fb">
	    			</div>         	
          </div>
        </div>

        <div class="contactForm">
			<form id="commentForm" method="post" action="contact.php"> 
				<div class="contactFormField">
					<div class="contactFormIndiv">
						<input type="text" class="form-control" name="contactName" id="contactName" placeholder="Enter your name" required value = "<?php echo $curinfo['member_name']; ?>" onchange="chkContactName()">		
						<p id="nameError" class="errormsgContact"></p>	
					</div>
					
					<div class="contactFormIndiv">
						<input type="text" class="form-control" name="contactPhone" id="contactPhone" placeholder="Enter your phone number" required value = "<?php echo $curinfo['member_hp']; ?>" onchange="chkContactHp()">		
						<p id="hpError" class="errormsgContact"></p>
					</div>

					<div class="contactFormIndiv">
						<input type="text" class="form-control" name="contactEmail" id="contactEmail" placeholder="Enter your email" required value = "<?php echo $curinfo['member_email']; ?>" onchange="chkContactEmail()">		
						<p id="emailError" class="errormsgContact"></p>
					</div>

					<div class="contactFormIndiv">
						<textarea name="contactComment" id="contactComment" rows="4" cols="50" placeholder="Write your inquiries here" required onchange="chkContactComment()"></textarea>
						<p id="commentError" class="errormsgContact"></p>
					</div>
				</div>
				<div class="div-5">
					<button type="reset" class="reset" id="reset">Clear</button>
					<button type="button" class="submitbutton" id="submitbutton" onclick="commentSubmit()">Submit</button>				
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