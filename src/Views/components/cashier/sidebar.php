<?php
	$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
?>

<aside class="bg-gray-100 hidden md:flex flex-col px-3 py-2 justify-between w-52">
	<div class="flex flex-col gap-3">
		<a href="/cashier" <?= $path == "/cashier" ? "class='text-blue-500'" : "" ?>>Dashboard</a>
		<a href="/cashier/borrows" <?= $path == "/cashier/borrows" ? "class='text-blue-500'" : "" ?>>Borrows</a>
	</div>
	<div class="flex flex-col gap-3">
		<a href="/api/logout">
			<i class="fa-solid fa-arrow-right-from-bracket"></i>
			log out
		</a>
	</div>
</aside>
