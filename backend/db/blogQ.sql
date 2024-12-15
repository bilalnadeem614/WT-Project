create database blog;

use blog;

CREATE TABLE category (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL,
    post INT NOT NULL DEFAULT 0
);
INSERT INTO category (category_name, post) VALUES
('Sports', 0),
('Entertainment', 0),
('Politics', 0),
('Health', 0),
("Worldwide",0);

CREATE TABLE post (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100) NOT NULL,
    post_date VARCHAR(50) NOT NULL,
    author INT NOT NULL,
    post_img VARCHAR(100) NOT NULL
);

ALTER TABLE post ADD COLUMN views INT DEFAULT 0;


INSERT INTO post (title, description, category, post_date, author, post_img) VALUES
('First Post', 'Lorem ipsum dolor sit amet...', '1', '19 Oct, 2024', 1, 'sports1.jpg'),
('Testing Recent Post', 'Suspendisse sed ultrices tortor...', '2', '20 Oct, 2024', 2, 'entertainment2.jpg');



CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    websitename VARCHAR(60) NOT NULL,
    logo VARCHAR(50) NOT NULL,
    footerdesc VARCHAR(255) NOT NULL
);
INSERT INTO settings (websitename, logo, footerdesc) VALUES
('News Hub', 'news.jpg', '© Copyright 2020 News | Powered by <a href="https://www.bbc.com">BBC</a>');

CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    username VARCHAR(30),
    password VARCHAR(40),
    role INT NOT NULL
);
INSERT INTO user (first_name, last_name, username, password, role) VALUES
('Bilal', 'Nadeem', 'bilalnadeem614', 'e093d03307b61cf50a3d5da00cf83ffb', 1),
('Muhammad', 'Zaid', 'zaid123', 'eba8477b0fa0e412433535e8f977b3f7', 1),
('Ali', 'Ahmad', 'ali123', '984d8144fa08bfc637d2825463e184fa', 0);

-- select * from user;

CREATE TABLE saved_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (post_id) REFERENCES post(post_id)
);

-- select * from newsletter_subscribers; 

CREATE TABLE newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


