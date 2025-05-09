# We Are Billionaire

An experimental financial management platform featuring role-based access for administrators and users.

## 🚀 Project Overview
"We Are Billionaire" is designed for a financial organization, providing separate authentication and dashboards for Admins and Users. All dashboard functionalities are dynamically managed through the database, enabling flexible updates without modifying the code.

## 🛠️ Tech Stack
- **Frontend:** HTML, CSS, JavaScript
- **Backend:** Laravel (PHP Framework)
- **Database:** MySQL

## ✨ Key Features
- Separate login systems for Admin and User roles
- Individual dashboards for Admins and Users
- Database-driven functionality management
- Secure role-based access control

## 📦 Installation


### Clone the repository
git clone https://github.com/your-username/we-are-billionaire.git

### Navigate into the project directory
cd we-are-billionaire

### Install dependencies
composer install

### Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

### Set up your database in the .env file, then run migrations
php artisan migrate


## 📸 Screenshots

<picture>
  <source srcset="screenshot/admin-login.png" media="(min-width: 800px)">
    <img src="path-to-your-image-fallback.jpg" alt="Fallback image">
</picture>

<picture>
  <source srcset="screenshot/admin-dashboard.png" media="(min-width: 800px)">
    <img src="path-to-your-image-fallback.jpg" alt="Fallback image">
</picture>

<picture>
  <source srcset="screenshot/user-login.png" media="(min-width: 800px)">
    <img src="path-to-your-image-fallback.jpg" alt="Fallback image">
</picture>

<picture>
  <source srcset="screenshot/user-dashboard.png" media="(min-width: 800px)">
    <img src="path-to-your-image-fallback.jpg" alt="Fallback image">
</picture>











