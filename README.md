# TIQ Quiz App

## About
TIQ Quiz App is an interactive learning platform that offers engaging quizzes based on the Quran. Designed to promote religious education through technology, our app provides a user-friendly experience with daily reminders and progress tracking.

## Features
- User Registration & Login
- Quiz Selection
- Daily Reminders
- Progress Tracking
- Admin Panel for Quiz Management


## Getting Started
Clone the repository and follow these steps:

```bash
# Install dependencies
composer install

# Create .env file
cp .env.example .env

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed the database
php artisan db:seed

# Serve the application
php artisan serve
