How To install / Customization

1. Create a database - 'codecms' . You can change this in the system/config/database.php
2. Dump the sql in your newly created database. The SQL dump is found in <root folder>/assets/sql/db.sql
3. Change the setting of your database in <root folder>/<system folder>/codecms/config/database.php
4. *IMPORTANT* Change the 'RewriteBase' in the <root folder> .htaccess to your root folder name. (if you have http://example.com, root folder name is 'example')
5. Login url for the admin area is at http://yourwebsite.com/admin
6. Default user is "John Doe". Login details are as follows - Email: admin@admin.com Password: 123123
7. *IMPORTANT* Change the email value for the contact page with your email in the <system folder>/codecms/controllers/contact @ Line 70
8. If you want to change the limit of the posts being displayed in the homepage, change the limit value in <system folder>/codecms/controllers/frontController @ Line 99


Upcoming functionality (Todo List):
1. Settings page.
	1.1 Theme to be used.
2. Post Categories and Taxonomies.
3. Page Navigation Menu

**** IMPORTANT ****

USE ONLY THE STABLE VERSION

**** IMPORTANT ****