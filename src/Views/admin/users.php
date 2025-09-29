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
			<table class="table-auto border-collapse">
				<thead class="border-b-gray-500 border-b-1">
					<tr class="*:p-3">
						<th>#</th>
						<th>username</th>
						<th>email</th>
						<th>role</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="table_contents">
					<!-- js content -->
				</tbody>
			</table>
			<button id="add_new" class="bg-green-400 hover:bg-green-500 transition-colors duration-200 mt-12 px-4 py-2 rounded-md cursor-pointer">
				add
			</button>
		</div>
	</div>

	<div id="modal" class="fixed left-0 top-0 z-1 w-full h-full backdrop-brightness-75 transition-all duration-200 invisible opacity-0">
		<div id="modalContent" class="mx-auto container max-w-3xl mt-20 bg-white px-4 py-5 z-2 rounded-lg shadow-lg">
			<!-- js content -->
		</div>
	</div>

	<script>
		function loadUsersTable(users_list) {
			const table_contents = document.getElementById("table_contents");
			table_contents.innerHTML = '';

			users_list.forEach((user, index) => {
				table_contents.append(
					newEl("tr", null, {"class": "*:p-3 border-b-gray-300 border-b-1"}, [
						newEl("th", index + 1),
						newEl("td", user.username),
						newEl("td", user.email),
						newEl("td", user.role),
						newEl("td", null, {"class": "grid lg:grid-flow-col gap-1"}, [
							newEl("button", "update", {
								"class": "update-button px-3 py-2 rounded-md text-white bg-blue-400 hover:bg-blue-500 cursor-pointer",
								"data-userid": user.id,
								"data-action": "update",
							}, null),
							newEl("button", "delete", {
								"class": "update-button px-3 py-2 rounded-md text-white bg-red-500 hover:bg-red-600 cursor-pointer",
								"data-userid": user.id,
								"data-action": "delete",
							}, null)
						]),
					]),
				)
			})

			const buttons = document.querySelectorAll(".update-button");

			buttons.forEach(button => {
				button.addEventListener('click', async () => {
					if (button.dataset.action == "update") {
						toggleModal();

						let response = await fetch(`/api/users/details?id=${button.dataset.userid}`);
						let user_data = await response.json();

						setModalContent(...formModalContent(user_data.id, user_data.username, user_data.email, null, user_data.role, "/api/users/update", "update user"));
					}

					if (button.dataset.action == "delete") {
						if (!confirm("you sure?")) {
							return;
						}

						const formdata = new FormData();
						formdata.append("id", button.dataset.userid);

						fetch("/api/users/delete", {
							method: "POST",
							body: formdata,
						}).then(() => {
							getUsersList().then(users_list => loadUsersTable(users_list));
						});
					}
				})
			})
		}
	</script>

	<script>
		const modal = el("#modal");
		const modalContent = el("#modalContent");

		document.addEventListener('click', event => {
			if (event.target == modal) {
				toggleModal();
			}
		})

		function toggleModal() {
			if (modal.classList.contains("invisible")) {
				modal.classList.remove("invisible", "opacity-0");
			} else {
				modal.classList.add("invisible", "opacity-0");
			}
		}

		function setModalContent(...content) {
			modalContent.replaceChildren(...content);
		}
	</script>

	<script>
		function formModalContent(id, username, email, password, user_role, url, modal_title) {
			return [
				newEl("div", null, {"class": "flex justify-between"}, [
					newEl("h1", modal_title, {"class": "text-3xl font-bold float-left"}),
					newEl("div", null, {"class": "rounded-full bg-red-500 float-right px-2.5 py-2 text-white", "onclick": "toggleModal()"}, [
						newEl("i", null, {"class": "fa-solid fa-xmark"}),
					]),
				]),

				newEl("form", null, {
					"class": "mt-5 grid grid-flow-row gap-3", 
					"id": "user_submit_form",
					"_event_submit": (event, el) => {
						event.preventDefault();
						
						const formData = new FormData(el);
						
						fetch(url, {
							method: "POST",
							body: formData,
						}).then(() => {
							getUsersList().then(users_list => loadUsersTable(users_list));
							toggleModal();
						});
					},
				}, [
					newEl("input", null, {"type": "hidden", "name": "id", "value": id ?? ""}),

					newEl("label", "username", {"for": "username"}),
					newEl("input", null, {"name": "username", "id": "username", "class": "bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1", "value": username ?? ""}),

					newEl("label", "email", {"for": "email"}),
					newEl("input", null, {"name": "email", "id": "email", "class": "bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1", "value": email ?? ""}),

					newEl("label", "password (y doe)", {"for": "password"}),
					newEl("input", null, {"name": "password", "id": "password", "class": "bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1", "value": password ?? "", "autocomplete": "off"}),

					newEl("div", null, {"class": "flex flex-col items-start"}, [
						newEl("label", "role", {"for": "role"}),
						newEl("select", null, {"name": "role", "id": "role", "class": "bg-gray-200 px-3 py-2 rounded-md"}, 
							() => {
								const roles = ["user", "cashier", "admin"];
								let option_elements = [];

								roles.forEach(role => {
									option_elements.push(
										newEl("option", role, {"value": role, "selected": (role == user_role ? "true" : null)})
									);
								});

								return option_elements;
							}
						),
					]),

					newEl("button", "submit", {"class": "bg-blue-400 hover:bg-blue-500 text-white font-bold rounded-md px-4 py-2 duration-200 cursor-pointer"}),
				])
			]
		}
	</script>

	<script>
		const add_new = el("#add_new");

		add_new.onclick = () => {
			toggleModal();
			setModalContent(...formModalContent(null, null, null, null, null, "/api/users/insert", "add new user"));
		}
	</script>

	<script>
		const table_contents = document.getElementById("table_contents");

		async function getUsersList() {
			const response = await fetch("/api/users/list", {
				method: "POST",
			});

			const json = await response.json();
			return json;
		}

		getUsersList().then((users_list) => {
			loadUsersTable(users_list);
		});
	</script>
</body>
</html>
