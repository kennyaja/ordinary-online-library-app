# database

sesuatu yang menyimpan data


## tabel, fields, dan relasi

tabel dan fieldnya didefinisikan sebagai berikut:

|books|users|
|-|-|
|id (int, primary key, not null)|id (int, primary key, not null)|
|title (varchar, not null)|username (varchar, not null)|
|author (varchar)|password_hash (varchar, not null)|
|description (text)|email (varchar, not null)|
|content_cdn_url (varchar, not null)|role (varchar, not null)|
|image_url (varchar, not null)|
|borrowed_by (int)|
|borrowed_at (timestamp)|


relasi tabel didefinisikan sebagai berikut:

- `books.borrowed_by` -> `users.id`


diagram untuk database (mungkin belum diperbarui):

<img width="881" height="639" alt="2025-08-27 14:01:31" src="https://github.com/user-attachments/assets/03c7dfa3-4d28-4989-8644-0ebb2d9c2813" />
