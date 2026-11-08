ERMIE-LITO BATTERY CENTER - PHP LOGIN STARTER
================================================

WHAT'S INCLUDED
- Login page styled to match your Figma screenshot
- MySQL/PDO database connection
- Secure password hashing and password verification
- Session-based login
- Role-based redirect: owner -> owner/dashboard.php, cashier -> cashier/dashboard.php
- Protected owner and cashier placeholder dashboards
- Logout
- One-time first-owner setup page

XAMPP SETUP
1. Start Apache and MySQL in the XAMPP Control Panel.
2. Copy the entire "ermie_lito_pos_login" folder into:
   C:\xampp\htdocs\
3. Open phpMyAdmin:
   http://localhost/phpmyadmin
4. Choose Import, select database.sql from this folder, and click Import.
   (The SQL creates the database and users table.)
5. If your MySQL username/password differs from the XAMPP defaults, edit:
   includes/db.php
6. Open:
   http://localhost/ermie_lito_pos_login/setup_first_owner.php
7. Create your first owner account.
8. IMPORTANT: Delete setup_first_owner.php after the owner account is created.
9. Open:
   http://localhost/ermie_lito_pos_login/login.php
10. Sign in using the owner account you created.

ADDING CASHIER ACCOUNTS
This starter only includes first-owner setup. Add a user-management page in the
owner dashboard to create cashier accounts. When creating a cashier, use:
  password_hash($password, PASSWORD_DEFAULT)
and save role = 'cashier'. Never save plain-text passwords.

CUSTOMIZE
- Change colors, sizing, and layout in assets/style.css.
- The green and red colors, split black/light panels, labels, and form fields
  are based on the screenshot you provided.
- Replace the store name and tagline in login.php if needed.

SECURITY NOTES
- Passwords are stored as password hashes, not plain text.
- SQL uses PDO prepared statements.
- Login regenerates the session ID.
- A CSRF token protects the login form.
- Keep setup_first_owner.php deleted after initial setup.
- For a real public deployment, use HTTPS, configure secure cookies, add login
  rate limiting, backups, and audit logging.
- The dashboard pages are placeholders; the actual sales/POS features are not
  implemented in this login starter.
