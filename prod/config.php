<?php
	//permet de trouver l'élément N éme d'une table
	function table_single_nquery($table,$n,$bdd){
		$req= $bdd->query("SELECT * FROM $table");
		$data=false;
		for($i=1;$i<=$n; $i++){
			if(!$data=$req->fetch()){
				return false;
			}
		}
		return $data;
	}

	//permet de trouver tous les élément d'une table
	function table_all_queries($table,$bdd){
		$req= $bdd->query("SELECT * FROM $table");
		return $req->fetchAll();
	}

	//permet de trouver l'index correspondant à une valeur precise dans une table
	function table_single_nsearch($table,$attr,$val,$bdd){
		$req= $bdd->query("SELECT * FROM $table");
		$data=false;
		$i=1;
		while($data=$req->fetch()){
			if($data[$attr]==$val){
				return $i;
			}
			$i++;
		}
		return false;
	}

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

	//permet de trouver la clef primaire d'une table
	function primary_key_table($table,$bdd){
		$req= $bdd->query("SHOW INDEX FROM $table");
		if($data=$req->fetch()){
			return $data['Column_name'];
		}else{
			return false;
		}
	}

	//permet de trouver toutes les colonnes d'une table (leurs nom Column_Name)
	function table_columns($table,$bdd){
		$req = $bdd->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table'");
		$data=$req->fetchAll();
		if(isset($data)){
			return $data;
		}else{
			return false;
		}
	}

	//permet de realiser une jointure entre deux table et de mettre des condition par la suite
	function table_to_table($table1,$table2,$FK,$attribute,$vari,$bdd,$end=''){
		$key=primary_key_table($table1,$bdd);
		$a=$table1.'.'.primary_key_table($table1,$bdd);
		$b=$table2.'.'.$FK;
		$sql="SELECT * FROM $table1 JOIN $table2 ON $a = $b WHERE $attribute = '$vari' $end";
		$req=$bdd->query($sql);
		if($req){
			return $req;
		}
	}

	//permet de trouver le premier élément qui respecte un ensemble de condition
	function table_many_query($table,$cond,$bdd){
		
		$sql="SELECT * FROM $table WHERE ";
		for($i=0 ; $i < count($cond);$i++){
			$attr=$cond[$i][0];
			$val= $cond[$i][1];
			if($i!=0){
				$sql="$sql AND ";
			}
			$sql="$sql $attr = '$val'";
		}
		//echo $sql;
		$req=$bdd->query($sql);
		if($data=$req->fetch()){
			return $data; 
		}else{
			return false;
		}
	}

	

	function table_size($table,$cond,$bdd){
		
		$sql="SELECT MAX(Ligne) FROM $table WHERE ";
		for($i=0 ; $i < count($cond);$i++){
			$attr=$cond[$i][0];
			$val= $cond[$i][1];
			if($i!=0){
				$sql="$sql AND ";
			}
			$sql="$sql $attr = '$val'";
		}
		//echo $sql;
		$req=$bdd->query($sql);
		
		if($data=$req->fetch()){
			return $data['MAX(Ligne)']; 
		}else{
			return false;
		}
	}


?>
