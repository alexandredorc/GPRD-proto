<?php 




?>
<h2>Matières Premières</h2>
<form action="index.php?MP=add" method="POST"  style="display:flex;flex-direction:column; margin:20px;">
    <button class="btn btn-success"><i class="bi bi-plus-lg" ></i> Ajouter</button>
</form>
<h4>recherche rapide</h4>
<form action="index.php" method="POST">
    <div class="input-group mb-3" style="padding:0 25% 0 0">
        <input type="text" class="form-control" name="codeMP" aria-label="Recipient's username" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
        </div>
    </div>
</form>

<?php   
        $data=table_single_query('matieres_premieres','Code_MP',$_SESSION['Code_MP'],$bdd);
        if($data){?>
        <form action="index.php?MP=modif" method="POST" style="display:flex;flex-direction:column;">
            Code MP: 
            <input type="text" readonly value= "<?php echo $data['Code_MP'];?>"> </br>
            Nom commercial de la MP: 
            <input type="text" readonly value= "<?php echo $data['Nom_com_MP'];?>"> </br>
            Dénomination INCI: 
            <input type="text" readonly value= "<?php echo $data['Nom_MP'];?>"> </br>
            Prix de la MP en Kg: 
            <input type="text" readonly value= "<?php echo $data['Prix_MP'] ." €";?>"> </br>
            <table class="table">
                <tr>
                    <td>
                        MP inerté à l'argon: </br>
                        <input type="checkbox" disabled <?php if($data['MP_argon']=='VRAI'){echo 'checked';};?>>
                    </td>
                    <td>
                        MP en voie de suppression: </br>
                        <input type="checkbox" disabled <?php if($data['MP_suppr']=='VRAI'){echo 'checked';};?>>
                    </td>
                    <td>
                        Validation MP: </br>
                        <input type="checkbox" disabled <?php if($data['Val_MP']=='VRAI'){echo 'checked';};?>>
                    </td>
                    <td>
                        Huile Essentiel: </br>
                        <input type="checkbox" disabled <?php if($data['HE_MP']=='VRAI'){echo 'checked';};?>>
                    </td>
                </tr>
            </table>
            
            Propriété de la MP
            <textarea readonly ><?php echo $data['Props_MP'];?></textarea> </br> 
            Recommendation MP: 
            <textarea readonly ><?php echo $data['Reco_MP'];?></textarea> </br> 
            Information supplémentaire de la MP
            <textarea readonly ><?php echo $data['Info_supp'];?></textarea> </br>             
            <table class="table"">
                <tr><h3>Indices de naturalités</h3></tr>
                <tr>
                    <td>Indice Naturel: 
                    <input type="text" readonly value= "<?php echo $data['IN_MP'] ;?>"> </td>
                    <td>Indice d'Origine Naturel: 
                    <input type="text" readonly value= "<?php echo $data['ION_MP'] ;?>"> </td>
                </tr>
                <tr>
                    <td>Indice Biologique: 
                    <input type="text" readonly value= "<?php echo $data['IB_MP'] ;?>"> </td>
                    <td>Indice d'Origine Biologique: 
                    <input type="text" readonly value= "<?php echo $data['IOB_MP'] ;?>"> </td>
                </tr> 
            </table>
            Commentaire Indice de Naturalité: 
            <textarea readonly ><?php echo $data['Com_ind'];?></textarea> </br>  </td>
            <button class="btn btn-warning" style="margin: 50px 0">Modifier</button>
        </form>
<?php   
        } 
?>
