# Delivery-3
Car Sales System
Project Overview
This is a simple car sales website developed with native PHP and MySQL. The system allows sellers to register accounts, log in, publish car information with images, and search for vehicles. It provides a basic and complete data management process for a car trading platform.
Technology Stack
Frontend: HTML, CSS
Backend: PHP
Database: MySQL
Development Tool: XAMPP
Database Structure
The system contains two main data tables:
1. sellers table
Store seller personal information and login credentials. Passwords are stored in encrypted form.
2. cars table
Store vehicle information, including model, year, price, color, location and car image. Each car is associated with one seller by seller_id.
Core Functions
Seller Registration: New sellers can register an account. The system checks duplicate usernames and emails.
Seller Login & Logout: Verify account information through session. Unauthorized users cannot access the publish page.
Add Car Information: Logged-in sellers can upload car images and publish vehicle data to the database.
Car Search Function: Users can filter cars by model and production year.
User Session Display: Show welcome username on the navigation bar after successful login.
Installation & Usage
Place all project files in the XAMPP htdocs folder.
Create a MySQL database named car_sales.
Import the two data tables (sellers, cars).
Start Apache and MySQL in XAMPP.
Access the website through localhost.