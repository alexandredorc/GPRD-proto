<?php

/*
*
*
//////// COMPOSANTS ////////
*
*
*
*/
//Access à la page de modification composant

//Access à la page de ajout composant

if($_GET['compo']=='modif'){
    include('modif_compo.php');
}

//formulaire pour ajouter un enouvelle composant 
if($_GET['compo']=='add'){
    include('add_compo.php');
}

//Inserer une nouvelle composant

elseif($_GET['compo']=='push'){
    $data=$bdd->query("SELECT Nom_INCI FROM composants WHERE Nom_INCI='".$_POST['Nom_INCI']."'");
    $data=$data->fetchAll();
    if(count($data)!=0){
        header('Location: index.php?compo=add&erreur=1');
        
    }else{
        $req=$bdd->prepare("INSERT INTO composants 
         (Nom_INCI, Fonct_prin, Fonct_sec, Qtt_comp_reg, Qtt_reg_comp)
        VALUES (:Nom_INCI, :Fonct_prin, :Fonct_sec , '1', '1')");
        $req->execute([
            'Nom_INCI' => $_POST['Nom_INCI'],
            'Fonct_prin' => $_POST['Fonct_prin'], 
            'Fonct_sec' => $_POST['Fonct_sec']
            ]);
        $_SESSION['Nom_INCI']=$_POST['Nom_INCI'];
        header('Location: index.php?compo=modif');
    }
}


//Appliquer les changements des composants

elseif($_GET['compo']=='change'){
    
    if($_POST['btn']=='save'){
        $table='composants';
        table_save_data($table,$bdd,$_POST);
    }
    elseif($_POST['btn']="suppr"){
        $data=$_SESSION['Nom_INCI'];
        $req=$bdd->exec("DELETE FROM composants WHERE Nom_INCI='$data'");
        //$req=$bdd->exec("DELETE FROM comp_form WHERE Ref_form_RD='$data'");
    }
    header('Location: index.php');
}

//Access à la page de ajout composant

if($_GET['compo']=='search'){
    include('search_compo.php');
}


if($_GET['compo']=='result'){
    $data=table_columns('composants',$bdd);
		$sql="SELECT * FROM composants WHERE 1=1";
		for($i=0;$i<count($data);$i++){
			$attr=$data[$i]['COLUMN_NAME'];
			
			if(isset($_POST[$attr]) && $_POST[$attr]!=""){
				if(false){
					$sql="$sql AND $attr='$val'";
				}else{
                    $val=($_POST[$attr]=='on')?'VRAI':$_POST[$attr];
					$sql="$sql AND $attr LIKE '%$val%'";
				}
			}
		}
		$res=$bdd->query($sql);
        $donne="";
		?>
		<div class="body-center" style=" padding-bottom:100px;">
			<form action="index.php" method="POST">

				<?php
				$i=0;
				while($data=$res->fetch()){
					$donne=$data['Nom_INCI'];	
					$i++;
					?>
					<div class="input-group mb-3">
						<input type="submit"  name="nom_inci" value="<?php echo $data['Nom_INCI'] ?>" style="min-width:400px; border: 2px solid grey ">
						<input type="text" readonly style="min-width:250px;" value="<?php echo $data['Fonct_prin']?>">
						<input type="text" readonly style="min-width:250px;" value="<?php echo $data['Fonct_sec']?>" >
					</div>
				<?php }
				?>

			</form>
			<button class="btn btn-secondary" style="margin: 20px; width:fit-content;" onclick="location.href='index.php?compo=search'">
				<i class="bi bi-arrow-left"></i> Retour
			</button>		
				<?php
				if($i==1){
					$_SESSION['Nom_INCI']=$donne;	
                    	
					header("Location: index.php");
				}
			?>
		</div>
<?php
}
?>