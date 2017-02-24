CREATE DATABASE theLibrarian;

CREATE TABLE admin
(
username VARCHAR(30) PRIMARY KEY NOT NULL,
password VARCHAR(255) NOT NULL
);

INSERT INTO admin VALUES ('root','root');

CREATE TABLE users
(
id int PRIMARY KEY NOT NULL,
firstName VARCHAR(30) NOT NULL,
lastName VARCHAR(30) NOT NULL,
email VARCHAR(30) NOT NULL,
telNumber INT NOT NULL,
sex ENUM('M', 'F') NOT NULL,
address VARCHAR(255) NOT NULL,
registrationDate DATE  NOT NULL,
activeUntil DATE NOT NULL
);

INSERT INTO users VALUES (1304321394213,'Antun','Martinovic',0976744106,'M','2017-02-20');

CREATE TABLE genres
(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(30),
UNIQUE(name)
);

INSERT INTO genre (name) VALUES ('Fiction');
INSERT INTO genre (name) VALUES ('Comedy');
INSERT INTO genre (name) VALUES ('Drama');
INSERT INTO genre (name) VALUES ('Horror');
INSERT INTO genre (name) VALUES ('Non-fiction');
INSERT INTO genre (name) VALUES ('Realistic fiction');
INSERT INTO genre (name) VALUES ('Romance novel');
INSERT INTO genre (name) VALUES ('Satire');
INSERT INTO genre (name) VALUES ('Tragedy');
INSERT INTO genre (name) VALUES ('Tragicomedy');
INSERT INTO genre (name) VALUES ('Fantasy');


CREATE TABLE books
(
ISBN int PRIMARY KEY NOT NULL,
title VARCHAR(50) NOT NULL,
year INT NOT NULL,
author VARCHAR(50) NOT NULL,
cover VARCHAR(50) NOT NULL,
createdDate DATE NOT NULL
);

CREATE TABLE booksGenre
(
book_isbn INT NOT NULL,
genre_id INT NOT NULL,
UNIQUE(book_isbn,genre_id),
FOREIGN KEY(book_isbn) REFERENCES books(ISBN) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY(genre_id) REFERENCES genre(id) ON DELETE CASCADE ON UPDATE CASCADE
);

SELECT*FROM genre INNER JOIN books INNER JOIN booksGenre
WHERE isbn=ISBN AND id=genre_id AND ISBN=:ISBN;

CREATE TABLE rentBook
(
id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
book_isbn INT NOT NULL,
user_id INT NOT NULL,
date_rented DATE NOT NULL,
date_returned DATE,
email_notified enum ('Y','N') default 'N',
FOREIGN KEY(book_isbn) REFERENCES books(ISBN) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);


SELECT ISBN,title,author,date_rented,email_notified FROM rentBook,books WHERE isbn=book_isbn AND user_id;

SELECT id,name FROM genre WHERE id NOT IN (SELECT genre_id FROM booksGenre WHERE book_isbn=7);

SELECT rentbook.id as rentId, users.id as userId,firstName,lastName,email,ISBN,title,author
FROM users INNER JOIN rentbook INNER JOIN books WHERE book_isbn =ISBN AND user_id = users.id
AND date_returned IS NULL AND DATEDIFF(CURDATE(),date_rented)>15 AND email_notified = 'N';