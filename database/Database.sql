CREATE TABLE users (

id INT PRIMARY KEY AUTO_INCREMENT,

email VARCHAR(100) UNIQUE NOT NULL,

password_hash VARCHAR(255) NOT NULL,

name VARCHAR(100),

total_points INT DEFAULT 0,

createdat TIMESTAMP DEFAULT CURRENTTIMESTAMP

);

CREATE TABLE points_transactions (

id INT PRIMARY KEY AUTO_INCREMENT,

user_id INT NOT NULL,

type ENUM('earned', 'redeemed', 'expired') NOT NULL,

amount INT NOT NULL,

description VARCHAR(255),

balance_after INT NOT NULL,

createdat TIMESTAMP DEFAULT CURRENTTIMESTAMP,

FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE

);

CREATE TABLE rewards (

id INT PRIMARY KEY AUTO_INCREMENT,

name VARCHAR(100) NOT NULL,

points_required INT NOT NULL,

description TEXT,

stock INT DEFAULT -1 -- -1 = unlimited

);


INSERT INTO users (email, password_hash, name, total_points)
VALUES
('alice@example.com', '$2y$10$hashedpassword1', 'Alice', 120),
('bob@example.com',   '$2y$10$hashedpassword2', 'Bob',   50),
('charlie@example.com', '$2y$10$hashedpassword3', 'Charlie', 0);

INSERT INTO points_transactions 
(user_id, type, amount, description, balance_after)
VALUES
(1, 'earned',   100, 'Inscription bonus', 100),
(1, 'earned',    20, 'Achat produit',     120),
(2, 'earned',    50, 'Parrainage',         50),
(1, 'redeemed',  30, 'Bon de réduction',   90);

INSERT INTO rewards (name, points_required, description, stock)
VALUES
('Bon de réduction 10%', 100, 'Réduction de 10% sur votre commande', 50),
('Café gratuit', 30, 'Un café offert', -1),
('T-shirt', 200, 'T-shirt officiel', 10);