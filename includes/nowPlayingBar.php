<?php
$songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");

$resultArray = array();

while($row = mysqli_fetch_array($songQuery)) {
	array_push($resultArray, $row['id']);
}

$jsonArray = json_encode($resultArray);
?>

<script>

$(document).ready(function() {
	var newPlaylist = <?php echo $jsonArray; ?>;
	//console.log(currentPlaylist);
	audioElement = new Audio();
	setTrack(newPlaylist[0], newPlaylist, false);
	$(".playbackBar .progressBar").mousedown(function(){
		mouseDown = true; //mousedown ??
	});
	$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
		e.preventDefault();
	});
	$(".playbackBar .progressBar").mousemove(function(e){
		if(mouseDown == true){
			timeFromOffset(e, this);
		} //e??
	});
	// $(".playbackBar .progressBar").mouseup(function(e){
	// 	timeFromOffset(e, this);
	// });
	$(document).mouseup(function(){
		mouseDown = false;
	});
	$(".volumeBar .progressBar").mousedown(function(){
		mouseDown = true;
	});
	$(".volumeBar .progressBar").mousemove(function(e){
		if(mouseDown == true){
			var percentage = e.offsetX / $(this).width();
			if(percentage >= 0 && percentage <=1){
				audioElement.audio.volume = percentage;
			}
		}
	});
	$(".volumeBar .progressBar").mouseup(function(e){
		var percentage = e.offsetX / $(this).width();

		if(percentage >= 0 && percentage <= 1) {
			audioElement.audio.volume = percentage;
		}
	})
});

	function timeFromOffset(mouse, progressBar) {
		var percentage = mouse.offsetX / $(progressBar).width() * 100;
		var seconds = audioElement.audio.duration * (percentage / 100);
		audioElement.setTime(seconds);
	}
	//上一首歌的function
	function prevSong(){
		if(audioElement.audio.currentTime >= 3 || currentIndex == 0 ){
			audioElement.setTime(0);
		}
		else{
			currentIndex = currentIndex - 1 ;
			setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
		}
	}
	//下一首歌的function
	function nextSong(){
		if(repeat == true) {
			audioElement.setTime(0);
			playSong();
			return;
		}
  //按下下一首沒有反應？ 確認input是否有onclick nextSong()事件？有查詢bug原因？用console.log找function nextsong逐步測試是否可以output。console.log ok代表function nextSong判別是沒問題。查詢後事沒有var trackToPlay =  currentPlaylist[currentIndex]; setTrack(trackToPlay, currentPlaylist, true);新增後就搞定了
		if(currentIndex == currentPlaylist.length - 1) {
			currentIndex = 0;
		}
		else {
			currentIndex++;
			//console.log("HIHIHI");
		}
	//	var trackToPlay =  currentPlaylist[currentIndex];
	 	var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
	 	setTrack(trackToPlay, currentPlaylist, true);
	  }
	//播放音樂的function ajax從mysql取值
	//重複播放時切換圖片
	function setRepeat(){
		repeat =! repeat;
		var imageName = repeat ? "repeat-active.png" : "repeat.png"; //?
		$(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
	}
	function setMute(){
		audioElement.audio.muted = !audioElement.audio.muted;
		var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png"; //?
		$(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
	}
	function setShuffle(){
		//randomize playlist
		shuffleArray(shufflePlaylist);
		//shuffle = !shuffle;
		var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
		$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

		//console.log(currentPlaylist);
		//console.log(shufflePlaylist);

		if(shuffle == true){
		//randomzie the playlist
			shuffleArray(shufflePlaylist);
			currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);

		}
		else{
		//don't randomize the playlist
			currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
		}
	}
 //明明都寫到shffleArray2k7的函數，卻還是=>shuffleArray is not define=>檢查function能不能正常執行 或每一行console.log試試看
	function shuffleArray(a){
		var j, x, i;
		for (i = a.length; i; i--){
			j = Math.floor(Math.random() * i);
			x = a[i - 1];
			a[i -1] = a[j];
			a[j] = x;
		}
	}
	function setTrack(trackId, newPlaylist, play) {
		//shuffle功能
		if(newPlaylist != currentPlaylist){
			currentPlaylist = newPlaylist;
			shufflePlaylist = currentPlaylist.slice();
			shuffleArray(shufflePlaylist);
		}
		if(shuffle == true){
			currentIndex = shufflePlaylist.indexOf(trackId);
		}
		else{
			currentIndex = currentPlaylist.indexOf(trackId);
		}

		pauseSong();
		$.post("includes/handlers/ajax/getSongjson.php",{songId: trackId}, function(data){

			var track = JSON.parse(data);
			//console.log(track); //track的title有傳值到前端頁面
			$(".trackName span").text(track.title);
			$.post("includes/handlers/ajax/getArtistjson.php",{artistId: track.artist}, function(data){
			var artist = JSON.parse(data);
			//console.log(artist.name); //artist有傳值到前端頁面
			$(".artistName span").text(artist.name);
		});
		$.post("includes/handlers/ajax/getAlbumjson.php",{albumId: track.album}, function(data){
			var album = JSON.parse(data);
			console.log(track.album); //artist有傳值到前端頁面
			$(".albumLink img").attr("src", album.artworkPath); //pic img會將 src的屬性改為album db 的 artworkPath欄位
		});
		audioElement.setTrack(track);
		playSong();
		if(play == true) {
			//audioElement.muted = true;
			playSong();

			//DOMException: play() failed because the user didn't interact with the document first.
			//意思是，如果使用者和瀏覽器沒有互動的話，play() 會失敗；如果想要解決這個問題可以根據上面的方式，在 video 上加入 muted 的 tag，這樣 JavaScript 就可以成功執行 play() 方法。
		}
	});

	//audioElement.setTrack("assets/music/bensound-clearday.mp3");


}
//播放音樂時的function
function playSong() {

	//console.log(audioElement);
	if(audioElement.audio.currentTime ==0){
		$.post("includes/handlers/ajax/updatePlays.php",{ songId: audioElement.currentlyPlaying.id });
	}
	$(".controlButton.play").hide();
	$(".controlButton.pause").show();
	audioElement.play();
}
//暫停音樂時的function
function pauseSong() {
	$(".controlButton.play").show();
	$(".controlButton.pause").hide();
	audioElement.pause();
}
//https://i.ytimg.com/vi/rb8Y38eilRM/maxresdefault.jpg album
</script>


<div id="nowPlayingBarContainer">

	<div id="nowPlayingBar">

		<div id="nowPlayingLeft">
			<div class="content">
				<span class="albumLink">
					<img src="" class="albumArtwork">
				</span>

				<div class="trackInfo">

					<span class="trackName">
						<span></span>
					</span>

					<span class="artistName">
						<span></span>
					</span>

				</div>



			</div>
		</div>

		<div id="nowPlayingCenter">

			<div class="content playerControls">

				<div class="buttons">

					<button class="controlButton shuffle" title="Shuffle button" onclick="setShuffle()">
						<img src="assets/images/icons/shuffle.png" alt="Shuffle">
					</button>

					<button class="controlButton previous" title="Previous button" onclick="prevSong()">
						<img src="assets/images/icons/previous.png" alt="Previous">
					</button>

					<button class="controlButton play" title="Play button" onclick="playSong()">
						<img src="assets/images/icons/play.png" alt="Play">
					</button>

					<button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong()">
						<img src="assets/images/icons/pause.png" alt="Pause">
					</button>

					<button class="controlButton next" title="Next button" onclick="nextSong()">
						<img src="assets/images/icons/next.png" alt="Next">
					</button>

					<button class="controlButton repeat" title="Repeat button" onclick="setRepeat()">
						<img src="assets/images/icons/repeat.png" alt="Repeat">
					</button>

				</div>


				<div class="playbackBar">

					<span class="progressTime current">0:00</span>

					<div class="progressBar">
						<div class="progressBarBg">
							<div class="progress"></div>
						</div>
					</div>

					<span class="progressTime remaining">0:00</span>


				</div>


			</div>


		</div>

		<div id="nowPlayingRight">
			<div class="volumeBar">

				<button class="controlButton volume" title="Volume button" onclick="setMute()">
					<img src="assets/images/icons/volume.png" alt="Volume">
				</button>

				<div class="progressBar">
					<div class="progressBarBg">
						<div class="progress"></div>
					</div>
				</div>

			</div>
		</div>




	</div>

</div>
