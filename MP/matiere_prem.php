<?php 




?>
<h2>Matières Premières</h2>
<form action="index.php?MP=add" method="POST"  style="display:flex;flex-direction:column; margin:20px;">
    <button class="btn btn-success" style="width:150px;"><i class="bi bi-plus-lg" ></i> Ajouter</button>
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
    if(isset($_SESSION['Code_MP'])){
        $data=table_single_query('matieres_premieres','Code_MP',$_SESSION['Code_MP'],$bdd);
        if($data){?>
        <form action="index.php?MP=modif" method="POST" style="display:flex;flex-direction:column;">
            <table class="table" >
                <colgroup>
                    <col span="1" style="width: 15%;">
                    <col span="1" style="width: 70%;">
                </colgroup>
                <tr style="text-align:left;">
                    <td>Code MP: </td>
                    <td><h5><?php echo $data['Code_MP'];?></h5></td>
                </tr>
                <tr style="text-align:left;">
                    <td>Nom commercial de la MP: </td>
                    <td><h5><?php echo $data['Nom_com_MP'];?></h5></td>
                </tr>
                <tr style="text-align:left;">
                    <td>Dénomination INCI: </td>
                    <td><h5><?php echo $data['Nom_MP'];?></h5></td>
                </tr>
                <tr style="text-align:left;">
                    <td>Prix de la MP en Kg: </td>
                    <td><h5><?php echo $data['Prix_MP'] ." €";?></h5></td>
                </tr>
                <tr style="text-align:left;">
                    <td colspan="2">
                        <table class="table" style="width:50%;">
                            <tr style="text-align:left;">
                                <td>
                                    MP inerté à l'argon:
                                </td>
                                <td><input type="checkbox" disabled <?php if($data['MP_argon']=='VRAI'){echo 'checked';};?>>
                                </td>
                                <td>
                                    MP en voie de suppression:
                                </td>
                                <td>
                                    <input type="checkbox" disabled <?php if($data['MP_suppr']=='VRAI'){echo 'checked';};?>>
                                </td>
                            </tr>
                            <tr style="text-align:left;">
                                <td>
                                    Validation MP:
                                </td>
                                <td>
                                    <input type="checkbox" disabled <?php if($data['Val_MP']=='VRAI'){echo 'checked';};?>>
                                </td>
                                <td>
                                    Huile Essentiel:
                                </td>
                                <td>
                                    <input type="checkbox" disabled <?php if($data['HE_MP']=='VRAI'){echo 'checked';};?>>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="text-align:left;">
                    <td>Propriété de la MP:</td>
                    <td><h5><?php echo $data['Props_MP'];?></h5></td>
                </tr>
                <tr style="text-align:left;">
                    <td>Recommendation MP: </td>
                    <td><h5><?php echo $data['Reco_MP'];?></h5></td>
                </tr>
                <tr style="text-align:left;">
                    <td>Information supplémentaire de la MP:</td>
                    <td><h5><?php echo $data['Info_supp'];?></h5></td>
                </tr>
                <tr><td><h3>Indices de naturalités</h3></td></tr>
                <tr>
                    <td colspan="2">
                    <table class="table" style="width:50%">
                        <tr style="text-align:left;">
                            <td>Indice Naturel: <?php echo $data['IN_MP'] ;?></td>
                            <td>Indice d'Origine Naturel: <?php echo $data['ION_MP'] ;?> </td>
                        </tr>
                        <tr style="text-align:left;">
                            <td>Indice Biologique: <?php echo $data['IB_MP'] ;?></td>
                            <td>Indice d'Origine Biologique: <?php echo $data['IOB_MP'] ;?> </td>
                        </tr> 
                    </table>
                    </td>
                </tr>
                <tr style="text-align:left;">
                    <td>Commentaire Indice de Naturalité: </td>
                    <td><?php echo $data['Com_ind'];?></td>
                </tr>
            </table>
            <button class="btn btn-warning" style="width:100px;"><strong>Modifier</strong></button>
        </form>
<?php   
        } 
    }
?>
