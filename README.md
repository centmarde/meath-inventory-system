# Meat Inventory System

## Overview
The Meat Inventory System is a simple web application designed to manage an inventory of meats including pig, chicken, and beef. It features user authentication, a basic CRUD (Create, Read, Update, Delete) system for inventory management, and is built using PHP with an SQLite database.

## Features
- User authentication with login and logout functionality.
- CRUD operations for managing inventory items.
- Simple and intuitive user interface.
- SQLite database for data storage.

## Project Structure
```
meat-inventory-system
├── config
│   └── database.php
├── public
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── dashboard.php
│   └── css
│       └── style.css
├── src
│   ├── auth
│   │   └── AuthController.php
│   ├── controllers
│   │   └── InventoryController.php
│   ├── models
│   │   ├── User.php
│   │   └── Inventory.php
│   └── database
│       └── init.php
├── views
│   ├── login.php
│   ├── dashboard.php
│   ├── inventory
│   │   ├── list.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   └── partials
│       ├── header.php
│       └── footer.php
├── database
│   └── inventory.db
└── README.md
```

## Setup Instructions
1. Clone the repository to your local machine.
2. Navigate to the project directory.
3. Ensure you have PHP and SQLite installed on your server.
4. Configure the database connection in `config/database.php`.
5. Run the database initialization script located in `src/database/init.php` to create the necessary tables.
6. Access the application through your web server by navigating to `public/index.php`.

## Usage
- Visit the login page to authenticate.
- Once logged in, you can access the dashboard to view and manage the inventory.
- Use the inventory management features to create, edit, or delete inventory items.

## Security Note
This project intentionally includes security vulnerabilities for pentesting practice. It is not recommended for production use without addressing these vulnerabilities.
