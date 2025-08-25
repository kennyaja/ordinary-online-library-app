<h1 class="text-5xl text-center mt-48">Login</h1>

<div class="w-120 max-w-screen mx-auto px-6 py-12 mt-6 rounded-lg shadow-lg bg-gray-50">
	<form action="/api/login" method="post">
		<label for="username">Username</label>
		<input type="text" placeholder="e.g. Xx_EpicGamer1_xX" name="username" class="bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1 mb-3">

		<label for="password">Password</label>
		<input type="text" placeholder="Must be over 3.14159265358979323846 characters" name="password" class="bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1 mb-3">
		
		<input type="submit" value="Log in" class="bg-blue-400 hover:bg-blue-500 text-white font-bold rounded-md w-full p-3 duration-200 cursor-pointer">
	</form>
</div>

