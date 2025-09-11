<?php
use App\Lib\View\View;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?= View::get("components/metadata.php", ["title" => $title]) ?>
</head>
<body>
	<h1 class="text-5xl text-center mt-48">Sign Up</h1>

	<div class="w-120 max-w-screen mx-auto px-6 py-12 mt-6 rounded-lg shadow-lg bg-gray-50">
		<div class="text-center text-red-500" id="errorDisplay"></div>
		<form action="/api/signup" method="post" id="signupForm">
			<label for="username">Username</label>
			<input type="text" placeholder="e.g. Xx_EpicGamer123_xX" name="username" id="username" class="bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1 mb-3">
			<span class="text-red-500" id="usernameValidationMsg"></span>

			<label for="password">Password</label>
			<input type="password" placeholder="Must be over 3.14159265358979323846 characters" name="password" id="password" class="bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1 mb-3">
			<span class="text-red-500" id="passwordValidationMsg"></span>

			<label for="email">Email</label>
			<input type="text" placeholder="e.g. skeleton@&#x1F480;&#x1F3BA;.tk" name="email" id="email" class="bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1 mb-3">
			<span class="text-red-500" id="emailValidationMsg"></span>
			
			<button id="submitButton" class="bg-blue-400 hover:bg-blue-500 text-white font-bold rounded-md w-full p-3 duration-200 cursor-pointer">
				<i class="fa-solid fa-user-plus"></i>
				Sign up
			</button>
		</form>
		<a href="/login" class="text-blue-500 underline">already have an account?</a>
	</div>

	<script>
		const signupForm = document.getElementById("signupForm");
		const errorDisplay = document.getElementById("errorDisplay");
		const submitButton = document.getElementById("submitButton");

		async function sendData() {
			const formData = new FormData(signupForm);

			const response = await fetch("/api/signup", {
				method: "POST",
				body: formData,
			});

			if (response.redirected) {
				window.location.href = response.url;
				return;
			}

			const json = await response.json();
			errorDisplay.innerText = json.errors;
		}

		signupForm.addEventListener("submit", e => {
			e.preventDefault();
			sendData();
		});

		submitButton.addEventListener("click", e => {
			signupForm.submit();
		});
	</script>
</body>
</html>
