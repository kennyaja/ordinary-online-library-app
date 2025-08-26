<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= $view_data["title"] ?></title>
		<?= $view_data["metadata"] ?>
	</head>
	<body>
		<?= $view_data["header"] ?>
		<?= $view_data["content"] ?>
		<?= $view_data["footer"] ?>
	</body>
</html>
