<?php
   if(isset($_GET['distri']) && $_SESSION['Code_MP']!=''){
        if($_GET['distri']=="add"){
            $res= table_to_table('matieres_premieres','class_distri_MP','Code_MP_distr','Code_MP_distr',$_SESSION['Code_MP'],$bdd)->fetchAll();
            $req=$bdd->prepare("INSERT INTO class_distri_MP 
            (Code_MP_distr, N_distri_MP) 
            VALUES (:Code_MP, :Num)");
            $req->execute([
                'Code_MP'=> $_SESSION['Code_MP'],
                'Num'=> (count($res)+1)
            ]);
        }
        elseif($_GET['distri']=="save"){
            $res= table_to_table('matieres_premieres','class_distri_MP','Code_MP_distr','Code_MP_distr',$_SESSION['Code_MP'],$bdd)->fetchAll();
            for($i=0;$i<count($res);$i++){
                $req=$bdd->prepare("UPDATE class_distri_MP SET 
                N_distri_MP=:N_distri_MP,
                Nom_distri_MP=:Nom_distri_MP,
                Statut_REACH=:Statut_REACH 
                WHERE id_class_distri=:id_class_distri");
                $req->execute([
                'N_distri_MP'=> $_POST["N_distri_MP_$i"],
                'Nom_distri_MP'=> $_POST["Nom_distri_MP_$i"],
                'Statut_REACH' => $_POST["Statut_REACH_$i"],
                'id_class_distri'=> $_POST["id_class_distri_$i"]
            ]);
            }
        }
        elseif($_GET['distri']=='trash'){
            $req=$bdd->prepare("DELETE FROM class_distri_MP WHERE id_class_distri=:id_class_distri");
            $req->execute([
                'id_class_distri'=> $_GET['id']
            ]);
        }

        
    }
?><!-- mettre un bon système de gestion des lignes-->


    <div>
    <?php
    if(isset($_SESSION['Code_MP'])){?>
        <div>
            <button class="btn btn-primary" style="margin-bottom:20px;" onclick="location.href = 'index.php?distri=add'">
            <i class="bi bi-plus-lg" ></i> Ajouter un distributeur à la MP
            </button>
        </div>
        <?php
        $res= table_to_table('matieres_premieres','class_distri_MP','Code_MP_distr','Code_MP_distr',$_SESSION['Code_MP'],$bdd,'ORDER BY N_distri_MP ASC')->fetchAll();
        if(count($res)!=0){?>
        <h5>La matière première a <?php echo count($res);?> distributeurs </h5>
        <form action="index.php?distri=save" method="POST">
            <table class="table" style="width:70%;">
                <colgroup>
                    <col span="1" style="width: 10%;">
                    <col span="1" style="width: 45%;"> 
                    <col span="1" style="width: 45%;">
                </colgroup>
                <thead>
                    <tr>
                        <th class="lone">N°</th>
                        <th class="vv-long">Nom du distributeur</th>
                        <th class="vv-long">Statut REACH</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $statut=get_single_attribut('class_distri_MP','Statut_REACH',$bdd);
                    for($i=0;$i<count($res);$i++){
                        $distr=$bdd->query("SELECT * FROM distributeur_MP ORDER BY Nom_distributeur ")->fetchAll();
                        ?>
                        <tr style="text-align:left;">
                            <td hidden><input type="text" name="id_class_distri_<?php echo $i;?>" value="<?php echo $res[$i]['id_class_distri'] ;?>"> </td>
                            <td><input class="lone"  name="N_distri_MP_<?php echo $i; ?>" type="text"  value="<?php echo ($i+1); ?>"></td>
                            <td>
                                <select class="custom-select" name="Nom_distri_MP_<?php echo $i;?>">
                                <option value=""></option>
                                    <?php
                                    for($j=0;$j<count($distr);$j++){
                                    ?>
                                    <option <?php echo ($distr[$j]['Nom_distributeur']==$res[$i]['Nom_distri_MP'])?"selected":"";?> ><?php echo $distr[$j]['Nom_distributeur'];?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td><input list="statut" name="Statut_REACH_<?php echo $i;?>" value="<?php echo $res[$i]['Statut_REACH']?>"> 
                                <datalist id="statut">
                                    <?php
                                        for($k=0;$k<count($statut);$k++){
                                    ?>
                                        <option value="<?php echo $statut[$k][0]?>"></option>
                                    <?php } ?>
                                </datalist>
                            </td>
                            <td style="width: 15px;">
                                <a class="btn btn-danger" style="border-radius:35%; padding: 0 .25rem;" onclick="location.href = 'index.php?distri=trash&id=<?php echo $res[$i]['id_class_distri'];?>'">
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