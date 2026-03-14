PROJECT NAME
Energy & Environment Management Web App

AUTHOR
Bosca Cristian Andrei

DESCRIPTION
This project is a web application developed in PHP for managing and monitoring energy and environmental data.
It allows users to store, view and manage information through a simple web interface.
The project was created for educational purposes.

TECHNOLOGIES USED

* PHP
* MySQL
* HTML
* CSS
* JavaScript
* phpMyAdmin
* XAMPP / Local Apache Server

REQUIREMENTS
To run this project you need:

* XAMPP (or another local server with Apache and MySQL)
* phpMyAdmin
* A web browser (Chrome, Edge, Firefox, etc.)

HOW TO RUN THE PROJECT

1. Install XAMPP
   Download and install XAMPP, which includes Apache, MySQL and phpMyAdmin.

2. Start the server
   Open XAMPP Control Panel and start:

* Apache
* MySQL

3. Move the project
   Copy the project folder into the XAMPP "htdocs" directory.

Example path:
xampp/htdocs/project-folder

4. Create the database
   Open phpMyAdmin in your browser:

http://localhost/phpmyadmin

Create a new database for the project.

5. Import the database (if a .sql file exists)

* Select the created database
* Click "Import"
* Upload the .sql file from the project

6. Configure the database connection
   Open the file:

db.php

Modify the database credentials if needed:

host: localhost
user: root
password: (leave empty by default in XAMPP)
database: your_database_name

7. Run the application
   Open your browser and go to:

http://localhost/project-folder

The application should now run locally.

NOTES
This project is intended for learning purposes and demonstrates basic web development using PHP and MySQL.
