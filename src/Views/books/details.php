<?php
use App\Lib\View\View;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?= View::get("components/metadata.php", ["title" => $title]) ?>
</head>
<body>
	<a href="/" class="text-blue-500">go back</a>
	
	<!--<h1 class="text-4xl font-bold mt-20 text-center">some very cool books</h1>
	<ul id="books_list" class="grid grid-flow-col grid-cols-5 gap-4 mx-8 mt-12">
	</ul>-->
	
	<div class="grid grid-flow-col grid-cols-1 md:grid-cols-[32rem_auto] gap-6">
		<img src="" alt="" id="book_image">	
		<div class="flex flex-col items-start">
			<h1 class="text-4xl font-bold" id="book_title"></h1>
			<h2 class="text-gray-700 text-xl font-bold mt-3" id="book_author"></h2>
			<p class="text-gray-500 mt-6" id="book_description"></p>
			
			<div class="flex gap-1 mt-12">
				<a href="" class="bg-blue-400 hover:bg-blue-500 transition-colors duration-200 px-4 py-2 rounded-md text-white" id="book_content_url">read</a>
				<a href="/j" class="bg-yellow-400 hover:bg-yellow-500 transition-colors duration-200 px-4 py-2 rounded-md text-white" id="book_content_url">borrow</a>
			</div>
		</div>
	</div>
	
	<script>
		const book_image = document.querySelector("#book_image");
		const book_title = document.querySelector("#book_title");
		const book_author = document.querySelector("#book_author");
		const book_description = document.querySelector("#book_description");
		const book_content_url = document.querySelector("#book_content_url");
		
		fetch("/api/books/details?id=<?= $_GET['id'] ?>").then(response => response.json()).then(book => {
			const actual_content_cdn_url = `${location.protocol}//${book.content_cdn_url.replace("{server_addr}", location.host)}`;
			const actual_image_url = `${location.protocol}//${book.image_url.replace("{server_addr}", location.host)}`;

			book_image.src = actual_image_url;
			book_title.innerText = book.title;
			book_author.innerText = `by ${book.author}`;
			book_description.innerText = book.description;
			book_content_url.href = actual_content_cdn_url;
		});
	</script>
</body>
</html>
