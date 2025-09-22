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
			<button class="bg-uma-green px-4 py-2 rounded-md shadow-md text-white text-shadow-md" id="umazing_button">&#x1F44D; Umazing!</button>

			<script>
				const umazing_button = document.getElementById("umazing_button");
				umazing_button.onclick = () => {
					umazing_button.classList.remove("bg-uma-green");
					umazing_button.classList.add("bg-uma-pink");
					umazing_button.innerHTML = "&#x1F44D; Umazed!";
				}
			</script>
		</div>
	</div>
</body>
</html>
