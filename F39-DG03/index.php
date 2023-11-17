<!--

-->
<?php 
session_start();
include "connectdb.php";


$cur_date = date("Y-m-d");

$nowshow = array();
$query = "select movieinfo.* from movieinfo 
		 where exists (select 1 from showinfo where showinfo.movie_id = movieinfo.movie_id and showinfo.show_date >= '".$cur_date."') 
		 and (DATEDIFF((select min(showinfo.show_date) from showinfo where showinfo.movie_id = movieinfo.movie_id and showinfo.show_date >= '".$cur_date."'), '".$cur_date."') <= 5)";
$result = $db->query($query);
$num_row = $result->num_rows;
for ($i=0; $i <$num_row; $i++) {
	//echo $result->fetch_assoc()['movie_name'];
	$nowshow[] = $result->fetch_assoc();
}

$comesoon = array();
$query = "select movieinfo.* from movieinfo 
		 where exists (select 1 from showinfo where showinfo.movie_id = movieinfo.movie_id and showinfo.show_date >= '".$cur_date."') 
		 and (DATEDIFF((select min(showinfo.show_date) from showinfo where showinfo.movie_id = movieinfo.movie_id and showinfo.show_date >= '".$cur_date."'), '".$cur_date."') > 5)";
$result = $db->query($query);
$num_row = $result->num_rows;
for ($i=0; $i <$num_row; $i++) {
	//echo $result->fetch_assoc()['movie_name'];
	$comesoon[] = $result->fetch_assoc();
}

//select top 5 sales movies from "now show" with splash art poster avalaible. 
$topmovies = array();
$query = "select movieinfo.* from movieinfo 
		 where movieinfo.splash_poster is not null 
		 and exists (select 1 from showinfo where showinfo.movie_id = movieinfo.movie_id and showinfo.show_date >= '".$cur_date."') 
		 and (DATEDIFF((select min(showinfo.show_date) from showinfo where showinfo.movie_id = movieinfo.movie_id and showinfo.show_date >= '".$cur_date."'), '".$cur_date."') <= 5)
		 order by (select sum(orderlist.num_tickets) from showinfo, orderlist where showinfo.show_id = orderlist.show_id and showinfo.movie_id = movieinfo.movie_id) DESC limit 5";
$result = $db->query($query);
$num_row = $result->num_rows;
for ($i=0; $i <$num_row; $i++) {
	//echo $result->fetch_assoc()['movie_name'];
	$topmovies[] = $result->fetch_assoc();
}

//select top 4 movies from "now show" with the nearest release date. 
$latest = array();
$query = "select movieinfo.* from movieinfo 
		 where movieinfo.splash_poster is not null 
		 and exists (select 1 from showinfo where showinfo.movie_id = movieinfo.movie_id and showinfo.show_date >= '".$cur_date."') 
		 and (DATEDIFF((select min(showinfo.show_date) from showinfo where showinfo.movie_id = movieinfo.movie_id and showinfo.show_date >= '".$cur_date."'), '".$cur_date."') <= 5)
		 order by movieinfo.release_date DESC limit 4";
$result = $db->query($query);
$num_row = $result->num_rows;
for ($i=0; $i <$num_row; $i++) {
	//echo $result->fetch_assoc()['movie_name'];
	$latest[] = $result->fetch_assoc();
}
?>

