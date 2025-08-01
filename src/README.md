## Healthcare Appointment Booking API

A RESTful API built with Laravel and MySQL to manage healthcare appointment bookings.
It supports user authentication, appointment scheduling, cancellation, and listing of healthcare professionals.



## Features

- User Registration and Login (Token-based with Laravel Sanctum)
- View all Healthcare Professionals
- Book Appointments (with availability checks)
- View All Appointments
- View User’s Appointments
- Cancel Appointments 
- Mark Appointments as Completed 

## Technology Stack

- **Framework:** Laravel 10+
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **Language:** PHP 8+


## Getting Started

PostMan Collection : https://documenter.getpostman.com/view/47168823/2sB3B8qYKK#815ca56c-74c9-450b-a576-8b2d82a4fb73

## Project Setup with Docker

1. Clone the Repository
   git clone https://github.com/visionedix/Healthcare-Appointment-Booking.git
   cd Healthcare-Appointment-Booking

2. Install Docker Desktop
   
3. Config For Docker 
   Create database Folder inside Healthcare-Appointment-Booking
   
   cp docker-compose.example docker-compose.yml
   cp .env.example .env inside src folder

4. Run Docker File 
   sudo docker compose up --build -d
   
   sudo docker compose exec php php artisan migrate

5. Generate App Key
   sudo docker compose exec php php artisan key:generate

6. Run Migrations and Seeders
   sudo docker compose exec php php artisan migrate



## Project Setup without Docker

1. Clone the Repository
   git clone https://github.com/visionedix/Healthcare-Appointment-Booking.git
   cd Healthcare-Appointment-Booking/src

2. Install Composer
   composer install

3. Create .env File
   cp .env.example .env

4. Generate App Key
   php artisan key:generate

5. Run Migrations and Seeders
   php artisan migrate --seed

6. Start the Development Server
   php artisan serve