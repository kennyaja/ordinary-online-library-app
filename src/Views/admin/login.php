<?php
use App\Lib\View\View;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?= View::get("components/metadata.php", ["title" => $title]) ?>
</head>
<body>
	<h1 class="text-5xl text-center mt-48">Login <span class="text-base">(admin ver)</span></h1>

	<div class="w-120 max-w-screen mx-auto px-6 py-12 mt-6 rounded-lg shadow-lg bg-gray-50">
		<div class="text-center rounded-md not-empty:bg-red-200 not-empty:border-2 not-empty:border-red-500 not-empty:py-4 not-empty:mb-3" id="errorDisplay"></div>
		<form action="/api/login" method="post" id="loginForm">
			<label for="username">Username</label>
			<input type="text" placeholder="e.g. Xx_EpicGamer1_xX" name="username" class="bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1 mb-3">

			<label for="password">Password</label>
			<input type="password" placeholder="Must be over &#960; (3.14159265...) characters" name="password" class="bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1 mb-3">
			
			<button class="bg-blue-400 hover:bg-blue-500 text-white font-bold rounded-md w-full p-3 duration-200 cursor-pointer">
				<i class="fa-solid fa-arrow-right-to-bracket"></i>
				Log in
			</button>
		</form>
		<a href="/signup" class="text-blue-500 underline">no account?</a>
	</div>

	<script>
		const loginForm = document.getElementById("loginForm");
		const errorDisplay = document.getElementById("errorDisplay");

		async function sendData() {
			const formData = new FormData(loginForm);

			const response = await fetch("/api/admin_login", {
				method: "POST",
				body: formData,
			});

			if (response.redirected) {
				window.location.href = response.url;
				return;
			}

			const json = await response.json();
			errorDisplay.innerText = json.error;
		}

		loginForm.addEventListener("submit", e => {
			e.preventDefault();
			sendData();
		});
	</script>
</body>
</html>
