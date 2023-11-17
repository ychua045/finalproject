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

$query = "select * from movieinfo where movie_id = ".$_GET['movieid'];
$result = $db->query($query);
$num_row = $result->num_rows;
for ($i=0; $i <$num_row; $i++) {
	$moviedetail = $result->fetch_assoc();
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
		$query = "select * from showinfo where movie_id = ".$moviedetail['movie_id']." and cinema_id = ".$cinemaid." and show_date = '".$alldates[$k]."' order by show_time";
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
	<link rel="stylesheet" href="css/movie.css">
	<!-- fonts/icons -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter&family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
	<style>
		.moviedetails::before {
		content: "";
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-image: url("image/<?php echo $moviedetail['splash_poster']; ?>");
		background-repeat: no-repeat;
		background-size: cover; /* Set background-size to cover */
		background-position: top;
		background-attachment: fixed; /* Fix the background in place */
		opacity: 0.2;
		z-index: -1;
	}
	</style>
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
	
	<div class="moviedetails">
	  <div class="div">
	    <div class="moviename"><?php echo $moviedetail["movie_name"];?></div>
		<div class="div-2">
			<div><img src="<?php echo 'image/'.$moviedetail["poster"];?>" /></div>
			<div class="div-3">
				<div class="movielabels"><div>Cast:</div> <div class="desc"><?php echo $moviedetail["casts"];?></div></div>
				<div class="movielabels"><div>Director:</div> <div class="desc"><?php echo $moviedetail["directors"];?></div></div>
				<div class="movielabels"><div>Genre:</div> <div class="desc"><?php echo $moviedetail["genre"];?></div></div>
				<div class="movielabels"><div>Release:</div> <div class="desc"><?php echo $moviedetail["release_date"];?></div></div>
				<div class="movielabels"><div>Rating:</div> <div class="desc"><?php echo $moviedetail["rating"];?> / 10.0</div></div>
				<div class="movielabels"><div>Runtime:</div> <div class="desc"><?php echo $moviedetail["runtime"]." minutes";?></div></div>
				<div class="movielabels"><div>Synopsis:</div> <div class="desc"><?php echo $moviedetail["synopsis"];?></div></div>
			</div>
	    </div>
	  </div>
	</div>

	<div id="showtimes">
		<h2 id="labelhead"> Showtimes </h2>
		<?php for($i=0; $i<count($allshows); $i++) {?>
			<table class="showtime">
				<tr> <th class="showtime" colspan="5"><?php echo $cinemas[$allshows[$i][0][0]['cinema_id'] - 1];?></th> </tr>
				<?php for($j=0; $j<count($allshows[$i]); $j++) { ?>
					<tr>
						<td class="date"> <?php echo $allshows[$i][$j][0]['show_date'];?> </td>
						<?php for($k=0; $k<count($allshows[$i][$j]); $k++) { ?>
							<td>    
								<a href="<?php echo 'seatselection.php?show_id='.$allshows[$i][$j][$k]['show_id'];?>">
									<button class="chip">
										<span class="selector"><?php echo $allshows[$i][$j][$k]['show_time'];?> </span>
									</button>
								</a>
							</td>
					<?php } ?>
					</tr>
				<?php } ?>
			</table>
		<?php } ?>
	</div>

    <div id="reviews">
		<h2 id="labelhead"> Reviews </h2>
			<div class="div">
        		<div class="div-2">
          			<img class="mask-group" src="image/guy1.png" />
          			<div class="div-3">
            			<div class="datewrap">18 August 2023</div>
            			<div class="namewrap">Jason Chen</div>
            			<div class="commentwrap">Really bad movie!</div>
          			</div>
        		</div>
        		<div class="div-2">
          			<img class="mask-group" src="image/girl1.png" />
      				<div class="div-3">
            			<div class="datewrap">18 August 2023</div>
            			<div class="namewrap">Annie Hong</div>
            			<p class="commentwrap">I don’t really like this but I guess it’s okay...</p>
          			</div>
        		</div>
        		<div class="div-2">
          			<img class="mask-group" src="image/guy2.png" />
          			<div class="div-3">
           				<div class="datewrap">18 August 2023</div>
            			<div class="namewrap">Chen Ming Ming</div>
            			<p class="commentwrap">I think it’s good you all are lying!</p>
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