# GPRD-proto
This Web app is the prototype for the "GPRD" (aka: Projects Management for Research and Development)
The GPRD is a DataBase application that enable the whole R&D to manage their products their raw material and their components.
```
This app is made in HTML/CSS and with PHP using bootstrap in front-end,
its a MySQL database that's setup using PHPMyAdmin
I used MAMP that run a Apache webserver 
```
https://gprd-proto.herokuapp.com

This App is deployed on Heruko and use ClearDB to connect to the MySQL database.

*** 
to set up the Project:

* Install MAMP
* In the newly created folder MAMP find /MAMP/htdocs and clone this repository in it
* Run the web server with apache and the default ports 80 & 3306
* Find phpmyadmin with the url `http://localhost/phpmyadmin/`
* in the phpmyadmin create a new user 
* create a new database using the name `login_page_test` and use the import option, select the `db.sql`in the clone folder
it will give a fonctionning framework to run the app
* go to `http://localhost/GPRD-proto/`

this Project is just a prototype, is not meant to be used but to give an example of the different things we can do to replace the actual database App.
The file db.sql is not up to date and will need to be corrected so that it can make the app work.
