Lighthouse IMS 2600

Inventory Management System

Project Status: In Progress | Personal Project | Not Yet in Production

Lighthouse IMS 2600 is a personal project focused on developing a web-based Inventory Management System using Laravel, Tailwind CSS, and SQLite.

The project is an opportunity to apply my full-stack development experience, strengthen my Laravel skills, and explore practical approaches to building business-oriented applications.

Project Overview

The goal of this project is to develop an organized and maintainable inventory management application that can support common inventory-related operations.

Development is ongoing, and features and improvements are being implemented progressively.

Technology Stack

Backend: PHP / Laravel

Frontend: HTML, JavaScript, Tailwind CSS

Database: SQLite

Architecture: MVC (Model-View-Controller)

Dependency Management: Composer and npm

Project Goals

Develop a structured inventory management application.

Implement CRUD operations for inventory records.

Apply MVC principles and maintainable coding practices.

Integrate database operations using SQLite.

Build a responsive user interface using Tailwind CSS.

Continuously improve functionality and application structure.

Project Status

This is an independent personal development project and is currently under active development.

Please note:

Not yet deployed in a production environment.

Features and functionality may change as development progresses.

Intended for development, learning, and portfolio demonstration purposes.

Installation and Setup

Prerequisites

PHP (compatible with the project's Laravel version)

Composer

Node.js and npm

1. Clone the repository

git clone https://github.com/mrfluidz/lighthouseIMS_2600.git
cd lighthouseIMS_2600

2. Install PHP dependencies

composer install

3. Configure environment

cp .env.example .env
php artisan key:generate

4. Configure SQLite

Create the SQLite database file if it does not exist:

touch database/database.sqlite

Make sure your .env contains:

DB_CONNECTION=sqlite

5. Run database migrations

php artisan migrate

6. Install frontend dependencies

npm install
npm run build

7. Start the development server

php artisan serve

Open the application at:

http://127.0.0.1:8000

Note: Installation steps may require adjustments depending on the project's actual configuration, Laravel version, migrations, and frontend setup.

Author

Floyd Derek Rillera

GitHub: https://github.com/mrfluidz

This project is independently developed and maintained as part of my continuous learning and software development portfolio.
