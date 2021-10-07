

<h1 class="title">
        Composants 
</h1>

    <form action="index.php?compo=add" method="POST"  style="display:flex;flex-direction:column; margin:20px;">
    <button class="btn btn-success"style="width:100px;"><strong><i class="bi bi-plus-lg" ></i> Ajouter</strong></button>
    </form>
    <h4>recherche rapide</h4>
    <form action="index.php" method="POST">
        <div class="input-group mb-3" style="padding:0 25% 0 0">
            <input type="text" class="form-control" name="nom_inci" style="width:200px;">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
            </div>
        </div>
    </form>

    <?php   
        if(isset($_SESSION['Nom_INCI'])){
            $data=table_single_query('composants','Nom_INCI',$_SESSION['Nom_INCI'],$bdd);
            if($data){
            $_SESSION['frac_reg']=$data['Qtt_comp_reg']/$data['Qtt_reg_comp'];
                ?>
            <form action="index.php?compo=modif" method="POST" style="display:flex;flex-direction:column;">
                <table class="table" >
                    <colgroup>
                        <col span="1" style="width: 15%;">
                        <col span="1" style="width: 70%;">
                    </colgroup>
                    <tr style="text-align:left;">
                        <td>Nom INCI du composant: </td>
                        <td><h5><?php echo $data['Nom_INCI'];?></h5></td>
                    </tr>
                    <tr style="text-align:left;">
                        <td>Fonction principal: </td>
                        <td><h5><?php echo $data['Fonct_prin'];?></h5></td>
                    </tr>
                    <tr style="text-align:left;">
                        <td>Fonction secondaire: </td>
                        <td><h5><?php echo $data['Fonct_sec'];?></h5></td>
                    </tr>
                    <tr style="text-align:left;">
                        <td>Substance réglementée: </td>
                        <td><h5><?php echo $data['Sub_reg'];?></h5></td>
                    </tr>
                    <tr style="text-align:left;">
                        <td>Mélange réglementée: </td>
                        <td><h5><?php echo $data['Mel_reg'];?></h5></td>
                    </tr>
                    <tr style="text-align:left;">
                        <td>Substance réglementée exprimée en: </td>
                        <td><h5><?php echo $data['Sub_reg_expr'];?></h5></td>
                    </tr>
                    <tr style="text-align:left;">
                        <td>Mélange réglementée exprimée en: </td>
                        <td><h5><?php echo $data['Mel_reg_expr'];?></h5></td>
                    </tr>
                    <tr style="text-align:left;">
                        <td colspan="2">
                            <table class="table" style="width:50%;">
                                <colgroup>
                                    <col span="1" style="width: 30%;">
                                    <col span="1" style="width: 20%;">
                                    <col span="1" style="width: 5%;">
                                    <col span="1" style="width: 5%;">
                                    <col span="1" style="width: 30%;">
                                    <col span="1" style="width: 5%;">
                                </colgroup>
                                <tr style="text-align:left;">
                                    <th>Correspondace poids pour poids</th>
                                    <th>Quantité composant:</th>
                                    <th><?php echo $data['Qtt_comp_reg'];?></th>
                                    <th><i class="bi bi-arrow-right" style="font-size:20px;"></i></th>
                                    <th>Quantité substance réglementée</th>
                                    <th><?php echo $data['Qtt_reg_comp'];?></th>
                                </tr>
                            </table>
                        </td>
                        
                    </tr>
                    <tr style="text-align:left;">
                        <td colspan="2">
                            <table class="table" style="width:50%;">
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
                        </td>
                    </tr>
                    <tr style="text-align:left;">
                        <td>Information supplémentaire: 
                            </br><i style="font-size:10px">( commentaire de saisie )</i>
                        </td>
                        <td><h5><?php echo $data['Info_supp'];?></h5></td>
                    </tr>
                </table>
                <button class="btn btn-warning" style="width:100px;"><strong>Modifier</strong></button>
            </form>
    <?php   
            } 
        }
    ?>
 