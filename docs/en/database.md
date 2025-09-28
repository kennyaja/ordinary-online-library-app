# database

the thing that stores data


## tables, fields, and relations

the tables and their fields are defined as such:

|books|users|borrows|
|-|-|-|
|id (int, primary key, not null)|id (int, primary key, not null)|id (int, primary key, not null)|
|title (varchar, not null)|username (varchar, unique, not null)|book_id (int, not null)|
|author (varchar)|password_hash (varchar, not null)|user_id (int, not null)|
|description (text)|email (varchar, not null)|borrowed_at (int)|
|content_cdn_url (varchar, not null)|role (varchar, not null, default 'user')|borrow_deadline (int)|
|image_url (varchar, not null)| |status (varchar, default 'pending')|

<sub>* borrowed_at and borrowed_deadline represents a unix timestamp</sub>


the relation(s) of the tables are defined as such:

- `borrows.book_id` -> `book.id`
- `borrows.user_id` -> `user.id`


diagram for the database (may not be up to date):

<img width="881" height="639" alt="2025-08-27 14:01:31" src="https://github.com/user-attachments/assets/03c7dfa3-4d28-4989-8644-0ebb2d9c2813" />
