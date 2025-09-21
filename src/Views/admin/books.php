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
			<iframe id="globglogabgalab" src="https://www.youtube.com/embed/W1dRBWyf6z8" title="I am the Globglogabgalab" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
			<script>
				const globglogabgalab = document.getElementById("globglogabgalab");

				function updateGlobglogabgalabWidthAndHeight() {
					let width = window.innerWidth - 32; // 1rem (16px in this case) of padding for each side
					let height = width * (9 / 16);

					globglogabgalab.width = Math.min(width, 640);
					globglogabgalab.height = Math.min(height, 360);
				}

				onresize = () => {
					updateGlobglogabgalabWidthAndHeight();
				}
				updateGlobglogabgalabWidthAndHeight();
			</script>

			<table class="table-auto border-collapse mt-5">
				<thead class="border-b-gray-500 border-b-1">
					<tr class="*:p-3">
						<th>#</th>
						<th>title</th>
						<th>author</th>
						<th>cdn</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$i = 0;
						foreach ($books as $book) {
							$i++;
							echo <<<HTML
								<tr class="*:p-3 border-b-gray-300 border-b-1">
									<th>$i</th>
									<td>$book[title]</td>
									<td>$book[author]</td>
									<td class="max-w-64"><a href="$book[content_cdn_url]" class="text-blue-500 underline cursor-pointer">$book[content_cdn_url]</a></td>
									<td class="grid lg:grid-flow-col gap-1">
										<button class="update-button px-4 py-2 rounded-md text-white bg-blue-400 hover:bg-blue-500 cursor-pointer" data-bookid="$book[id]" data-action="update">
											update
										</button>
										<button class="update-button px-4 py-2 rounded-md text-white bg-red-500 hover:bg-red-600 cursor-pointer" data-bookid="$book[id]" data-action="delete">
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
