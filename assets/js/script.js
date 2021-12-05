var currentPlaylist = []; //現在播放清單
var shufflePlaylist = []; //shuffle模式的播放清單
var tempPlaylist = []; //
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat =false;
var shuffle = false;
var userLoggedIn;
//console.log("SANDWICH"); // **** ADD THIS LINE ****

// function openPage(url) {
// 	if(url.indexOf("?") ==-1){
// 		url = url +"?";
// 	}
// 	var encodedUrl = encodeURI(url +"&userLoggedIn" + userLoggedIn);
// console.log(encodeURI);
// 	$("#mainContent").load(encodedUrl);
// $("body").scrollTop(0);
//history.pushState(null,null,url);
// } //encodeedUrl ??

function formatTime(seconds) {

	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60); //Rounds down
	var seconds = time - (minutes * 60);

	var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}


function updateTimeProgressBar(audio) {
	$(".progressTime.current").text(formatTime(audio.currentTime));
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));
	var progress = audio.currentTime / audio.duration * 100;
	$(".playbackBar .progress").css("width", progress + "%");
}
function updateVolumeProgressBar(audio){
	var volume = audio.volume * 100;
	$(".volumeBar .progress").css("width", volume + "%");
}


function Audio(){
  this.currentlyPlaying;
  this.audio = document.createElement('audio');
	this.audio.addEventListener("ended", function() {
		nextSong();
	});

  this.audio.addEventListener('canplay',function(){
    //'this' refers to the object that event was called on
    var duration = formatTime(this.duration);
    //console.log("hihihi");
    $(".progressTime.remaining").text(duration);
		updateVolumeProgressBar(audioElement.audio);
  }); //?why writing like this?
  this.audio.addEventListener("timeupdate",function(){
    if(this.duration) {
			updateTimeProgressBar(this);
		}
  });
	//volume change音量變化可以新增事件監聽
	this.audio.addEventListener("volumechange",function(){
		updateVolumeProgressBar(this);
	})

  this.setTrack = function(track){
    this.currentlyPlaying = track;
    this.audio.src = track.path;
  }
  this.play = function(){
    this.audio.play();
  }
  this.pause = function(){
    this.audio.pause();
  }
  this.setTime = function(seconds) {
		this.audio.currentTime = seconds;
	}
}
