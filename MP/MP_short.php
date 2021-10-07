<div style="padding: 0 50px;display:flex;font-size:10px;">
	<div>
		<h3>Matières premières</h3>

		<h4>recherche rapide</h4>
        <form action="index.php" method="POST">
            <div class="input-group mb-3" style="padding:0 25% 0 0">
                <input type="text" class="form-control" name="codeMP" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </form>
	</div>
	

			
		<?php   
			if(isset($_SESSION['Code_MP']))  {  
				$data=table_single_query('matieres_premieres','Code_MP',$_SESSION['Code_MP'],$bdd);
				if($data){
					?>
					<div style="padding-top: 50px;">
						Code MP:
						<h6>
						<?php echo $data['Code_MP'];?></br>
						</h6>
						Prix/kg: 
						<h6>
						<?php echo $data['Prix_MP']."€";?></br>
						</h6>
						
					</div>
					<div style="padding-top:50px;padding-left:10px;">
                    Nom de la matière première: 
						<h6>
						<?php echo $data['Nom_MP'];?></br>
						</h6>
						Nom commercial de la matière première: 
						<h6>
						<?php echo $data['Nom_com_MP'];?></br>
						</h6>
					</div>
                    <div style="padding-top: 50px;padding-left:10px;">
                        MP validée: 
						<h6>
						<input type="checkbox" disabled <?php echo ($data['Val_MP']=='VRAI')?"checked":"" ;?> >
						</h6>
                        MP en voie de suppréssion: 
                        <h6>
                            <input type="checkbox" disabled <?php echo ($data['MP_suppr']=='VRAI')?"checked":"" ;?> >
                        </h6>
						
					
						
					</div>
		<?php   
				} 
			}
		?>
</div>
