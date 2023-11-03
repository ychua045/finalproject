<!--
-->
<?php 
session_start();
include "connectdb.php";

if (!isset($_GET['movieid'])) {?>
	<script> 
	alert("You have not selected a movie. Redirecting to home page."); 
	window.location.href="index.php";
	</script>
	<?php
}

if (isset($_SESSION['member_id'])) $memberid = $_SESSION['member_id'];
$_SESSION = [];
if (isset($memberid)) $_SESSION['member_id'] = $memberid;

$query = "select * from movieinfo where movie_id = ".$_GET['movieid'];
$result = $db->query($query);
$num_row = $result->num_rows;
for ($i=0; $i <$num_row; $i++) {
	$_SESSION['moviedetail'] = $result->fetch_assoc();
}

$cinemas = array();
$query = "select cinema_name from cinemainfo";
$result = $db->query($query);
$num_cinemas = $result->num_rows;
for ($i=0; $i <$num_cinemas; $i++) {
	$cinemas[] = $result->fetch_assoc()['cinema_name'];
}

$cur_date = date("Y-m-d");
//$cur_time = date("H:i");
$alldates = array();
for ($k=0; $k <= 5; $k++) {
	$alldates[] = date('Y-m-d', strtotime($cur_date. ' + '.$k.' days'));
}

$allshows = array();
for ($i=0; $i <$num_cinemas; $i++) {
	$showincinema = array();
	$cinemaid = $i + 1;
	for ($k=0; $k<=5; $k++) {
		$tmp = array();
		$query = "select * from showinfo where movie_id = ".$_SESSION['moviedetail']['movie_id']." and cinema_id = ".$cinemaid." and show_date = '".$alldates[$k]."' order by show_time";
		$result = $db->query($query);
		$num_row = $result->num_rows;
		for ($j=0; $j <$num_row; $j++) {
			$tmp[] = $result->fetch_assoc();
		}
		if ($num_row == 0) continue;
		$showincinema[] = $tmp;
	}
	if (count($showincinema) == 0) continue;
	$allshows[] = $showincinema;
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
	
	<img src="<?php echo 'image/'.$_SESSION['moviedetail']["poster"];?>"> <br>
    <div> <?php echo $_SESSION['moviedetail']["movie_name"];?> </div>
	<table> 
	<tr><td> Cast: <?php echo $_SESSION['moviedetail']["casts"];?> </td></tr>
	<tr><td> Director(s): <?php echo $_SESSION['moviedetail']["directors"];?> </td></tr>
	<tr><td> Genre: <?php echo $_SESSION['moviedetail']["genre"];?> </td></tr>
	<tr><td> Rating: <?php echo $_SESSION['moviedetail']["rating"];?>/10.0 </td></tr>
	<tr><td> Runtime: <?php echo $_SESSION['moviedetail']["runtime"];?> </td></tr>
	<tr><td> Synopsis: <?php echo $_SESSION['moviedetail']["synopsis"];?> </td></tr>
	</table>
	
	<table>
	<?php for($i=0; $i<count($allshows); $i++) {?>
		<tr><td> <?php echo $cinemas[$allshows[$i][0][0]['cinema_id'] - 1];?> </td></tr>
		<?php for($j=0; $j<count($allshows[$i]); $j++) { ?>
			<tr> <td> <?php echo $allshows[$i][$j][0]['show_date'];?> </td>
			<?php for($k=0; $k<count($allshows[$i][$j]); $k++) { ?>
				<td> <a href="<?php echo 'seatselection.php?showid='.$allshows[$i][$j][$k]['show_id'];?>">
				<?php echo $allshows[$i][$j][$k]['show_time'];?> 
				</a></td>
			<?php } ?>
			</tr>
		<?php } 
	} ?>
	</table>

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