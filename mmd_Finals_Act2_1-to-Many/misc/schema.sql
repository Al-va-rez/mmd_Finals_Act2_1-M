CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR (50),
    first_Name VARCHAR (50),
    last_Name VARCHAR (50),
    home_address VARCHAR (50),
    contact_Num VARCHAR (50),
    added_by VARCHAR (50),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by VARCHAR (50),
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    order_Name VARCHAR (50),
    order_Quantity INT,
    order_Price FLOAT,
    added_by VARCHAR (50),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by VARCHAR (50),
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE user_credentials (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR (50),
    password VARCHAR (1024),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE delete_logs (
    del_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    order_id INT,
    deleted_by VARCHAR (50),
    time_deleted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);