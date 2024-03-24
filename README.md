# Project Documentation

## Introduction
This document provides an overview of the functionality, architecture, and usage of the Laravel application with PostgreSQL as the database.

## Table of Contents
- [Features](#features)
- [Architecture](#architecture)
- [Redis Integration](#redis-integration)
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
The project follows a modular architecture pattern that consists of the following layers:

1. Repository Layer: Responsible for handling database operations such as querying data, updating records, and performing CRUD operations. The repository abstracts the database interactions and provides a clean interface for accessing and manipulating data without exposing the underlying database details.

2. Service Layer: Contains the business logic of the application. Services encapsulate complex logic and workflows, orchestrate interactions between different components, and implement high-level operations involving multiple repository calls. They process data, enforce business rules, coordinate transactions, and perform other application-specific tasks.

3. Controller Layer: Receives incoming requests from the client, interacts with the service layer to execute business logic, and prepares the response to send back to the client. Controllers handle request parsing, validation, authentication, and authorization. They delegate processing tasks to the service layer and manage the overall flow of the application.

## Redis Integration
The application utilizes Redis as a caching layer to optimize data retrieval and storage for certain operations:

- Hourly Data Load: A cron job runs hourly to fetch data from an external API (https://randomuser.me/api/?results=20) and stores it in Redis. Specifically, the counts of male and female users are stored in Redis, providing fast access to this aggregated data.

- Daily Record Generation: Another cron job executes daily to process the data stored in Redis and calculate aggregate statistics such as male and female counts, as well as average age for each gender. These daily records are then persisted to the PostgreSQL database for historical tracking and reporting.

## Cron Jobs
### First Cron Job
- **Purpose:** Load data from the Random User API hourly.
- **Schedule:** Hourly

### Second Cron Job
- **Purpose:** Generate daily reports to calculate male count, female count, and average age.
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
- Redis

## Demo Link
User Inteface: https://laravel-scheduler.ninedaystech.com/