CREATE TABLE IF NOT EXISTS bookings (
    id SERIAL PRIMARY KEY,
    booking_reference VARCHAR(10) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    checkin_date DATE NOT NULL,
    checkout_date DATE NOT NULL,
    num_guests INTEGER NOT NULL,
    resort_name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);