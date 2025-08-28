<?= $_SESSION["username"] ?? "log in buddy" ?> (<?= $_SESSION["user_role"] ?? "" ?>)
<a href="/api/logout" class="text-blue-500">log out</a>
