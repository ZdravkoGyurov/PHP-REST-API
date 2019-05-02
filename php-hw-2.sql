DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;
DROP DATABASE IF EXISTS php_hw_2;

CREATE DATABASE php_hw_2 CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE php_hw_2.roles (
	role_id INT NOT NULL AUTO_INCREMENT,
	type VARCHAR(255) NOT NULL UNIQUE,
	PRIMARY KEY (role_id)
);

CREATE TABLE php_hw_2.users (
	user_id INT NOT NULL AUTO_INCREMENT,
	email VARCHAR(255) NOT NULL UNIQUE,
	name VARCHAR(100) CHARACTER SET utf8 NOT NULL,
	surname VARCHAR(100) CHARACTER SET utf8 NOT NULL,
	password VARCHAR(2056) NOT NULL,
	roleId INT NOT NULL,
	PRIMARY KEY (user_id),
	FOREIGN KEY (roleId) REFERENCES roles(role_id)
);

INSERT INTO php_hw_2.roles(type) VALUES('Admin');
INSERT INTO php_hw_2.roles(type) VALUES('User');
INSERT INTO php_hw_2.users(email, name, surname, password, roleId) VALUES('zdravko.gyurov97@gmail.com', N'Здравко', N'Гюров', '$2y$10$LLyr9O/5n9.MJtGYMCltUerYIO8pbfzWYBJxT9EbCnIqF84PIJqLa', '1');