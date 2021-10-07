<?php
    if(isset($_GET['notif_compo']) && isset($_SESSION['Nom_INCI'])){
        if($_GET['notif_compo']=="add"){
            $req=$bdd->prepare("INSERT INTO reglement_notif_comp (Nom_INCI_notif) VALUES (:Nom_INCI_notif)");
            $req->execute(['Nom_INCI_notif'=> $_SESSION['Nom_INCI']]);
        }
        elseif($_GET['notif_compo']=="save"){
            $res= table_to_table('composants','reglement_notif_comp','Nom_INCI_notif','Nom_INCI_notif',$_SESSION['Nom_INCI'],$bdd)->fetchAll();
            for($i=0;$i<count($res);$i++){
                table_save_data_reg('reglement_notif_comp',$bdd,$_POST,$i,'Nom_INCI_notif',$_SESSION['Nom_INCI']);
            }
        }
        elseif($_GET['notif_compo']=='trash'){
            $req=$bdd->prepare("DELETE FROM reglement_notif_comp WHERE index_notif_comp=:index_notif_comp");
            $req->execute([
                'index_notif_comp'=> $_GET['id']
            ]);
        }

        
    }
?>

    <div>
    <?php
    if(isset($_SESSION['Nom_INCI'])){?>
        <div>
            <button class="btn btn-primary" style="margin:20px 0px;" onclick="location.href = 'index.php?notif_compo=add'">
            <i class="bi bi-plus-lg" ></i> Ajouter une notification au composant
            </button>
        </div>
        <?php
        $res= table_to_table('composants','reglement_notif_comp','Nom_INCI_notif','Nom_INCI_notif',$_SESSION['Nom_INCI'],$bdd)->fetchAll();
        if(count($res)!=0){?>
        <h5>Le composant a <?php echo count($res);?> lignes de réglementation </h5>
        <form action="index.php?notif_compo=save" method="POST">
            <table class="table" style="font-size:10px; ">
                <thead>
                    <tr>
                        <th class="vv-long">Catégorie de notification du composant</th>
                        <th class="long">Type de produit</th>
                        <th class="long">Type d'ingrédient réglementation</th>
                        <th class="long">Seuil de notification</th>
                        <th style="width: 250px;">Commentaire de notification</th>
                        <th class="long">Réference réglementaire notification</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ref=get_single_attribut('reglement_notif_comp','Ref_reg_notif',$bdd);
                    $cat_notif=table_all_queries('categories_notif',$bdd);
                    for($i=0;$i<count($res);$i++){//part entrée
                     ?>
                        <tr>
                            <td hidden><input type="text" name="index_notif_comp_<?php echo $i;?>" value="<?php echo $res[$i]['index_notif_comp'] ?>"> </td>
                            <td>
                                <select class="custom-select" name="Cat_notif_comp_<?php echo $i;?>">
                                    <option value=""></option>
                                    <?php
                                    for($j=0;$j<count($cat_notif);$j++){
                                    ?>
                                    <option <?php echo ($cat_notif[$j][0]==$res[$i]['Cat_notif_comp'])?"selected":"";?> ><?php echo $cat_notif[$j][0];?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="vv-long">
                                <select class="custom-select " name="Type_prod_<?php echo $i;?>">
                                    <option value=""></option>
                                    <option <?php echo ($res[$i]['Type_prod']=='Non rincé')?"selected":"";?> >Non rincé</option>
                                    <option <?php echo ($res[$i]['Type_prod']=='Rincé')?"selected":"";?> >Rincé</option>
                                </select>
                            </td>
                            <td>
                                <select class="custom-select" name="Type_ingre_reg_<?php echo $i;?>">
                                    <option value=""></option>
                                    <option <?php echo ($res[$i]['Type_ingre_reg']=='Substance')?"selected":"";?> >Substance</option>
                                    <option <?php echo ($res[$i]['Type_ingre_reg']=='Substance exp en')?"selected":"";?> >Substance exp en</option>
                                    <option <?php echo ($res[$i]['Type_ingre_reg']=='Mélange')?"selected":"";?> >Mélange</option>
                                    <option <?php echo ($res[$i]['Type_ingre_reg']=='Mélange exp en')?"selected":"";?> >Mélange exp en</option>
                                </select>
                            </td>
                            <td><input type="text" name="Seuil_notif_<?php echo $i;?>" value="<?php echo $res[$i]['Seuil_notif']."%" ?>"> </td>
                            <td><textarea name="Com_notif_<?php echo $i;?>" cols="50" rows="1"><?php echo $res[$i]['Com_notif'] ?></textarea> </td>
                            <td>
                            <input list="ref_reg_notif" name="Ref_reg_notif_<?php echo $i;?>" value="<?php echo $res[$i]['Ref_reg_notif']?>"> 
                                <datalist id="ref_reg_notif">
                                    <?php
                                        for($k=0;$k<count($ref);$k++){
                                    ?>
                                        <option value="<?php echo $ref[$k][0]?>"></option>
                                    <?php } ?>
                                </datalist>
                            </td>
                            <td>
                                <a class="btn btn-danger" style="border-radius:35%; padding: 0 .25rem;" onclick="location.href = 'index.php?notif_compo=trash&id=<?php echo $res[$i]['index_notif_comp'];?>'">
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