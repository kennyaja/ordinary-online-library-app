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
		<div class="text-center rounded-md not-empty:bg-red-200 not-empty:border-1 not-empty:border-red-500 not-empty:py-4 not-empty:mb-3" id="errorDisplay"></div>
		<form action="/api/signup" method="post" id="signupForm">
			<div class="mb-3">
				<label for="username">Username</label>
				<input type="text" placeholder="e.g. Xx_EpicGamer123_xX" name="username" id="username" class="bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1" autocomplete="off">
				<div class="text-red-500" id="usernameValidationMsg"></div>
			</div>

			<div class="mb-3">
				<label for="password">Password</label>
				<input type="password" placeholder="Must be over &#960; (3.14159265...) characters" name="password" id="password" class="bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1" autocomplete="off">
				<div class="text-red-500" id="passwordValidationMsg"></div>
			</div>

			<div class="mb-3">
				<label for="email">Email</label>
				<input type="text" placeholder="e.g. skeleton@&#x1F480;&#x1F3BA;.tk" name="email" id="email" class="bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1" autocomplete="off">
				<div class="text-red-500" id="emailValidationMsg"></div>
			</div>
			
			<button class="bg-blue-400 hover:bg-blue-500 text-white font-bold rounded-md w-full p-3 duration-200 cursor-pointer">
				<i class="fa-solid fa-user-plus"></i>
				Sign up
			</button>
		</form>
		<a href="/login" class="text-blue-500 underline">already have an account?</a>
	</div>

	<script>
		const signupForm = document.getElementById("signupForm");
		const errorDisplay = document.getElementById("errorDisplay");

		function displayValidationError(name, msg) {
			const field = document.getElementById(name);
			const fieldValidationMsg = document.getElementById(`${name}ValidationMsg`);

			if (msg == null || msg == undefined) {
				field.classList.remove("border-red-500");
				fieldValidationMsg.innerText = "";
			} else {
				field.classList.add("border-red-500");
				fieldValidationMsg.innerText = msg;
			}
		}

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

			displayValidationError("username", json.errors.username);
			displayValidationError("password", json.errors.password);
			displayValidationError("email", json.errors.email);
		}

		signupForm.addEventListener("submit", e => {
			e.preventDefault();
			sendData();
		});
	</script>
</body>
</html>
