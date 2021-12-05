<?php include ("includes/includedFiles.php");

// if(isset($_SESSION['userLoggedIn'])) {
// 	$userLoggedIn = $_SESSION['userLoggedIn'];
// echo "<script>userLoggedIn = $userLoggedIn</script>";
// }
// else {
// 	header("Location: register.php");
// }
if(isset($_GET['id'])){
  $aristId = $_GET['id'];

}else{
  header("Location: index.php");
}

$artist = new Artist($con, $aristId);
?>

<div class="entitiInfo">
  <div class="centerSection">
    <div class="artistInfo">
      <h1 class="artistName"><?php echo $artist->getName(); ?></h1>
        <div class="headerButtons">
          <button class="button green">PLAY</button>

        </div>
      </div>
    </div>
  </div>
  <div class="tracklistContainer">
    <h2>SONGS</h2>
  	<ul class="tracklist">

  		<?php
  		$songIdArray = $artist->getSongIds();

  		$i = 1;
  		foreach($songIdArray as $songId) {

  			$albumSong = new Song($con, $songId);
  			$albumArtist = $albumSong->getArtist();

  			echo "<li class='tracklistRow'>
  					<div class='trackCount'>
  						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
  						<span class='trackNumber'>$i</span>
  					</div>


  					<div class='trackInfo'>
  						<span class='trackName'>" . $albumSong->getTitle() . "</span>
  						<span class='artistName'>" . $albumArtist->getName() . "</span>
  					</div>

  					<div class='trackOptions'>
  						<img class='optionsButton' src='assets/images/icons/more.png'>
  					</div>

  					<div class='trackDuration'>
  						<span class='duration'>" . $albumSong->getDuration() . "</span>
  					</div>


  				</li>";

  			$i = $i + 1;
  		}

  		?>
  		<script>
  			var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
  			tempPlaylist = JSON.parse(tempSongIds);
  		</script>


  	</ul>
  </div>

</div>
