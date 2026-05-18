/*
|--------------------------------------------------------------------------
| DATABASE
|--------------------------------------------------------------------------
*/

CREATE DATABASE daily_istory
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE daily_istory;





/*
|--------------------------------------------------------------------------
| USERS TABLE
|--------------------------------------------------------------------------
*/

CREATE TABLE users (

    id INT AUTO_INCREMENT PRIMARY KEY,

    fullname VARCHAR(100)
    NOT NULL,

    username VARCHAR(50)
    NOT NULL UNIQUE,

    password VARCHAR(255)
    NOT NULL,

    role ENUM(
        'user',
        'admin'
    )
    DEFAULT 'user',

    status ENUM(
        'active',
        'blocked'
    )
    DEFAULT 'active',

    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP

);





/*
|--------------------------------------------------------------------------
| PLANS TABLE
|--------------------------------------------------------------------------
*/

CREATE TABLE plans (

    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT
    NOT NULL,

    title VARCHAR(255)
    NOT NULL,

    description TEXT,

    plan_date DATE
    NOT NULL,

    plan_time TIME
    NOT NULL,

    status ENUM(
        'pending',
        'completed',
        'missed'
    )
    DEFAULT 'pending',

    comment TEXT,

    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE

);
