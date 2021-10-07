<?php
//connexion à la base de données
    try{
        $bdd = new PDO('mysql:host=eu-cdbr-west-01.cleardb.com;dbname=heroku_7b7a0cebd2b85ca;charset=utf8', 'b1c46dce1fdaa6', '6e56d612');
	}
    catch(Exception $e){
        die("Erreur : $e->getMessage()");
    }
?>