<!-- index.html -->
<html lang="en">
<head>
	<title> CHUAN'GU Cinematics - Book Your Tickets</title>
	<meta charset = "utf-8">
	<link rel="stylesheet" href="css/style.css">
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
		            <img src="image/ie4717.png" title="4717" width= "100px" height= "80px">
		          </a>
		        </div>

		        <div id="top-right">
		          <ul class="nav-home">
		            <li><a href="index.php" style="color: #FFFFFF;">Home</a></li>
		            <li><a href="index.php#movies">Movies</a></li>
		            <li><a href="member.php">Account</a></li>
		            <li><a href="contact.php">Contact Us</a></li>		            		           
		          </ul>      
		        </div>
	        </div>
	    </div>
	</div>



	<div class="postercontainer">
		<?php for ($i=0; $i<count($topmovies); $i++) { ?>
			<div class="mySlides fade">
				<div class="numbertext"> <?php echo ($i + 1)." / ".count($topmovies); ?> </div>
				<a href="<?php echo 'moviedetails.php?movieid='.$topmovies[$i]["movie_id"];?>" >
				<img src="<?php echo "image/".$topmovies[$i]['splash_poster']; ?>" alt="Poster Image"/>
				</a>
			</div>
		<?php } ?>
		<a class="prev" onclick="plusSlides(-1)"> <img src="image/left.png"> </a>
		<a class="next" onclick="plusSlides(1)"> <img src="image/right.png"> </a>
	</div>

	<br>

	<div style="text-align:center">
		<?php for ($i=0; $i<count($topmovies); $i++) { ?>
			<span class="dot" onclick="currentSlide(<?php echo ($i + 1); ?>)"></span> 
		<?php } ?>
	</div>
	
	<div class="movies" id="movies">
		<table>
			<h2 id="labelhead"> Latest </h2>
			<tr id="listingrow">
				<?php for($i=0; $i<count($latest); $i++) { ?>
					<td id="listings" >
						<div class="poster-cont">
							<img src="<?php echo "image/".$latest[$i]['poster']; ?>" title="<?php echo $latest[$i]['movie_name']; ?>"> 
							<div class="middle">
								<div class="moviecontent">
								  <div class="framemovie">
									<div class="div">
									  <div class="movielab"> <?php echo $latest[$i]['movie_name']; ?> </div>
									  <div class="div-2">
										<div class="descriptions"><?php echo substr($latest[$i]['casts'], 0, 32)."..."; ?></div>
										<div class="descriptions"><?php echo $latest[$i]['genre']; ?></div>
										<div class="descriptions"><?php echo $latest[$i]['runtime']." minutes"; ?></div>
										<div class="descriptions"><?php echo $latest[$i]['rating']."/10.0"; ?></div>
									  </div>
									</div>
								  </div>
								</div>
							</div>
						</div> <br><br>

						<a href="<?php echo 'moviedetails.php?movieid='.$latest[$i]["movie_id"];?>" style="text-decoration: none; color: #FFF; font-size: 15px;">
							<span class="book-now-btn">Book now!</span>
						</a>
					</td>
					
				<?php } ?>
			</tr>
				
		</table>
	</div>
	
	<div class="movies" id="movies">
		<table>
			<h2 id="labelhead"> Now Showing </h2>
			<tr id="listingrow">
				<?php for($i=0; $i<count($nowshow); $i++) { ?>
					<td id="listings" >
						<div class="poster-cont">
							<img src="<?php echo "image/".$nowshow[$i]['poster']; ?>" title="<?php echo $nowshow[$i]['movie_name']; ?>"> 
							<div class="middle">
								<div class="moviecontent">
								  <div class="framemovie">
									<div class="div">
									  <div class="movielab"> <?php echo $nowshow[$i]['movie_name']; ?> </div>
									  <div class="div-2">
										<div class="descriptions"><?php echo substr($nowshow[$i]['casts'], 0, 32)."..."; ?></div>
										<div class="descriptions"><?php echo $nowshow[$i]['genre']; ?></div>
										<div class="descriptions"><?php echo $nowshow[$i]['runtime']." minutes"; ?></div>
										<div class="descriptions"><?php echo $nowshow[$i]['rating']."/10.0"; ?></div>
									  </div>
									</div>
								  </div>
								</div>
							</div>
						</div> <br><br>

						<a href="<?php echo 'moviedetails.php?movieid='.$nowshow[$i]["movie_id"];?>" style="text-decoration: none; color: #FFF; font-size: 15px;">
							<span class="book-now-btn">Book now!</span>
						</a>
					</td>
					
				<?php } ?>
			</tr>
				
		</table>
	</div>
	
	<div class="movies" id="movies">
		<table>
			<h2 id="labelhead"> Coming Soon </h2>
			<tr id="listingrow">
				<?php for($i=0; $i<count($comesoon); $i++) { ?>
					<td id="listings" >
						<div class="poster-cont">
							<img src="<?php echo "image/".$comesoon[$i]['poster']; ?>" title="<?php echo $comesoon[$i]['movie_name']; ?>"> 
							<div class="middle">
								<div class="moviecontent">
								  <div class="framemovie">
									<div class="div">
									  <div class="movielab"> <?php echo $comesoon[$i]['movie_name']; ?> </div>
									  <div class="div-2">
										<div class="descriptions"><?php echo $comesoon[$i]['casts']; ?></div>
										<div class="descriptions"><?php echo $comesoon[$i]['genre']; ?></div>
										<div class="descriptions"><?php echo $comesoon[$i]['runtime']." minutes"; ?></div>
										<div class="descriptions"><?php echo $comesoon[$i]['rating']."/10.0"; ?></div>
									  </div>
									</div>
								  </div>
								</div>
							</div>
						</div> <br><br>
					</td>
					
				<?php } ?>
			</tr>
				
		</table>
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
<script>
	let slideIndex = 1;
	showSlides(slideIndex);

	function plusSlides(n) {
	  showSlides(slideIndex += n);
	}

	function currentSlide(n) {
	  showSlides(slideIndex = n);
	}

	function showSlides(n) {
	  let i;
	  let slides = document.getElementsByClassName("mySlides");
	  let dots = document.getElementsByClassName("dot");
	  if (n > slides.length) {slideIndex = 1;}    
	  if (n < 1) {slideIndex = slides.length;}
	  for (i = 0; i < slides.length; i++) {
		slides[i].style.display = "none";  
	  }
	  for (i = 0; i < dots.length; i++) {
		dots[i].className = dots[i].className.replace(" active", "");
	  }
	  slides[slideIndex-1].style.display = "block";  
	  dots[slideIndex-1].className += " active";
	}
</script>
    
</body>
</html>