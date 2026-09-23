CONTACT LIST WEB APPLICATION (PHP + MySQL)
=============================================

REQUIREMENTS
-------------
- XAMPP (with Apache and MySQL)


SETUP INSTRUCTIONS
-------------------

1. Copy the project folder
   Copy the entire "contact-list-php" folder into your XAMPP "htdocs" directory.

   Example locations:
   - Windows: C:\xampp\htdocs\contact-list-php
   - Mac:     /Applications/XAMPP/htdocs/contact-list-php
   - Linux:   /opt/lampp/htdocs/contact-list-php

2. Start XAMPP
   Open the XAMPP Control Panel and click "Start" for:
   - Apache
   - MySQL

3. Create the database
   - Open your browser and go to: http://localhost/phpmyadmin
   - Click the "Import" tab at the top.
   - Click "Choose File" and select "database.sql" (included in this project folder).
   - Click "Go" at the bottom.
   - This will create the "contact_list_db" database and the "contacts" table automatically.

4. Check the database connection settings (usually no changes needed)
   Open "db.php" and confirm these match your XAMPP setup (default XAMPP values shown):

       $db_host = "localhost";
       $db_user = "root";
       $db_pass = "";
       $db_name = "contact_list_db";

   These are the default XAMPP MySQL credentials, so most users will not need to change anything.

5. Run the application
   Open your browser and go to:

       http://localhost/contact-list-php/index.php


HOW TO USE
-----------
- Add Contact: Fill out the form at the top of the page and click "Add Contact".
- Edit Contact: Click the "Edit" button next to any contact, update the fields, and click "Save Changes".
- Delete Contact: Click the "Delete" button next to any contact (a confirmation popup will appear).
- Contacts are automatically sorted alphabetically by Last Name.


VALIDATION RULES
------------------
- All fields (Last Name, First Name, Email, Contact Number) are required.
- Last Name: max 50 characters
- First Name: max 50 characters
- Email Address: max 50 characters, must be a valid email format, must be unique (no duplicates)
- Contact Number: max 15 characters, digits only


PROJECT FILES
---------------
- database.sql          -> Creates the database and contacts table (import this first)
- db.php                -> Database connection settings
- index.php             -> Main page (add form + contacts table)
- edit.php              -> Edit form for a single contact
- add_contact.php       -> Server-side logic for adding a contact
- update_contact.php    -> Server-side logic for updating a contact
- delete_contact.php    -> Server-side logic for deleting a contact
- validate.php          -> Shared validation rules used by add/update
- style.css             -> Styling for the app
