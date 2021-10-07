<?php

/*
*
*
//////// MATIERES PREMIERES ////////
*
*
*
*/
//Access à la page de modification formules


//Access à la page de ajout formules

if($_GET['MP']=='modif'){
    include('modif_MP.php');
}

//formulaire pour ajouter un enouvelle formule 
if($_GET['MP']=='add'){
    include('add_MP.php');
}

//Inserer une nouvelle formule

elseif($_GET['MP']=='push'){
    $data=$bdd->query("SELECT Code_MP FROM matieres_premieres WHERE Code_MP='".$_POST['Code_MP']."'");
    $data=$data->fetchAll();
    if(count($data)!=0){
        header('Location: index.php?MP=add&erreur=1');
        
    }else{
        $req=$bdd->prepare("INSERT INTO matieres_premieres 
        (Code_MP, Nom_com_MP, Nom_MP) 
        VALUES (:Code_MP, :Nom_com_MP, :Nom_MP )");
        $req->execute([
            'Code_MP' => $_POST['Code_MP'],
            'Nom_MP' => $_POST['Nom_MP'], 
            'Nom_com_MP' => $_POST['Nom_com_MP']
            ]);
        $_SESSION['Code_MP']=$_POST['Code_MP'];
        header('Location: index.php?MP=modif');
    }
}


//Appliquer les changements des formules

elseif($_GET['MP']=='change'){
    
    if($_POST['btn']=='save'){
        $table='matieres_premieres';
        table_save_data($table,$bdd,$_POST);
    }
    elseif($_POST['btn']="suppr"){
        $data=$_SESSION['Code_MP'];
        $req=$bdd->exec("DELETE FROM matieres_premieres WHERE Code_MP='$data'");
        //$req=$bdd->exec("DELETE FROM comp_form WHERE Ref_form_RD='$data'");
    }
    header('Location: index.php');
}

//Access à la page de ajout formules

if($_GET['MP']=='search'){
    include('search_MP.html');
}


if($_GET['MP']=='result'){
    $data=table_columns('matieres_premieres',$bdd);
		$sql="SELECT * FROM matieres_premieres WHERE 1=1";
		for($i=0;$i<count($data);$i++){
			$attr=$data[$i]['COLUMN_NAME'];
			
			if(isset($_POST[$attr]) && $_POST[$attr]!=""){
				if(false){
					$sql="$sql AND $attr='$val'";
				}else{
                    $val=$_POST[$attr];
					$sql="$sql AND $attr LIKE '%$val%'";
				}

			}

		}
		echo $sql;
		$res=$bdd->query($sql);
        $donne=0;
		?>
		<div class="body-center" style="max-width:none; padding-bottom:100px;">
			<form action="index.php" method="POST">
			<?php
				$i=0;
				while($data=$res->fetch()){
                    $donne=$data['Code_MP'];	
					$i++;
					?>
					<div class="input-group mb-3">
					<input type="submit"  name="codeMP" value="<?php echo $data['Code_MP'] ?>" style="min-width:120px; border: 2px solid grey ">
					<input type="text" readonly value="<?php echo $data['Nom_MP']?>" style="min-width:300px;">
					<input type="text" readonly value="<?php echo $data['Nom_com_MP']?>" style="min-width:300px;">
					<input type="text" readonly value="<?php echo $data['Prix_MP'].' €/kg'?>" style="min-width:300px;">
					</div>
				<?php
			    }
				?>
					</form>
						<button class="btn btn-secondary" style="margin: 20px; width:fit-content;" onclick="location.href='index.php?MP=search'">
							<i class="bi bi-arrow-left"></i> Retour
						</button>		
				<?php
				if($i==1){
					$_SESSION['Code_MP']=$donne;	
                    	
					header("Location: index.php");
				}
			?>
		</div>
<?php
}
?>