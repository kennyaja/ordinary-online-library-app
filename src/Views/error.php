<?php
use App\Lib\View\View;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?= View::get("components/metadata.php") ?>
</head>
<body>
	<center class="flex flex-col items-center">
		<h1 class="text-8xl text-center font-bold mt-64"><?= $err ?></h1>
		<h2 class="text-2xl text-center mt-12"><?= $message ?></h2>

		<?php
			if ($throwable != null) {
				?>
					<p class="text-center mt-6 text-red-500"><?= get_class($throwable) . ": " . $throwable->getMessage() ?></p>
					<p class="text-center mt-2 text-gray-400"><?= preg_replace("/(?!^#)#/", "<br>#", $throwable->getTraceAsString()) ?></p>
				<?php
			}
		?>

		<a class="bg-blue-400 hover:bg-blue-500 duration-200 text-lg text-white px-5 py-3 rounded-md mt-6" href="/">go home</a>
	</center>
</body>
</html>
