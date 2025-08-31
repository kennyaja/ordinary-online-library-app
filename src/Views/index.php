<?php
use App\Lib\View\View;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?= View::get("components/metadata.php", ["title" => $title]) ?>
</head>
<body>
	<?= $_SESSION["username"] ?? "log in buddy" ?> (<?= $_SESSION["user_role"] ?? "" ?>)
	<a href="/api/logout" class="text-blue-500">log out</a>
</body>
</html>
