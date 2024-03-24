# Project Documentation

## Introduction
This document provides an overview of the functionality, architecture, and usage of the Laravel application with PostgreSQL as the database.

## Table of Contents
- [Features](#features)
- [Architecture](#architecture)
- [Cron Jobs](#cron-jobs)
- [User Interface](#user-interface)
- [Usage](#usage)
- [Dependencies](#dependencies)
- [DemoLink](#demo-link)

## Features
- Load data from the [Random User API](https://randomuser.me/api/?results=20) hourly.
- Generate daily reports to calculate male count, female count, and average age.
- User interface to view user data and reports.

## Architecture
The application is built using the Laravel PHP framework. It follows the MVC (Model-View-Controller) architecture pattern.

## Cron Jobs
### First Cron Job
- **Purpose:** Load data from the Random User API hourly.
- **Endpoint:** `/load-users`
- **Schedule:** Hourly

### Second Cron Job
- **Purpose:** Generate daily reports to calculate male count, female count, and average age.
- **Endpoint:** `/generate-daily-report`
- **Schedule:** Daily

## User Interface
The user interface consists of two main sections:
1. **User Data:** Allows users to view data retrieved from the Random User API.
2. **Reports:** Displays daily reports showing the male count, female count, and average age.

## Usage
To use the application, follow these steps:
1. Clone the repository: `git clone <repository-url>`
2. Install dependencies: `composer install`
3. Set up database configuration: Copy `.env.example` to `.env` and configure your PostgreSQL database settings.
4. Run migrations: `php artisan migrate`
5. Set up cron jobs to run the scheduled tasks: `php artisan schedule:run`

## Dependencies
- Laravel framework
- Guzzle HTTP client for making API requests
- PostgreSQL database

## Demo Link
User Inteface: https://laravel-scheduler.ninedaystech.com/