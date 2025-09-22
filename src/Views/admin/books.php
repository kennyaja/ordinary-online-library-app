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
			<iframe id="globglogabgalab" src="https://www.youtube.com/embed/W1dRBWyf6z8" title="I am the Globglogabgalab" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
			<script>
				const globglogabgalab = document.getElementById("globglogabgalab");

				function updateGlobglogabgalabWidthAndHeight() {
					let width = window.innerWidth - 32; // 1rem (16px in this case) of padding for each side
					let height = width * (9 / 16);

					globglogabgalab.width = Math.min(width, 640);
					globglogabgalab.height = Math.min(height, 360);
				}

				onresize = () => {
					updateGlobglogabgalabWidthAndHeight();
				}
				updateGlobglogabgalabWidthAndHeight();
			</script>

			<table class="table-auto border-collapse mt-5">
				<thead class="border-b-gray-500 border-b-1">
					<tr class="*:p-3">
						<th>#</th>
						<th>title</th>
						<th>author</th>
						<th>cdn</th>
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
			<h1>hi</h1>
		</div>
	</div>

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
		const add_new = el("#add_new");

		add_new.onclick = () => {
			toggleModal();
			setModalContent(
				newEl("div", null, {"class": "flex justify-between"}, [
					newEl("h1", "add new book", {"class": "text-3xl font-bold float-left"}),
					newEl("div", null, {"class": "rounded-full bg-red-500 float-right px-2.5 py-2 text-white", "onclick": "toggleModal()"}, [
						newEl("i", null, {"class": "fa-solid fa-xmark"}),
					]),
				]),

				newEl("form", null, {"method": "post", "enctype": "multipart/form-data", "class": "mt-5 grid grid-flow-row gap-3", "action": "/api/admin/submit_book"}, [
					newEl("div", null, {"class": "grid grid-flow-col grid-cols-auto gap-4"}, [
						newEl("div", null, null, [
							newEl("label", "title", {"for": "title"}),
							newEl("input", null, {"name": "title", "id": "title", "class": "bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1"}),
						]),

						newEl("div", null, null, [
							newEl("label", "author", {"for": "author"}),
							newEl("input", null, {"name": "author", "id": "author", "class": "bg-white p-3 border-gray-500 border-1 rounded-md w-full mt-1"}),
						]),
					]),

					newEl("label", "description", {"for": "description"}),
					newEl("textarea", null, {"name": "description", "id": "description", "class": "bg-white px-3 py-2 border-gray-500 border-1 rounded-md w-full mt-1"}),

					// idk maybe add external link support for this maybe perhaps
					newEl("div", null, null, [
						newEl("label", "content pdf file", {"for": "content pdf_file"}),
						newEl("br"),
						newEl("input", null, {"type": "file", "name": "content_pdf_file", "id": "content_pdf_file", "class": "file:bg-gray-200 file:px-3 file:py-1 file:rounded-md"}),
					]),

					newEl("div", null, null, [
						newEl("label", "image file (book cover)", {"for": "image_file"}),
						newEl("br"),
						newEl("input", null, {"type": "file", "name": "image_file", "id": "image_file", "class": "file:bg-gray-200 file:px-3 file:py-1 file:rounded-md mt-1"}),
					]),

					newEl("button", "submit", {"class": "bg-blue-400 hover:bg-blue-500 text-white font-bold rounded-md px-4 py-2 duration-200 cursor-pointer"}),
				])
			);
		}
	</script>

	<script>
		const table_contents = document.getElementById("table_contents");

		async function getBooksList() {
			const response = await fetch("/api/admin/books_list", {
				method: "POST",
			});

			const json = await response.json();
			return json;
		}

		getBooksList().then((books_list) => {
			books_list.forEach((book, index) => {
				const actual_content_cdn_url = `${location.protocol}//${book.content_cdn_url.replace("{server_addr}", location.host)}`;

				table_contents.append(
					newEl("tr", null, {"class": "*:p-3 border-b-gray-300 border-b-1"}, [
						newEl("th", index + 1),
						newEl("td", book.title),
						newEl("td", book.author),
						newEl("td", null, {"class": "max-w-64"}, [
							newEl("a", actual_content_cdn_url, {"class": "text-blue-500", "href": actual_content_cdn_url}, null),
						]),
						newEl("td", null, {"class": "grid lg:grid-flow-col gap-1"}, [
							newEl("button", "update", {
								"class": "update-button px-3 py-2 rounded-md text-white bg-blue-400 hover:bg-blue-500 cursor-pointer",
								"data-bookid": book.id,
								"data-action": "update",
							}, null),
							newEl("button", "BEGONE", {
								"class": "update-button px-3 py-2 rounded-md text-white bg-red-500 hover:bg-red-600 cursor-pointer",
								"data-bookid": book.id,
								"data-action": "delete",
							}, null)
						]),
					]),
				)
			})

			const buttons = document.querySelectorAll(".update-button");

			buttons.forEach(button => {
				button.addEventListener('click', () => {
					if (button.dataset.action == "update") {
						toggleModal();
					}
				})
			})
		});
	</script>
</body>
</html>
