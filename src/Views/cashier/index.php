<?php
use App\Lib\View\View;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?= View::get("components/metadata.php", ["title" => $title]) ?>
</head>
<body>
	<?= View::get("components/cashier/navbar.php") ?>
	<div class="grid grid-flow-col grid-cols-[auto_1fr] h-[calc(100dvh-3rem)]">
		<?= View::get("components/cashier/sidebar.php") ?>
		<div class="px-4 py-5">
			<div class="flex">
				you are not her --&gt; <img src="img/sora.webp" alt="" class="w-32">
			</div>
		</div>
	</div>
</body>
</html>

