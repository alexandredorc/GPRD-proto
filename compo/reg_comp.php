<?php
    if(isset($_GET['comp_reg'])){
        if($_GET['comp_reg']=="add"){
            $req=$bdd->prepare("INSERT INTO reglement_comp (Nom_INCI_reg) VALUES (:Nom_INCI_reg ) ");
            $req->execute(['Nom_INCI_reg'=> $_SESSION['Nom_INCI']]);
        }
        elseif($_GET['comp_reg']=="save"){
            $res= table_to_table('composants','reglement_comp','Nom_INCI_reg','Nom_INCI_reg',$_SESSION['Nom_INCI'],$bdd)->fetchAll();
            for($i=0;$i<count($res);$i++){
                table_save_data_reg('reglement_comp',$bdd,$_POST,$i,'Nom_INCI_reg',$_SESSION['Nom_INCI']);
            }
        }
        elseif($_GET['comp_reg']=='trash'){
            $req=$bdd->prepare("DELETE FROM reglement_comp WHERE index_reg_comp=:index_reg_comp");
            $req->execute([
                'index_reg_comp'=> $_GET['id']
            ]);
        }

        
    }
?>

    <div>
    <?php
    $synth=array();
    if(isset($_SESSION['Nom_INCI'])){?>
        <div>
            <button class="btn btn-primary" style="margin:20px 0px;" onclick="location.href = 'index.php?comp_reg=add'">
            <i class="bi bi-plus-lg" ></i> Ajouter une ligne de réglementation
            </button>
        </div>
        <?php
        $res= table_to_table('composants','reglement_comp','Nom_INCI_reg','Nom_INCI_reg',$_SESSION['Nom_INCI'],$bdd)->fetchAll();
        if(count($res)!=0){?>
        <h5>Le composant a <?php echo count($res);?> lignes de réglementation </h5>
        <form action="index.php?comp_reg=save" method="POST">
            <table class="table" style="font-size:10px; ">
                <thead>
                    <tr>
                        <th class="long">Pays/ organisation</th>
                        <th class="long">Statut réglementaire</th>
                        <th class="long">Type de produit</th>
                        <th class="long">% max autorisé</th>
                        <th style="width: 250px;">Type d'ingrédient réglementée</th>
                        <th class="long">Restriction particulières</th>
                        <th class="long">% max restriction</th>
                        <th class="long">Etiquetage à indiquer</th>
                        <th class="long">Seuil d'étiquetage</th>
                        <th class="long">Autre info réglementaire condition d'utilisation</th>
                        <th class="long">Seuil d'alerte</th>
                        <th class="long">Référence réglementaire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pays=table_all_queries('pays_organism',$bdd);
                    for($i=0;$i<count($res);$i++){//part entrée?>
                        <tr>
                            <td hidden><input type="text" name="index_reg_comp_<?php echo $i;?>" value="<?php echo $res[$i]['index_reg_comp'] ?>"> </td>
                            <td>
                                <select class="custom-select" name="Pays_org_<?php echo $i;?>">
                                    <?php
                                    for($j=0;$j<count($pays);$j++){
                                    ?>
                                    <option <?php echo ($pays[$j][0]==$res[$i]['Pays_org'])?"selected":"";?> ><?php echo $pays[$j][0];?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <select class="custom-select" name="Statut_reg_<?php echo $i;?>">
                                    <option value=""></option>
                                    <option <?php echo ($res[$i]['Statut_reg']=='Autorisé')?"selected":"";?> >Autorisé</option>
                                    <option <?php echo ($res[$i]['Statut_reg']=='Interdit')?"selected":"";?> >Interdit</option>
                                </select>
                            </td>
                            <td class="vv-long">
                                <select class="custom-select " name="Type_prod_<?php echo $i;?>">
                                    <option value=""></option>
                                    <option <?php echo ($res[$i]['Type_prod']=='Non rincé')?"selected":"";?> >Non rincé</option>
                                    <option <?php echo ($res[$i]['Type_prod']=='Rincé')?"selected":"";?> >Rincé</option>
                                </select>
                            </td>
                            <td><input type="text" name="%_max_auto_<?php echo $i;?>" value="<?php echo $res[$i]['%_max_auto']."%" ?>"> </td>
                            <td>
                                <select class="custom-select" name="Type_ingre_reg_<?php echo $i;?>">
                                    <option value=""></option>
                                    <option <?php echo ($res[$i]['Type_ingre_reg']=='Substance')?"selected":"";?> >Substance</option>
                                    <option <?php echo ($res[$i]['Type_ingre_reg']=='Substance exp en')?"selected":"";?> >Substance exp en</option>
                                    <option <?php echo ($res[$i]['Type_ingre_reg']=='Mélange')?"selected":"";?> >Mélange</option>
                                    <option <?php echo ($res[$i]['Type_ingre_reg']=='Mélange exp en')?"selected":"";?> >Mélange exp en</option>
                                </select>
                            </td>
                            <td><textarea name="Restric_part_<?php echo $i;?>" cols="20" rows="1"><?php echo $res[$i]['Restric_part'] ?></textarea> </td>
                            <td><input type="text" name="%_max_restric_<?php echo $i;?>" value="<?php echo $res[$i]['%_max_restric'] ?>"> </td>
                            <td><textarea name="Etiquetage_<?php echo $i;?>" cols="20" rows="1"><?php echo $res[$i]['Etiquetage'] ?></textarea> </td>
                            <td><input type="text" name="Seuil_etiqu_<?php echo $i;?>" value="<?php echo $res[$i]['Seuil_etiqu'] ?>"> </td>
                            <td><textarea name="Autre_info_reg_<?php echo $i;?>" cols="20" rows="1"><?php echo $res[$i]['Autre_info_reg'] ?></textarea> </td>
                            <td><input type="text" name="Seuil_alerte_<?php echo $i;?>" value="<?php echo $res[$i]['Seuil_alerte'] ?>"> </td>
                            <td><textarea name="Réf_reg_<?php echo $i;?>" cols="20" rows="1"><?php echo $res[$i]['Réf_reg'] ?></textarea> </td>
                            
                            <td>
                                <a class="btn btn-danger" style="border-radius:35%; padding: 0 .25rem;" onclick="location.href = 'index.php?comp_reg=trash&id=<?php echo $res[$i]['index_reg_comp'];?>'">
                                <i class="bi bi-x"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div>
                <button class="btn btn-success" style="margin:20px 0px;">
                    Enregistrer
                </button>
            </div>
            </form>
        <?php  
            
        }
    }
   
    ?>
    </div>