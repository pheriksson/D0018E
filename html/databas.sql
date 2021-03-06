CREATE TABLE users (
  id int PRIMARY KEY AUTO_INCREMENT,
  first_name varchar(255),
  last_name varchar(255),
  email varchar(255),
  sex varchar(255),
  p_nmb varchar(255),
  password varchar(255),
  created_at timestamp,
  adress varchar(255),
  city varchar(255),
  zip_code int,
  country varchar(255),
  role int,
  credit_card int
);

CREATE TRIGGER avoid_empty
  BEFORE INSERT ON users
    FOR EACH ROW
    BEGIN
    IF first_name = '' THEN SET first_name = NULL END IF;
    IF p_nmb = '' THEN SET p_numb = NULL END IF;

END;

CREATE TABLE sex (
  gender varchar(255)
);



CREATE TABLE products (
  id int PRIMARY KEY,
  name varchar(30) UNIQUE NOT NULL,
  stock int NOT NULL,
  cost_unit int
);


CREATE TABLE cart_items (
  user_id int,
  product_id int,
  amount int,
  PRIMARY KEY (user_id, product_id),
  CONSTRAINT fk_cart_items_users FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT fk_cart_items_products FOREIGN KEY (product_id)
  REFERENCES products(id)
);

CREATE TABLE orders (
  id int PRIMARY KEY AUTO_INCREMENT,
  user_id int,
  created_at timestamp,
  order_sent boolean,
  CONSTRAINT fk_orders_users FOREIGN KEY (user_id) REFERENCES users(id)
);


CREATE TABLE order_items (
  order_id int,
  product_id int,
  user_id int,
  amount int,
  cost_snapshot int,
  active int(1) DEFAULT 1,
  PRIMARY KEY (order_id, product_id, user_id),
  CONSTRAINT fk_order_items_orders FOREIGN KEY (order_id) REFERENCES orders(id),
  CONSTRAINT fk_order_items_products FOREIGN KEY (product_id)
  REFERENCES products(id),
  CONSTRAINT fk_order_items_users FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE rating(
	id int PRIMARY KEY AUTO_INCREMENT,
	user_id int,
	product_id int,
	score int(1) NOT NULL,
	comment varchar(70),
	CONSTRAINT FK_RATING_USER FOREIGN KEY (user_id) REFERENCES users(id),
	CONSTRAINT FK_RATING_PRODUCT FOREIGN KEY (product_id) REFERENCES products(id)
);
