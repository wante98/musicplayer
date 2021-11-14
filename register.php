<?php
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account();

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>



<html>
<head>
	<title>歡迎使用Slotify!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="assets/js/register.js" charset="utf-8"></script>
</head>
<body>
	<?php

	if(isset($_POST['registerButton'])) {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").hide();
					$("#registerForm").show();
				});
			</script>';
	}
	else {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").show();
					$("#registerForm").hide();
				});
			</script>';
	}

	?>
<div id="background">
	<div id="loginContainer">
		<div id="inputContainer">
			<form id="loginForm" action="register.php" method="POST">
				<h2>若要繼續，請登入</h2>
				<p>
					<label for="loginUsername">用戶名稱</label>
					<input id="loginUsername" name="loginUsername" type="text" placeholder="用戶名稱" required>
				</p>
				<p>
					<label for="loginPassword">密碼</label>
					<input id="loginPassword" name="loginPassword" type="password" placeholder="密碼" required>
				</p>

				<button type="submit" name="loginButton">登入</button>

				<div class="hasAccountText">
						<span id="hideLogin">尚未註冊?請點選此處</span>
				</div>

			</form>



			<form id="registerForm" action="register.php" method="POST">
				<h2>註冊新帳戶</h2>
				<p>
					<label for="username">用戶名稱</label>
					<input id="username" name="username" type="text" placeholder="請輸入用戶名稱" required>
				</p>

				<p>
					<label for="firstName">姓名</label>
					<input id="firstName" name="firstName" type="text" placeholder="請輸入姓名" required>
				</p>

				<p>
					<label for="lastName">姓氏</label>
					<input id="lastName" name="lastName" type="text" placeholder="請輸入姓氏" required>
				</p>

				<p>
					<label for="email">Email</label>
					<input id="email" name="email" type="email" placeholder="請輸入Email" required>
				</p>

				<p>
					<label for="email2">確認email</label>
					<input id="email2" name="email2" type="email" placeholder="請再次輸入Email" required>
				</p>

				<p>
					<label for="password">密碼</label>
					<input id="password" name="password" type="password" placeholder="請輸入密碼" required>
				</p>

				<p>
					<label for="password2">確認密碼</label>
					<input id="password2" name="password2" type="password" placeholder="請再次確認密碼" required>
				</p>

				<button type="submit" name="registerButton">註冊</button>
				<div class="hasAccountText">
						<span id="hideRegister">已有帳號?請點選此處</span>
				</div>

			</form>


		</div>
		<div id="loginText">
				<h1>現在就享受好聽的音樂！</h1>
				<h2>免費！無料！省下來喝杯喜歡的飲料！</h2>
				<ul>
					<li>探索你/妳喜歡的音樂</li>
					<li>創建自己的播放清單</li>
					<li>發漏唱片界最新動態</li>
				</ul>
			</div>
	</div>
</div>
</body>
</html>
