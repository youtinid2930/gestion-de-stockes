# Gestion de Stockes

## Description

**Gestion de Stockes** is an inventory management system designed to help businesses track and manage stock, warehouses, and supply chains efficiently. The system allows users to handle stock requests, supplier orders, and depot management with ease. It includes features such as user roles, inventory tracking, and report generation.

## Installation Instructions

1. Clone the Project
   git clone https://github.com/youtinid2930/gestion-de-stockes.git

2. Install Composer Dependencies
   composer install

3. Install NPM Dependencies
   npm install

4. Create the Database
   In phpMyAdmin, create a new database.

5. Run Migrations
   php artisan migrate

6. Seed the Database
   php artisan db:seed

7. Insert a Depot
   In phpMyAdmin, navigate to your database, open the depots table, and manually insert a record with:
   - name: the name of the depot
   - adresse: the address of the depot
   - type: "Dépôt central"

8. Compile Assets
   npm run dev

9. Start the Application
   php artisan serve

10. Register a User
    Visit http://127.0.0.1:8000/register and fill in the registration form with:
    - First Name
    - Last Name
    - Email
    - Password

    Alternatively, if you're using XAMPP, navigate to:
    localhost/gestion-de-stockes/public/register
