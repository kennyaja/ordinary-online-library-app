<nav class="flex justify-between *:items-center bg-gray-100 px-6 py-4">
	<div class="flex gap-3">
		<h3 class="text-xl font-bold">app name here</h3>
		<!-- <a href="/borrows" class="text-blue-500">borrows</a> -->
	</div>
	<div class="flex gap-3">
		(<?= $_SESSION["username"] ?>)
		<a href="/api/logout" class="text-blue-500">log out</a>
	</div>
</nav>
