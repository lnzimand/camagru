# Project Name
#### Camagru
******************************************************************************************
## Objective
Create an image sharing application similar to Instagram
******************************************************************************************
## Requirements
- PHP
- MySQL
- Webserver : 
              Apache
              / Nginx
              / Or built-in webserver
- JavaScript

## Installation
#### Copy source code to your current working environment
- git clone https://github.com/lnzimand/camagru
#### Setup & configuring mysql database and webserver
###### Platform Linux (Ubuntu 20.04)
- https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-20-04
#### Running the program
- If the previous step is done then head over to http://server_domain_or_IP
## General Instructions
- Your web application must produce no errors, no warning or log line in any console,
server side and client side. Nonetheless, due to the lack of HTTPS, any error related
to getUserMedia() are tolerated.
- You must use ony PHP language to create your server-side application, with just
the standard library.
- Client-side, your pages must use HTML, CSS and JavaScript.
- Every framework, micro-framework or library that you don’t create are totally
forbidden, except for CSS frameworks that doesn’t need forbidden JavaScript.
- You must use the PDO abstraction driver to communicate with your database,
that must be queryable with SQL. The error mode of this driver must be set to
PDO::ERRMODE_EXCEPTION
- Your application must be free of any security leak. You must handle at least cases
mentioned in the mandatory part. Nonetheless, you are encouraged to go deeper
into your application’s safety, think about your data’s privacy !
- You are free to use any webserver you want, like Apache, Nginx or even the built-in
webserver 1 .
- Your web application should be at least be compatible with Firefox (>= 41) and
Chrome (>= 46).
