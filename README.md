Blog System: Final Relase
---------------------------------------------------------------------------------------------------------------------------------------

A PHP & MySQL based blog with user roles (Admin, Editor, User), authentication, CRUD operations, profile management, and responsive UI.

---------------------------------------------------------------------------------------------------------------------------------------

Features
🔑 Authentication (login with username or mobile + password)
👤 Roles: Admin, Editor, User
Admin: Manage all posts & users
Editor: Add/edit/delete own posts (created by Admin)
User: View posts only, manage own account
📂 Account management (update username, name, mobile, password, profile pic)
📝 CRUD operations for posts
🔍 Search & pagination
🔒 Secure with prepared statements, password hashing
🎨 Responsive UI

---------------------------------------------------------------------------------------------------------------------------------------

Deployment (XAMPP):
Install XAMPP and start Apache & MySQL.

Extract Project:
Copy project folder into C:/xampp/htdocs/blog.

Create Database:
Open http://localhost/phpmyadmin/
Create DB blog
Import database.sql (included)
Configure DB
Edit config.php if your MySQL credentials differ.

Login:
Visit http://localhost/Intenship/

---------------------------------------------------------------------------------------------------------------------------------------

Demo Accounts
Admin → SKA / SKA@2026
Editor → Editor1 / Editor@2026
Editor → Editor2 / Editor@2026
User → User1 / User@2026
User → User2 / User@2026

Roles
Admin creates Editors.
Users register themselves.

---------------------------------------------------------------------------------------------------------------------------------------