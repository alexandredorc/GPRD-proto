<?php
    //listing des resultats de la recherche pour les produits
	
    if($_GET['recherche']=='end_produit'){
		$data=table_columns('produits',$bdd);
		$sql="SELECT * FROM produits WHERE 1=1";
		for($i=0;$i<count($data);$i++){
			$attr=$data[$i]['COLUMN_NAME'];
			$val=$_POST[$attr];
			if(isset($val) && $val!=""){
				if($attr == 'Cat_prod' || $attr == 'Cat_IFRA_prod'){
					$sql="$sql AND $attr='$val'";
				}else{
					$sql="$sql AND $attr LIKE '%$val%'";
				}
			}
		}
		$res=$bdd->query($sql);
		?>
		<div class="body-center" style="max-width:none; padding-bottom:100px;">
			<form action="index.php" method="POST">
			<?php
				$i=0;
				while($data=$res->fetch()){
					$i++;
					?>
					<div class="input-group mb-3">
					<input type="submit"  name="code_prod" value="<?php echo $data['Code_RD_prod'] ?>" style="min-width:120px; border: 2px solid grey ">
					<input type="text" readonly value="<?php echo $data['Nom_RD']?>" style="min-width:300px;">
					<input type="text" readonly value="<?php echo $data['Gamme_RD']?>" style="min-width:300px;">
					<input type="text" readonly value="<?php echo $data['Ligne_RD']?>" style="min-width:300px;">
					</div>
					<?php

			}
				?>
					</form>
						<button class="btn btn-secondary" style="margin: 20px; width:fit-content;" onclick="location.href='index.php?recherche=produit'">
							<i class="bi bi-arrow-left"></i> Retour
						</button>		
				<?php
				if($i==1){
					$_SESSION['id_prod']=table_single_nsearch('produits','Code_RD_prod',$_POST['Code_RD_prod'],$bdd);				
					header("Location: index.php");
				}
			?>
		</div>
		<?php
		
	}
	
	// recherche produit rapide

	elseif($_GET['recherche']=='quick_prod'){
		$_SESSION['id_prod']=table_single_nsearch('produits','Code_RD_prod',$_POST['Code_RD'],$bdd);
		header("Location: index.php");
	}
	
	//page recherche produit

	elseif($_GET['recherche']=='produit'){
		include('search_prod.php');
	}

?>