# CRUD-Function-PHP
CRUD Functionality in PHP with both Server side and client side validation with complete guide

## What is CRUD

CRUD is an acronym for Create, Read, Update, and Delete. CRUD operations are basic data
manipulation for database. We've already learned how to perform create (i.e. insert), read 
(i.e. select), update and delete operations in previous chapters. In this tutorial we'll 
create a simple PHP application to perform all these operations on a MySQL database table 
at one place.


## STEP - 1

Well, let's start by creating the table which we'll use in all of our example.

Creating the Database Table in the Mysql database (open xampp server and start apache and mysql
server and then click on admin which is located right on mysql on xampp server  from there you can 
directly create a table or you can you the commands which is given below

Execute the following SQL query to create a table named clients inside your MySQL 
database. We will use this table for all of our future operations.

Example


          CREATE TABLE clients (
              id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
              fname VARCHAR(100) NOT NULL,
              lname VARCHAR(100) NOT NULL,
              email VARCHAR(100) NOT NULL,
              cemail VARCHAR(100) NOT NULL,
              password VARCHAR(100) NOT NULL,
              gender VARCHAR(100) NOT NULL,
          );


Why i need to make database table by myself? =because before creating this project at first
i have created database table according to this projects needs. So now when u will copy 
this code it will not directly run on your computer means you can't see any data in your 
database because before that you need to make database table.


Note: if you didn't understand the process yet then you can watch video on youtube for 
creating table in mysql .

Make sure your table name should be "clients" otherwise the program will not work.


## STEP - 2

How to use this code on your projects


Download the whole files which is added in repository  then creare a folder and put all the
files inside that and make sure the folder you have created that is inside the  "C:\xampp\htdocs". 


## STEP-3
				       
				       
When above 2 steps have completed after that start your xampp server and start apache and mysql
server if you have not start that yet and then navigate to your browser and type in "localhost/index.php/".
and there you will be able to view output like this....





# Note: If you are getting any issue feel free to contact me. My email is already given on my github profile or  you can also contact me via linkedin which link is also provided in my profile.





