How To install

1. Create a database - 'codecms' . You can change this in the system/config/database.php
2. Dump the sql in your newly created database. The SQL dump is found in codecms/assets/sql/db.sql
3. Change the setting of your database in system/codecms/config/database.php
4. Change the 'RewriteBase' in the <root folder> .htaccess to your root folder name. *IMPORTANT* (if you have www.example.com, root folder name is 'example')
5. Login url for the admin area is at http://yourwebsite.com/admin
6. Default user is "John Doe". Login details are as follows - Email: admin@admin.com Password: 123123


Upcoming functionality (Todo List):
1. Post/Pages pagination (Backend/Frontend).
2. Settings page.
	2.1 Theme to be used.
3. Post Categories and Taxonomies.

Knows bugs:
1. User Management - an admin can delete his own account. Also even when logged in.