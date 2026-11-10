CREATE DATABASE IF NOT EXISTS qazaq_literature CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE qazaq_literature;
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS favorites; DROP TABLE IF EXISTS books; DROP TABLE IF EXISTS users; DROP TABLE IF EXISTS authors; DROP TABLE IF EXISTS categories;
SET FOREIGN_KEY_CHECKS=1;
CREATE TABLE authors(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(150) NOT NULL,biography TEXT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE categories(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE users(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100) NOT NULL,email VARCHAR(150) NOT NULL UNIQUE,password VARCHAR(255) NOT NULL,created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE books(id INT AUTO_INCREMENT PRIMARY KEY,title VARCHAR(200) NOT NULL,author_id INT NULL,category_id INT NULL,description TEXT NULL,published_year INT NULL,INDEX(author_id),INDEX(category_id),INDEX(published_year),CONSTRAINT books_author_fk FOREIGN KEY(author_id) REFERENCES authors(id) ON DELETE SET NULL,CONSTRAINT books_category_fk FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE SET NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE favorites(id INT AUTO_INCREMENT PRIMARY KEY,user_id INT NOT NULL,book_id INT NOT NULL,UNIQUE KEY user_book_unique(user_id,book_id),INDEX(book_id),CONSTRAINT favorites_user_fk FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,CONSTRAINT favorites_book_fk FOREIGN KEY(book_id) REFERENCES books(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO authors(id,name,biography) VALUES (1,'Мұхтар Әуезов','Қазақ әдебиетінің көрнекті жазушысы.'),(2,'Абай Құнанбайұлы','Ұлы ақын, ойшыл және ағартушы.'),(3,'Міржақып Дулатұлы','Ақын, жазушы және қоғам қайраткері.'),(4,'Бауыржан Момышұлы','Жазушы, әскери қайраткер.'),(5,'Бердібек Соқпақбаев','Қазақ балалар әдебиетінің көрнекті жазушысы.');
INSERT INTO categories(id,name) VALUES (1,'Роман-эпопея'),(2,'Философиялық проза'),(3,'Роман'),(4,'Мемуар');
INSERT INTO books(id,title,author_id,category_id,description,published_year) VALUES (1,'Абай жолы (жаңартылған)',1,1,'Қазақ халқының тұрмыс-тіршілігі мен Абайдың өмір жолын суреттейтін шығарма.',1942),(2,'Қара сөздер',2,2,'Адамгершілік, білім, ғылым және тәрбие туралы философиялық ойлар.',1890),(3,'Бақытсыз Жамал',3,3,'Қазақ әдебиетіндегі алғашқы романдардың бірі.',1910),(4,'Ұшқан ұя',4,4,'Отбасы тәрбиесі мен балалық шақ естеліктері туралы шығарма.',1975);
-- Қауіпсіздік үшін жаңа аккаунтты сайттың тіркелу формасы арқылы жасаңыз.
