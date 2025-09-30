<?php
use App\Lib\View\View;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?= View::get("components/metadata.php", ["title" => $title]) ?>
</head>
<body>
	<?= View::get("components/header.php") ?>
	
	<h1 class="text-4xl font-bold mt-20 text-center">some very cool books</h1>
	<div class="container max-w-320 mx-auto">
		<ul id="books_list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mx-8 mt-12">
			<!-- js content -->
		</ul>
	</div>
	
	<script>
		const books_list = document.querySelector("#books_list");

		async function loadBooks() {
			const response = await fetch("/api/books/list?show_borrow_status=1");
			const books = await response.json();

			el("#books_list").innerHTML = "";

			books.forEach(book => {
				const actual_content_cdn_url = `${location.protocol}//${book.content_cdn_url.replace("{server_addr}", location.host)}`;
				const actual_image_url = `${location.protocol}//${book.image_url.replace("{server_addr}", location.host)}`;

				books_list.append(
					newEl("li", null, {"class": "shadow-md rounded-md overflow-hidden flex flex-col"}, [
						newEl("img", null, {"class": "block w-full aspect-3/4 object-cover", "src": actual_image_url}),
						newEl("div", null, {"class": "px-3 py-4 grid grid-flow-row justify-items-start gap-2 grow"}, [
							newEl("div", null, {"class": "flex flex-col gap-2 mb-3"}, [
								newEl("h3", book.title, {"class": "text-2xl font-bold"}),
								newEl("span", `by ${book.author}`, {"class": "text-gray-700"}),
							]),

							newEl("div", null, {"class": "flex gap-1 mt-auto items-center"}, [
								newEl("a", "details", {
									"class": "border-green-400 hover:border-green-500 border-2 transition-colors duration-200 px-4 py-2 rounded-md text-green-400 hover:text-green-500 hover:bg-gray-100", 
									"href": `books/book?id=${book.id}`}),
								
								newEl("a", "read", {"class": "bg-blue-400 hover:bg-blue-500 transition-colors duration-200 px-4 py-2 rounded-md text-white", "href": actual_content_cdn_url}),
								() => {
									if (user_role != "user") {
										return;
									}

									if (book.borrow_status == null) {
										return newEl("a", "borrow", {
											"class": "bg-yellow-400 hover:bg-yellow-500 transition-colors duration-200 px-4 py-2 rounded-md text-white", 
											"href": "javascript:void(0)",
											"_event_click": () => {
												let form_data = new FormData();
												form_data.append("book_id", book.id);

												fetch("/api/borrows/borrow", {
													method: "POST",
													body: form_data,
												}).then(() => {
													loadBooks();
												})
											}
										})
									} else {
										return newEl("span", `borrow ${book.borrow_status}`, {"class": "text-yellow-500 px-3"})
									}
								}
							]),
						])
					])
				)
			})
		}

		loadBooks();
	</script>
</body>
</html>
