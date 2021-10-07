<?php

	
	//permet de trouver le premier éléments d'un tableau 
	//qui respect une condition d'égalité particulière
	function table_single_query($table,$attribute,$var,$bdd){
		$req= $bdd->query("SELECT * FROM $table WHERE $attribute ='$var'");
		if($data=$req->fetch()){
			return $data; 
		}else{
			return false;
		}
	}

    //permet de trouver le premier éléments d'un tableau 
	//qui respect une condition d'égalité particulière
	function table_many_query($table,$attribute,$var,$bdd){
		$req= $bdd->query("SELECT * FROM $table WHERE $attribute ='$var'");
		if($data=$req->fetchAll()){
			return $data; 
		}else{
			return false;
		}
	}
?>
