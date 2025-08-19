# database

sesuatu yang menyimpan data


## tabel, fields, dan relasi

tabel dan fieldnya didefinisikan sebagai berikut:

|books|users|cashiers|admins|
|-|-|-|-|
|id (int, primary key, not null)|id (int, primary key, not null)|id (int, primary key, not null)|id (int, primary key, not null)|
|title (varchar, not null)|username (varchar, not null)|username (varchar, not null)|username (varchar, not null)|
|author (varchar)|password_hash (varchar, not null)|password_hash (varchar, not null)|password_hash (varchar, not null)|
|description (text)|email (varchar, not null)|
|content_cdn_url (timestamp, not null)|
|borrowed_by (int)|
|borrowed_at (timestamp)|


relasi tabel didefinisikan sebagai berikut:

- `books.borrowed_by` -> `users.id`
