FROST
=====

FROST (FRee and Open Source Tube) aims to be a free and open alternative to YouTube and its competitors.


Current Development
===================

FROST is currently in alpha development stage. We aim to release the first alpha version soon.

If you would like to contribute please fork this repository, make your changes, and then make a pull request. You may also contribute by making comments of constructive criticism on to any issue.


Prerequisites
=============

* Change post_max_size (php.ini) to the maximum file size you want the user to upload on to the server.
```
post_max_size=50M
upload_max_filesize=50M
```

* Change the database credentials in public_html/dbconnect.php
```
return new PDO('mysql:host=localhost; dbname=FROST', 'jamie', 'password');
```
