<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $data["title"] ?? "Document" ?></title>
<link rel="stylesheet" href="/css/tailwind.css">
<link rel="stylesheet" href="/css/fontawesome/all.min.css">
<script src="/js/html_builder.js"></script>

<script>
	const username = "<?= $_SESSION["username"] ?? "null" ?>";
	const user_id = "<?= $_SESSION["user_id"] ?? "null" ?>";
	const user_role = "<?= $_SESSION["user_role"] ?? "null" ?>";
</script>
