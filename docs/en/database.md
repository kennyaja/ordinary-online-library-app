# database

the thing that stores data


## tables, fields, and relations

the tables and their fields are defined as such:

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

the relation(s) of the tables are defined as such:

- `books.borrowed_by` -> `users.id`


diagram for the database (may not be up to date):

<img width="881" height="639" alt="2025-08-27 14:01:31" src="https://github.com/user-attachments/assets/03c7dfa3-4d28-4989-8644-0ebb2d9c2813" />
