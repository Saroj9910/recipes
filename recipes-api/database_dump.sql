-- database_dump.sql

CREATE DATABASE recipes_db;

USE recipes_db;

CREATE TABLE recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    ingredients TEXT NOT NULL,
    instructions TEXT NOT NULL,
    prep_time INT,               -- Optional: preparation time in minutes
    difficulty INT,              -- Optional: difficulty level (1-3)
    vegetarian BOOLEAN DEFAULT 0, -- Optional: whether the recipe is vegetarian
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE recipes ADD COLUMN rating INT DEFAULT 0;
ALTER TABLE recipes ADD COLUMN user_id INT;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Store hashed passwords
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
