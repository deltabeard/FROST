FROST
=====

FROST (FRee and Open Source Tube) aims to be a free and open alternative to YouTube and its competitors.


Current Development
===================

FROST is currently in pre-development stages. Please look at the issues to see what needs to be done before programming commences.

If you would like to contribute please fork this repository, make your changes, and then make a pull request. You may also contribute by making comments of constructive criticism on to any issue.


Prerequisites
=============

* Change post_max_size (php.ini) to the maximum file size you want the user to upload on to the server.
```
post_max_size=50M
```

* Change the salt used in public_html/upload_file.php before uploading to a server.
```
		// Strongly recommended to replace the string used as salt here
		$trip = crypt($_POST["trip_pass"], 'Change This String!');
```
