<?php
    function dbconnect() {
        try {
            /* Username & password will need to be changed to
                account that FROST can use in the database */
            return new PDO('mysql:host=localhost; dbname=frost', 'jamie', 'password');
        }
        catch(PDOException $e) {
            die('Cannot connect to database: ' . $e -> getMessage());
        }
    }

/**
 * @return string location of the directory that this file is stored in.
 */
function getwd() {
		return (str_replace($_SERVER["DOCUMENT_ROOT"],'', str_replace('\\','/',__DIR__ ) ));
	}
?>