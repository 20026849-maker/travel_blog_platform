# Travel Blogging & Review Platform (ICT726)

## Project Overview
This project is a dynamic, data-driven Travel Blogging and Review Platform developed for ICT726 Web Development. The system allows users to register/login, create travel blog posts, view blog content, and submit ratings/reviews. An admin role is included to support access control and content moderation.

## Technologies Used
- PHP (server-side scripting)
- MySQL (database)
- HTML / CSS (UI design)
- XAMPP (Apache + MySQL local server)

## How to Run (Localhost)
1. Copy the project folder into:
   C:\xampp\htdocs\travel_blog_platform

2. Open **XAMPP Control Panel** and start:
   - Apache
   - MySQL

3. Import the database:
   - Open phpMyAdmin: http://localhost/phpmyadmin
   - Create database: `travel_blog_db`
   - Click **Import**
   - Select: `sql/travel_blog_db.sql`
   - Click **Go**

4. Open the website:
   - Login page: http://localhost/travel_blog_platform/pages/login.php

## Main Features
- User registration & login (session-based authentication)
- Role-based access control (admin vs user)
- Blog post management (create/view)
- Reviews and ratings linked to posts
- Input validation & error handling
- SEO support: meta tags, robots.txt, sitemap.xml
- Privacy Policy page

## Admin Access
Admin role is stored in the database (phpMyAdmin users table).  
An admin dashboard is available for moderation and access control features.

## Group Members
- Swati Bhardwaj (Team Leader)
- Binaya
- Karan
