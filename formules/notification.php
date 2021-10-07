

<?php
    if(isset($_GET['notif'])){
        if($_GET['notif']=="add"){
            $ref=$_SESSION['ref_form'];
            $sql="INSERT INTO notifications (Ref_RD_notif) VALUES ('$ref')";
            $req=$bdd->exec($sql);
        
        }
        elseif($_GET['notif']=="save"){
            $res= table_to_table('formules','notifications','Ref_RD_notif','Ref_RD_notif',$_SESSION['ref_form'],$bdd)->fetchAll();
            for($i=0;$i<count($res);$i++){
                table_save_data_notif('notifications',$bdd,$_POST,$i,'Ref_RD_notif',$_SESSION['ref_form']);
            }
        }
        elseif($_GET['notif']=="trash"){
            $req=$bdd->prepare("DELETE FROM notifications WHERE id_notif= :id_notif");
            $req->execute([
                'id_notif'=> $_GET['id']
            ]);
        }
    }
?>


<div class="comp_form_prod">
<?php
if(isset($_SESSION['ref_form'])) { ?>
    <div>
        <button class="btn btn-primary" style="margin:20px 0px;" onclick="location.href = 'index.php?notif=add'">
        <i class="bi bi-plus-lg" ></i> Ajouter une notification
        </button>
    </div>
    <form action="index.php?notif=save" method="POST">
    <?php
    $res= table_to_table('formules','notifications','Ref_RD_notif','Ref_RD_notif',$_SESSION['ref_form'],$bdd)->fetchAll();
        ?>La formule a <?php echo count($res);?> notification(s) </br>
            <table class="table">
            <thead>
                <tr>
                    <th class="vv-long">Société</th>
                    <th class="vv-long">Nom commercial</th>
                    <th class="vv-long">N°enregistrement</th>
                    <th class="vv-long">N°enregistrement précédent</th>
                    <th class="vv-long">Saisie et validation de la notification</th>
                    <th class="lone"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                for($i=0;$i<count($res);$i++){
                    $_SESSION['id_notif']=$res[$i]['id_notif']
                ?>
                    <tr>
                        <td hidden><input type="text" name="id_notif_<?php echo $i;?>" value="<?php echo $res[$i]['id_notif'] ?>"> </td>
                        <td class="vv-long">
                            <select class="custom-select " name="Société_<?php echo $i;?>">
                                <option value=""></option>
                                <option <?php echo ($res[$i]['Société']=='Les Laboratoires ASEPTA')?"selected":"";?> >Les Laboratoires ASEPTA</option>
                                <option <?php echo ($res[$i]['Société']=='Société Anonyme de Savonnerie et Dentifrice (S.E.D.)')?"selected":"";?> >Société Anonyme de Savonnerie et Dentifrice (S.E.D.)</option>
                                <option <?php echo ($res[$i]['Société']=='Laboratoires ADAM')?"selected":"";?> >Laboratoires ADAM</option>
                            </select>
                        </td>
                        </td>
                        <td class="vv-long"><textarea name="Nom_com_notif_<?php echo $i;?>" cols="30" rows="2"><?php echo $res[$i]['Nom_com_notif'] ?></textarea>
                        <td class="vv-long"><input  type="text" name="N_enre_notif_<?php echo $i;?>" value="<?php echo $res[$i]['N_enre_notif'] ?>"></td>
                        <td class="vv-long"><input  type="text" name="N_enre_ancien_notif_<?php echo $i;?>" value="<?php echo $res[$i]['N_enre_ancien_notif'] ?>"></td>
                        <td>
                        <table class="table">
                            <tr>
                                <td>Saisie le: </td>
                                <td><input  type="date" name="Date_notif_<?php echo $i;?>" value="<?php echo $res[$i]['Date_notif'] ?>"></td>
                            </tr>
                            <tr>
                                <td>
                                    <input  type="checkbox" name="Notif_Val_RD_<?php echo $i;?>" <?php echo ($res[$i]['Notif_Val_RD']=="VRAI")?"checked":"";?> >
                                    Validation RD
                                </td>
                                <td><input  type="date" name="Date_val_RD_<?php echo $i;?>" value="<?php echo $res[$i]['Date_val_RD'] ?>"></td>
                            </tr>
                            <tr>
                            <td>
                                <input type="checkbox" name="Notif_Val_AR_<?php echo $i;?>" <?php echo ($res[$i]['Notif_Val_AR']=="VRAI")?"checked":"";?> >
                                Validation AR
                            </td>
                                <td><input  type="date" name="Date_val_AR_<?php echo $i;?>" value="<?php echo $res[$i]['Date_val_AR'] ?>"></td>
                            </tr>
                        </table>
                        </td>
                        
                        <td >
                            <a class="btn btn-danger" style="border-radius:35%;padding: 0 .25rem;" onclick="location.href = 'index.php?notif=trash&id=<?php echo $_SESSION['id_notif'];?>'">
                            <i class="bi bi-x"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
        <div>
            <button class="btn btn-success" style="margin:20px 0px;">
            Enregistrer
            </button>
        </div>
    </form>
</div>


