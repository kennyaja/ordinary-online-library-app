<?php
use App\Lib\View\View;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?= View::get("components/metadata.php", ["title" => $title]) ?>
</head>
<body>
	<?= View::get("components/admin/navbar.php") ?>
	<div class="grid grid-flow-col grid-cols-[auto_1fr] h-[calc(100dvh-3rem)]">
		<?= View::get("components/admin/sidebar.php") ?>
		<div class="px-4 py-5">
			<table class="table-auto border-collapse">
				<thead class="border-b-gray-500 border-b-1">
					<tr class="*:p-3">
						<th>#</th>
						<th>username</th>
						<th>email</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$i = 0;
						foreach ($users as $user) {
							$i++;
							echo <<<HTML
								<tr class="*:p-3 border-b-gray-300 border-b-1">
									<th>$i</th>
									<td>$user[username]</td>
									<td>$user[email]</td>
									<td>
										<button class="update-button px-4 py-2 rounded-md text-white bg-blue-400 hover:bg-blue-500 cursor-pointer" data-userid="$user[id]" data-action="update">
											update
										</button>
										<button class="update-button px-4 py-2 rounded-md text-white bg-red-500 hover:bg-red-600 cursor-pointer" data-userid="$user[id]" data-action="delete">
											BEGONE
										</button>
									</td>
								</tr>
							HTML;
						}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<div id="modal" class="fixed left-0 top-0 z-50 w-full h-full backdrop-brightness-75 transition-all duration-200 invisible opacity-0">
		<div class="mx-auto container max-w-3xl mt-20 bg-white">
			<h1>hi</h1>
		</div>
	</div>

	<script>
		const modal = document.getElementById("modal");
		modal.onclick = () => {
			modal.classList.add("invisible", "opacity-0");
		}
	</script>

	<script>
		const buttons = document.querySelectorAll(".update-button");

		buttons.forEach(button => {
			button.addEventListener('click', () => {
				if (button.dataset.action == "update") {
					modal.classList.remove("invisible", "opacity-0");
				}
			})
		})
	</script>
</body>
</html>
