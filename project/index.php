<!--

-->
<?php 
session_start();
include "connectdb.php";

if (isset($_SESSION['member_id'])) $memberid = $_SESSION['member_id'];
$_SESSION = [];
if (isset($memberid)) $_SESSION['member_id'] = $memberid;

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

$row_len = 5;
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
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400&family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
	<script>
	const posters = [];
	<?php for ($i=0; $i<count($topmovies); $i++) {?>
		posters[<?php echo $i; ?>] = "image/<?php echo $topmovies[$i]['splash_poster']; ?>";
	<?php } ?>
	curpos = 0;
	totpos = posters.length;
	function nxtpos() {
		curpos ++;
		if (curpos >= totpos) curpos = 0;
		displayHTML = document.getElementById("splashart");
		displayHTML.innerHTML = '<div class="poster"> <img src="' + posters[curpos] +
			'" alt="Poster Image"> </div> <button name="prev" onclick="nxtpos()"> prev </button> <button name="next" onclick="prevpos()"> next </button>';
	}
	function prevpos() {
		curpos --;
		if (curpos < 0) curpos = totpos - 1;
		displayHTML = document.getElementById("splashart");
		displayHTML.innerHTML = '<div class="poster"> <img src="' + posters[curpos] +
			'" alt="Poster Image"> </div> <button name="prev" onclick="nxtpos()"> prev </button> <button name="next" onclick="prevpos()"> next </button>';
	}
	</script>
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
		            <li><a href="index.php" style="color: #FFFFFF;">Home</a></li>
		            <li><a href="movie.php">Movies</a></li>
		            <li><a href="member.php">Account</a></li>
		            <li><a href="contact.php">Contact Us</a></li>		            		            
		          </ul>      
		        </div>
	        </div>
	    </div>
	</div>
	
	<div id="splashart">
		<div class="poster">
			<img src="image/<?php echo $topmovies[0]['splash_poster']; ?>" alt="Poster Image">
		</div>
		<button name="prev" onclick="nxtpos()"> prev </button>
		<button name="next" onclick="prevpos()"> next </button>
    </div>
	
    <div class="movies">
    	<h2 id="labelhead"> Now Showing </h2>
    	<table class="listings">
		    <?php for($i=0; $i<ceil(count($nowshow)/$row_len); $i++) { ?>
				<tr class="listings">
				<?php for($j=0; $j<$row_len; $j++) { 
					$pos = $row_len * $i + $j;
					if ($pos >= count($nowshow)) continue; ?>
					<td class="listings">
						<img src="<?php echo 'image/'.$nowshow[$pos]["poster"];?>" title="<?php echo $nowshow[$pos]["movie_name"];?>"> <br><br>
						<a href="<?php echo 'moviedetails.php?movieid='.$nowshow[$pos]["movie_id"];?>" style="text-decoration: none; color: #FFF; gap: 0px; font-size: 15px;">
							<span class="book-now-btn">Book now!</span>
						</a>		
					</td>
				<?php } ?>
				</tr>
			<?php } ?>
    	</table>
		
		<h2 id="labelhead"> Coming soon </h2>
    	<table class="listings">
		    <?php for($i=0; $i<ceil(count($comesoon)/$row_len); $i++) { ?>
				<tr class="listings">
				<?php for($j=0; $j<$row_len; $j++) { 
					$pos = $row_len * $i + $j;
					if ($pos >= count($comesoon)) continue; ?>
					<td class="listings">
						<img src="<?php echo 'image/'.$comesoon[$pos]["poster"];?>" title="<?php echo $comesoon[$pos]["movie_name"];?>"> <br><br>
						<a href="<?php echo 'moviedetails.php?movieid='.$comesoon[$pos]["movie_id"];?>" style="text-decoration: none; color: #FFF; gap: 0px; font-size: 15px;">
							<span class="book-now-btn">Book now!</span>
						</a>		
					</td>
				<?php } ?>
				</tr>
			<?php } ?>
    	</table>
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