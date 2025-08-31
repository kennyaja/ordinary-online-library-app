<?php
use App\Lib\View\View;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?= View::get("components/metadata.php", ["title" => $title]) ?>
</head>
<body>
	<?= $a ?>

	<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam cum sapiente accusamus eos delectus, et rem, consequuntur, nam reiciendis ex obcaecati veritatis magni. Culpa laborum enim et magnam ipsam alias!</p>
</body>
</html>
