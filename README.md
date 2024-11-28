<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel CRUD API with Sanctum

This is a CRUD API project built using Laravel and Sanctum for authentication. It provides user authentication (registration and login) and CRUD operations for tasks. The project uses PostgreSQL as the database.

## Features

- User registration and login with Laravel Sanctum.
- CRUD operations for tasks (Create, Read, Update, Delete).
- Protected routes for task operations with Sanctum authentication.

## Prerequisites

Make sure the following are installed on your system:

- PHP 8.1 or higher
- Composer
- PostgreSQL
- Laravel CLI
- Git (optional)

## Installation

Follow these steps to set up the project on a new device.

### 1. Clone the Repository

Clone this repository to your local machine:

```bash
git clone <repository-url>
cd laravel-crud-api
```

### 2. Install Dependencies

Run the following command to install PHP dependencies:

```bash
composer install
```

### 3. Environment Configuration

Duplicate the .env.example file and rename it to .env:

```bash
cp .env.example .env
```

Edit the .env file to configure your database connection. Update these lines with your PostgreSQL credentials:

```env
DB_CONNECTION=pgsql
DB_HOST=<your-db-hostname>
DB_PORT=5432
DB_DATABASE=<your-database-name>
DB_USERNAME=<your-database-username>
DB_PASSWORD=<your-database-password>
```

### 4. Generate Application Key

Generate an application key for the Laravel project:

```bash
php artisan key:generate
```

### 5. Run Database Migrations
Run the database migrations to create the required tables:

```bash
php artisan migrate
```

### 6. Serve the Application
Start the Laravel development server:

```bash
php artisan serve
```

The application will be available at http://127.0.0.1:8000.

