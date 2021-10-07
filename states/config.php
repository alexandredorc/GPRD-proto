<?php
	

	function table_get_all($table,$bdd,$end=''){
		$sql="SELECT * FROM $table WHERE 1=1 $end";
		$req=$bdd->query($sql);
		$data=$req->fetchAll();
		if($data){
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

	//permet de realiser une jointure entre deux table et de mettre des condition par la suite
    function table_to_table($table1,$table2,$FK,$attribute,$vari,$bdd,$end=''){
        $key=primary_key_table($table1,$bdd);
        $a=$table1.'.'.primary_key_table($table1,$bdd);
        $b=$table2.'.'.$FK;
        $sql="SELECT * FROM $table1 JOIN $table2 ON $a = $b WHERE $attribute = '$vari' $end";
        $req=$bdd->query($sql);
        $data=$req->fetchAll();
		if($data){
			return $data; 
		}else{
			return array();
		}
    }


	//permet de trouver tous les éléments qui respecte un ensemble de condition
	function table_many_query($table,$cond,$bdd){
		
		$sql="SELECT * FROM $table WHERE 1=1";
		for($i=0;$i<count($cond);$i++){
			$attr=$cond[$i][0];
			$val=$cond[$i][1];
			if(isset($val) && $val!=""){
				$sql="$sql AND $attr LIKE '%$val%'";
			}
		}
		$req=$bdd->query($sql);
		if($data=$req->fetchAll()){
			return $data; 
		}else{
			return false;
		}
	}


    
?>
