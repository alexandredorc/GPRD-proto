<?php

    

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

    //permet de trouver la clef primaire d'une table
	function primary_key_table($table,$bdd){
		$req= $bdd->query("SHOW INDEX FROM $table");
        
		if($data=$req->fetch()){
			return $data['Column_name'];
		}else{
			return false;
		}
	}

    function table_single_query($table,$attribute,$var,$bdd){
        $sql="SELECT * FROM $table WHERE $attribute ='$var'";
        $req= $bdd->query($sql);
        if($data=$req->fetch()){
            return $data; 
        }else{
            return false;
        }
    }

    function get_single_attribut($table,$attribut,$bdd){
        $sql="SELECT $attribut FROM $table GROUP BY $attribut";
        $req= $bdd->query($sql);
        $data=$req->fetchAll();
		if(isset($data)){
			return $data;
		}else{
			return false;
		}
    }


    //enregistrement des données
    function table_save_data($table,$bdd,$post){
        $col=table_columns($table,$bdd);
        $prime=primary_key_table($table,$bdd);
        $sql="UPDATE $table SET " ;
        for($i=0;$i<count($col);$i++){
            if($prime!=$col[$i][3]){
                $c=$col[$i][3];
                $d=(!isset($post[$c])?"FAUX":(($post[$c]=='on')?"VRAI":str_replace(' €','',$post[$c])));
                
                $sql="$sql $c = \"$d\" ";
                if($i+1<count($col)){
                    $sql=$sql.",";
                }
            }
        }
        $sql=$sql." WHERE $prime= '".$_SESSION["$prime"]."'";
        $req=$bdd->exec($sql);
    }

    //enregistrement des données
    function table_save_data_reg($table,$bdd,$post,$n,$foreign,$val){
        
        $col=table_columns($table,$bdd);
        $prime=primary_key_table($table,$bdd);
        $sql="UPDATE $table SET " ;
        for($i=0;$i<count($col);$i++){
            if($prime!=$col[$i][3]){
                $c=$col[$i][3];
                if($c!=$foreign){
                    $d=(!isset($post[$c."_".$n])?"FAUX":(($post[$c."_".$n]=='on')?"VRAI":str_replace(' €','',$post[$c."_".$n])));
                    $d=( $c!="Seuil_notif" && $c!="%_max_auto" && $c!="%_max_restric" && $c!="Seuil_etiqu" && $c!="Seuil_alerte")?$d:str_replace('%','',$d);
                }else{
                    $d=$val;
                }
                $sql="$sql `$c` = \"$d\" ";
                if($i+1<count($col)){
                    $sql=$sql.",";
                }
            }
        }
        $sql=$sql." WHERE $prime= '".$post[$prime."_".$n]."'";
        $req=$bdd->exec($sql);
    }

    //permet de trouver tous les élément d'une table
	function table_all_queries($table,$bdd){
		$req= $bdd->query("SELECT * FROM $table");
		return $req->fetchAll();
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

    

?>