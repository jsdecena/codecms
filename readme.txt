How To install

1. Create a database - 'codecms' . You can change this in the system/config/database.php
2. Dump the sql in your newly created database. The SQL dump is found in codecms/assets/sql/db.sql
3. Change the setting of your database in system/codecms/config/database.php
4. Login url for the admin area is at http://yourwebsite.com/admin
4. Default user is "John Doe". Login details are as follows - Email: admin@admin.com Password: 123123


Upcoming functionality (Todo List):
1. Batch delete of post/pages.
2. Post/Pages pagination (Backend/Frontend).
3. After page or post created, redirect to edit mode.
4. Settings page.
	4.1 Page to display blogs. ok
	4.2 Number of post to display. ok 
	4.3 Default arrangement by Id or date created. ok
	4.4 Default post order. ok
	4.5 Theme to be used.

Knows bugs:
1. Settings page - after saving the settings, I cannot retrieve the db values inserted for the post page chosen.
2. User Management - an admin can delete his own. Also even when logged in.