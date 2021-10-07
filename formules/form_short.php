<div style="padding: 0 50px;display:flex;font-size:10px;">
	<div>
		<h3>Formules</h3>

		<h4>recherche rapide</h4>
		<form action="index.php?recherche=quick_form"  method="POST">
			<div class="input-group mb-3" style="padding:0 25% 0 0">
				<input type="text" class="form-control" name="Ref_form" aria-label="Recipient's username" aria-describedby="basic-addon2">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
				</div>
			</div>
		</form>
	</div>
	

			
		<?php   
			if(isset($_SESSION['ref_form']))  {  
				$data=table_single_query('formules','Ref_form',$_SESSION['ref_form'],$bdd);
				if($data){
					?>
					<div style="padding-top: 50px;">
						Référence Formule R&D
						<h6>
						<?php echo $data['Ref_form'];?></br>
						</h6>
						Etat de la formule: 
						<h6>
						<?php echo ($data['Etat_form']==1)?"Commercialisé":(($data['Etat_form']==2)?"En développement":"" );?></br>
						</h6>
						
					</div>
					<div style="padding-top:50px;padding-left:10px;">
						Code GPAO: 
						<h6>
						<?php echo $data['Code_GPAO'];?></br>
						</h6>
						Information Formule: 
						<h6>
						<?php echo $data['Info_form'];?></br>
						</h6>
					</div>
                    <div style="padding-top: 50px;padding-left:10px;">
                        Retenue: 
						<h6>
						<input type="checkbox" disabled <?php echo ($data['Retenue']=='VRAI')?"checked":"" ;?> >
						</h6>
                        Annulée: 
                        <h6>
                            <input type="checkbox" disabled <?php echo ($data['Annulee']=='VRAI')?"checked":"" ;?> >
                        </h6>
						
					
						
					</div>
		<?php   
				} 
			}
		?>
</div>
