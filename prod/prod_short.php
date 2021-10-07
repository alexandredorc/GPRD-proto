<div style="padding: 0 50px;display:flex;font-size:10px;">
	<div>
		<h3>Produits finis</h3>

		<h4>recherche rapide</h4>
		<form action="index.php?recherche=quick_prod"  method="POST">
			<div class="input-group mb-3" style="padding:0 25% 0 0">
				<input type="text" class="form-control" name="Code_RD" aria-label="Recipient's username" aria-describedby="basic-addon2">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
				</div>
			</div>
		</form>
	</div>
	

			
		<?php   
			if($_SESSION['id_prod']>0 && $_SESSION['id_prod']<900)  {  
				$data=table_single_nquery('produits',$_SESSION['id_prod'],$bdd);
				if($data){
					?>
					<div style="padding-top: 50px;">
						Code R&D: 
						<h6>
						<?php echo $data['Code_RD_prod'];?></br>
						</h6>
						Nom R&D: 
						<h6>
						<?php echo $data['Nom_RD'];?></br>
						</h6>
						
					</div>
					<div style="padding-top:50px;padding-left:10px;">
						Gamme R&D: 
						<h6>
						<?php echo $data['Gamme_RD'];?></br>
						</h6>
						Ligne R&D: 
						<h6>
						<?php echo $data['Ligne_RD'];?></br>
						</h6>
					</div>
		<?php   
				} 
			}
		?>
</div>
