CREATE TABLE rating(
	id int PRIMARY KEY AUTO_INCREMENT,
	user_id int,
	product_id int,
	score int(1) NOT NULL,
	comment varchar(70),
	CONSTRAINT FK_RATING_USER FOREIGN KEY (user_id) REFERENCES users(id),
	CONSTRAINT FK_RATING_PRODUCT FOREIGN KEY (product_id) REFERENCES products(id)
);
