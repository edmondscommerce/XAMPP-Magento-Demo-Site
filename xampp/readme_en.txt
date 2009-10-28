###### ApacheFriends XAMPP (Basispaket) version 1.7.1 ######

  + Apache 2.2.11
  + MySQL 5.1.33 (Community Server)
  + PHP 5.2.9 + PEAR (Support for PHP 4 has been discontinued)
  + XAMPP Control Version 2.5 from www.nat32.com
  + XAMPP CLI Bundle 1.3 from Carsten Wiedmann	
  + XAMPP Security 1.0	
  + SQLite 2.8.15
  + OpenSSL 0.9.8i
  + phpMyAdmin 3.1.3.1
  + ADOdb 5.06a
  + Mercury Mail Transport System v4.62
  + FileZilla FTP Server 0.9.31
  + Webalizer 2.01-10
  + Zend Optimizer 3.3.0 
  + eAccelerator 0.9.5.3 f¸r PHP 5.2.9 (but not activated in the php.ini)

--------------------------------------------------------------- 

* System Requirements:
 
  + 64 MB RAM (RECOMMENDED)
  + 250 MB free fixed disk 
  + Windows NT, 2000, 2003, XP (RECOMMENDED), VISTA
  + Only 32 Bit (NOT for 64 bit systems) 

---------------------------------------------------------------

* QUICK INSTALLATION:

[NOTE: Unpack the package to your USB stick or a partition of your choice.
There it must be on the highest level like E:\ or W:\. It will 
build E:\xampp or W:\xampp or something like this. Please do not use the "setup_xampp.bat" for an USB stick installation!]   

Step 1: Unpack the package into a directory of your choice. Please start the 
"setup_xampp.bat" and beginning the installation. Note: XAMPP makes no entries in the windows registry and no settings for the system variables.

Step 2: If installation ends successfully, start the Apache 2 with 
"apache_start".bat", MySQL with "mysql_start".bat". Stop the MySQL Server with "mysql_stop.bat". For shutdown the Apache HTTPD, only close the Apache Command (CMD). Or use the fine XAMPP Control Panel with double-click on "xampp-control.exe"! 

Step 3: Start your browser and type http://127.0.0.1 or http://localhost in the location bar. You should see our pre-made
start page with certain examples and test screens.

Step 4: PHP (with mod_php, as *.php, *.php3, *.php4, *.php5, *.phtml), Perl by default with *.cgi, SSI with *.shtml are all located in => C:\xampp\htdocs\.
Examples:
- C:\xampp\htdocs\test.php => http://localhost/test.php
- C:\xampp\htdocs\myhome\test.php => http://localhost/myhome/test.php

Step 5: XAMPP UNINSTALL? Simply remove the "xampp" Directory.
But before please shutdown the apache and mysql.

---------------------------------------------------------------

* PASSWORDS:

1) MySQL:

   User: root
   Password:
   (means no password!)

2) FileZilla FTP:

   User: newuser
   Password: wampp 

   User: anonymous
   Password: some@mail.net

3) Mercury: 

   Postmaster: postmaster (postmaster@localhost)
   Administrator: Admin (admin@localhost)

   TestUser: newuser  
   Password: wampp

4) WEBDAV:

   User: wampp
   Password: xampp

---------------------------------------------------------------

* ONLY FOR NT SYSTEMS! (NT4 | Windows 2000 | Windows XP):

- \xampp\apache\apache_installservice.bat 
  ===> Install Apache 2 as service

- \xampp\apache\apache_uninstallservice.bat 
  ===> Uninstall Apache 2 as service

- \xampp\mysql\mysql_installservice.bat 
  ===> Install MySQL as service

- \xampp\mysql\mysql_uninstallservice.bat 
  ===> Uninstall MySQL as service

==> After all un- / installations of services, better restart system!

----------------------------------------------------------------

A matter of security (A MUST READ!)

As mentioned before, XAMPP is not meant for production use but only for developers in a development environment. The way XAMPP is configured is to be open as possible and allowing the developer anything he/she wants. For development environments this is great but in a production environment it could be fatal. Here a list of missing security 
in XAMPP:

- The MySQL administrator (root) has no password.
- The MySQL daemon is accessible via network.
- phpMyAdmin is accessible via network.
- Examples are accessible via network.

To fix most of the security weaknesses simply call the following URL:

	http://localhost/security/

The root password for MySQL and phpMyAdmin, and also a XAMPP directory protection can being established here.

* NOTE: Some example sites can only access by the local systems, means over localhost. 

---------------------------------------------------------------

* MYSQL NOTES:

(1) The MySQL server can be started by double-clicking (executing) mysql_start.bat. This file can be found in the same folder you installed XAMPP in, most likely this will be C:\xampp\.
The exact path to this file is X:\xampp\mysql_start.bat, where "X" indicates the letter of the drive you unpacked XAMPP into. This batch file starts the MySQL server in console mode. The first intialization might take a few minutes.
Do not close the DOS window or you'll crash the server! To stop the server, please use mysql_stop.bat, which is located in the same directory. Or use the fine XAMPP Control Panel with double-click on "xampp-control.exe" for all these things! 

(2) To use MySQL as Service for NT / 2000 / XP, simply copy the "my.ini" file to "C:\my.ini". Please note that this file has to be placed in C:\ (root), other locations are not permitted. Then execute the "mysql_installservice.bat" in the mysql folder.

(3) MySQL starts with standard values for the user id and the password. The preset user id is "root", the password is "" (= no password). To access MySQL via PHP with the preset values, you'll have to use the following syntax:

	mysql_connect("localhost", "root", "");

If you want to set a password for MySQL access, please use of MySQL Admin.
To set the passwort "secret" for the user "root", type the following:

	C:\xampp\mysql\bin\mysqladmin.exe -u root -p secret
    
After changing the password you'll have to reconfigure phpMyAdmin to use the new password, otherwise it won't be able to access the databases. To do that, open the file config.inc.php in \xampp\phpmyadmin\ and edit the following lines:

	$cfg['Servers'][$i]['user']            = 'root';   // MySQL User
	$cfg['Servers'][$i]['auth_type']       = 'http';   // HTTP authentification

So first the 'root' password is queried by the MySQL server, before phpMyAdmin may access.
  	    	
---------------------------------------------------------------    

		Have a lot of fun! | Viel Spaﬂ! | Bonne Chance!
