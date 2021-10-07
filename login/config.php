<?php

	function user_single_query($attribute,$var,$bdd){
		$req= $bdd->query("SELECT * FROM user WHERE $attribute='$var'");
		if($data=$req->fetch()){
			return $data; 
		}else{
			return false;
		}
	}

	try{
		$bdd = new PDO('mysql:host=localhost;dbname=db_gprd;charset=utf8', 'root', 'root');
	}
	catch(Exception $e){
		die("Erreur : $e->getMessage()");
	}
?>
