<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= $viewData["title"] ?></title>
		<?= $viewData["metadata"] ?>
	</head>
	<body>
		<?= $viewData["header"] ?>
		<?= $viewData["content"] ?>
		<?= $viewData["footer"] ?>
	</body>
</html>
