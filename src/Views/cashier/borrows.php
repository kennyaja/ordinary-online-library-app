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
			<ul id="borrows_list" class="flex flex-col items-start gap-3">
				<!-- js content -->
			</ul>
		</div>
	</div>

	<script>
		async function loadBorrows() {
			let response = await fetch("/api/borrows/list");
			let borrows = await response.json();

			el("#borrows_list").innerHTML = "";


			borrows.forEach(borrow => {
				let date = new Date(borrow.borrowed_at * 1000).toLocaleString();

				el("#borrows_list").appendChild(
					newEl("li", null, {"class": "shadow-md rounded-md px-6 py-4 flex flex-row gap-12"}, [
						newEl("div", null, {"class": "flex flex-col"}, [
							newEl("h3", borrow.book_title, {"class": "font-bold"}),
							newEl("p", `by: ${borrow.username}`, {"class": "text-gray-700"}),
							newEl("span", `at: ${date}`),
						]),
						newEl("div", null, {"class": "flex items-center gap-1"}, () => {
							switch (borrow.status) {
								case "pending":
									return [
										newEl("button", "approve", {
											"class": "px-3 py-2 rounded-md text-white bg-blue-400 hover:bg-blue-500 cursor-pointer",
											"_event_click": () => {
												let form_data = new FormData();
												form_data.append("id", borrow.id);
												form_data.append("status", "approved");
												form_data.append("borrow_deadline", borrow.borrowed_at + (86400 * 7));

												fetch("/api/borrows/update_status", {
													method: "POST",
													body: form_data,
												}).then(() => {
													loadBorrows();
												})
											}
										}),
										newEl("button", "reject", {
											"class": "px-3 py-2 rounded-md text-white bg-red-500 hover:bg-red-600 cursor-pointer",
											"_event_click": () => {
												let form_data = new FormData();
												form_data.append("id", borrow.id);
												form_data.append("status", "rejected");

												fetch("/api/borrows/update_status", {
													method: "POST",
													body: form_data,
												}).then(() => {
													loadBorrows();
												})
											}
										})
									];
									break;
								case "approved":
									return [newEl("span", "approved", {"class": "text-blue-500"})];
									break;
								case "rejected":
									return [newEl("span", "rejected", {"class": "text-red-500"})];
									break;
							}
						})
					]),
				);
			})
		}

		loadBorrows();
	</script>
</body>
</html>

