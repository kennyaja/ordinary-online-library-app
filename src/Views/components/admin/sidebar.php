<?php
	$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
?>

<aside class="bg-gray-100 hidden md:flex flex-col px-3 py-2 justify-between w-52">
	<div class="flex flex-col gap-3">
		<a href="/admin" <?= $path == "/admin" ? "class='text-blue-500'" : "" ?>>Dashboard</a>
		<a href="/admin/users" <?= $path == "/admin/users" ? "class='text-blue-500'" : "" ?>>Users</a>
		<a href="/admin/cashiers" <?= $path == "/admin/cashiers" ? "class='text-blue-500'" : "" ?>>Cashiers</a>
		<a href="/admin/books" <?= $path == "/admin/books" ? "class='text-blue-500'" : "" ?>>Books</a>
	</div>
	<div class="flex flex-col gap-3">
		<a href="/api/logout">
			<i class="fa-solid fa-arrow-right-from-bracket"></i>
			log out
		</a>
	</div>
</aside>
