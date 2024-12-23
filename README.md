<h1 align="center" style="color: #0bb07b">Application Installation Process</h1>

## Table of Contents
- [Introduction](#introduction)
- [Prerequisites](#prerequisites)
- [Installation](#installation)

## Introduction
This document provides the installation process for the application.

## Prerequisites
Before you begin, ensure you have met the following requirements:
- You have installed the latest version of PHP.
- You have installed the latest version of Composer.
- You have installed the latest version of MySQL.

## Installation
For the installation of the application, follow the steps below:

1. Clone the repository:
    ```bash
    git clone https://github.com/tusharkhan/Task-Management.git
    ```
   
2. Change the directory:
    ```bash
    cd Task-Management
    ```
   
3. Install the dependencies:
    ```bash
    composer install
    ```
   
4. Create a copy of the `.env` file:
    ```bash
    cp .env.example .env
    ```
   
5. Install the application:
    ```bash
    php artisan app:install
    ```
