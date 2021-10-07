<?php

	function user_single_query($attribute,$var,$bdd){
		$req= $bdd->query("SELECT * FROM user WHERE $attribute='$var'");
		if($data=$req->fetch()){
			return $data; 
		}else{
			return false;
		}
	}

?>
