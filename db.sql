CREATE SCHEMA IF NOT EXISTS user_management;

CREATE TABLE IF NOT EXISTS user_management.roles (
    id SERIAL PRIMARY KEY,
    role_name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS user_management.permissions (
    id SERIAL PRIMARY KEY,
    permission_name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS user_management.users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INTEGER,
    FOREIGN KEY (role_id) REFERENCES user_management.roles(id)
);

CREATE TABLE IF NOT EXISTS user_management.role_permissions (
    role_id INTEGER,
    permission_id INTEGER,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES user_management.roles(id),
    FOREIGN KEY (permission_id) REFERENCES user_management.permissions(id)
);

INSERT INTO user_management.roles (id, role_name) VALUES 
    (1, 'Admin'), 
    (2, 'User'), 
    (3, 'Guest');

INSERT INTO user_management.permissions (id, permission_name) VALUES 
    (1, 'manage_users'), 
    (2, 'edit_profile'), 
    (3, 'view_dashboard');

INSERT INTO user_management.role_permissions (role_id, permission_id) VALUES 
    (1, 1), (1, 2), (1, 3),
    (2, 2), (2, 3),
    (3, 3);

ALTER SEQUENCE user_management.roles_id_seq RESTART WITH 4;
ALTER SEQUENCE user_management.permissions_id_seq RESTART WITH 4;

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_reference VARCHAR(10) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    checkin_date DATE NOT NULL,
    checkout_date DATE NOT NULL,
    num_guests INT NOT NULL,
    accommodation_name VARCHAR(100) NOT NULL,
    accommodation_location VARCHAR(100) NOT NULL,
    special_requests TEXT,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'confirmed'
);