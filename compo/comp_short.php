<div style="padding: 0 50px;display:flex;font-size:10px;">
	<div>
		<h3>Composants</h3>

		<h4>recherche rapide</h4>
		<form action="index.php?recherche=quick_form"  method="POST">
			<div class="input-group mb-3" style="padding:0 25% 0 0">
				<input type="text" class="form-control" name="nom_inci" aria-label="Recipient's username" aria-describedby="basic-addon2">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
				</div>
			</div>
		</form>
	</div>
	

			
		<?php   
			if(isset($_SESSION['Nom_INCI']))  {  
				$data=table_single_query('composants','Nom_INCI',$_SESSION['Nom_INCI'],$bdd);
				if($data){
					?>
					<div style="padding-top: 50px;">
						Nom INCI composant
						<h6>
						<?php echo $data['Nom_INCI'];?></br>
						</h6>
						Composant validé: 
						<h6>
						<input type="checkbox" disabled <?php echo ($data['Comp_val']=='VRAI')?"checked":"" ;?> >
						</h6>
						
					</div>
					<div style="padding-top:50px;padding-left:10px;">
						Fonction principal: 
						<h6>
						<?php echo $data['Fonct_prin'];?></br>
						</h6>
						Fonction secondaire: 
						<h6>
						<?php echo $data['Fonct_sec'];?></br>
						</h6>
					</div>
                    <div style="padding-top: 50px;padding-left:10px;">
                        Composant Catégorie CMR: 
						<h6>
						<?php echo $data['Cat_CMR'];?></br>
						</h6>
                        Composant réglementé ou à risque:
                        <h6>
                        <input type="checkbox" disabled <?php echo ($data['Comp_reg_risk']=='VRAI')?"checked":"" ;?> >
                        </h6>
						
					
						
					</div>
		<?php   
				} 
			}
		?>
</div>
