CREATE DATABASE IF NOT EXISTS ermie_lito_pos
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE ermie_lito_pos;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('owner', 'cashier') NOT NULL DEFAULT 'cashier',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_login DATETIME NULL
);
