# Task Management API

## Project Description
This project is a Task Management API built with Laravel. It allows users to log in and manage their tasks, including creating, updating, deleting, and viewing tasks. Users can also filter tasks by status (`pending`, `completed`) or by due date (`due_date`).

---

## Features
- User login using Laravel Sanctum.
- CRUD operations for tasks:
  - Create new tasks.
  - Update existing tasks.
  - Delete tasks.
  - View tasks for the authenticated user only.
- Filter tasks by:
  - **Status**: (Pending, Completed).
  - **Due Date**.

---

## Requirements
Ensure you have the following installed on your system:
- PHP = 8.3
- Composer
- MySQL
- Laravel = 11

---

## Setup Instructions

### 1. Clone the Repository
Clone the project to your local system:
git@github.com:Moataz1121/Nafis-Task.git


---
composer install

---
##.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password


For Mail 

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

--- 
## Generate Application Key
php artisan key:generate

--- 
## Set Admin 
php artisan migrate --seed


