<?php
include("config.php");
include("classes/Artist.php");
include("classes/Album.php");
include("classes/Song.php");
//
// //session_destroy(); LOGOUT
//
// if(isset($_SESSION['userLoggedIn'])) {
// 	$userLoggedIn = $_SESSION['userLoggedIn'];
// }
// else {
// 	header("Location: register.php");
// }
?>
<!DOCTYPE html>

<html lang="en" dir="ltr">
<head>
	<title>歡迎使用Musicplayer!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
</head>
<body>
<div id="mainContainer">
	<div id="topContainer">
		<?php include("navBarContainer.php"); ?>
	</div>
	<div id="mainViewContainer">
		<div id="mainContent">
