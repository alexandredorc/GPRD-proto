

<h1 class="title">
        Composants 
</h1>

    <form action="index.php?compo=add" method="POST"  style="display:flex;flex-direction:column; margin:20px;">
        <button class="btn btn-success"><i class="bi bi-plus-lg" ></i> Ajouter</button>
    </form>
    <h4>recherche rapide</h4>
    <form action="index.php" method="POST">
        <div class="input-group mb-3" style="padding:0 25% 0 0">
            <input type="text" class="form-control" name="nom_inci" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
            </div>
        </div>
    </form>

    <?php   
            $data=table_single_query('composants','Nom_INCI',$_SESSION['Nom_INCI'],$bdd);
            if($data){
            $_SESSION['frac_reg']=$data['Qtt_comp_reg']/$data['Qtt_reg_comp'];
                ?>
            <form action="index.php?compo=modif" method="POST" style="display:flex;flex-direction:column;">
                Nom INCI du composant: 
                <input type="text" readonly value= "<?php echo $data['Nom_INCI'];?>"> </br>
                Fonction principal: 
                <input type="text" readonly value= "<?php echo $data['Fonct_prin'];?>"> </br>
                Fonction secondaire: 
                <input type="text" readonly value= "<?php echo $data['Fonct_sec'];?>"> </br>
                Substance réglementée: 
                <input type="text" readonly value= "<?php echo $data['Sub_reg'];?>"> </br>
                Mélange réglementée: 
                <input type="text" readonly value= "<?php echo $data['Mel_reg'];?>"> </br>
                <h5>Autre forme chimique réglementée du composant</h5>
                Substance réglementée exprimée en: 
                <input type="text" readonly value= "<?php echo $data['Sub_reg_expr'];?>"> </br>
                Mélange réglementée exprimée en: 
                <input type="text" readonly value= "<?php echo $data['Mel_reg_expr'];?>"> </br>
                <table class="table">
                    <tr>
                        <th >Correspondace poids pour poids</th>
                        <th>Quantité composant:</th>
                        <th></th>
                        <th>Quantité substance réglementée</th>
                    </tr>
                    <tr>
                        <th >Composants/substance réglementée</th>
                        <th><input type="text" readonly value= "<?php echo $data['Qtt_comp_reg'];?>"></th>
                        <th><i class="bi bi-arrow-right" style="font-size:20px;"></i></th>
                        <th><input type="text" readonly value= "<?php echo $data['Qtt_reg_comp'];?>"></th>
                    </tr>
                </table>
                <table class="table">
                    <tr>
                        <td>
                            Composant CMR </br>
                            <input type="checkbox" disabled <?php if($data['Comp_CMR']=='VRAI'){echo 'checked';};?>>
                        </td>
                        <td class="long">
                            Catégorie(s) CMR </br>
                            <input type="text" readonly value= "<?php echo $data['Cat_CMR'];?>">
                        </td>

                        <td>
                            Composant réglementée ou à risque </br>
                            <input type="checkbox" disabled <?php if($data['Comp_reg_risk']=='VRAI'){echo 'checked';};?>>
                        </td>
                        <td>
                            Donnée composant validées: </br>
                            <input type="checkbox" disabled <?php if($data['Comp_val']=='VRAI'){echo 'checked';};?>>
                        </td>
                    </tr>
                </table>
                Information supplémentaire
                <i style="font-size:10px">( commentaire de saisie )</i>
                <textarea  rows="2"><?php echo $data['Info_supp'];?></textarea>
                <button class="btn btn-warning" style="margin: 50px 0">Modifier</button>
            </form>
    <?php   
            } 
            
    ?>
 