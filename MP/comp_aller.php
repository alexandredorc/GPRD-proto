<?php
    if(isset($_GET['allerg']) && $_SESSION['Code_MP']!=''){
        if($_GET['allerg']=="add"){
            $req=$bdd->prepare("INSERT INTO comp_allerg 
            (Code_MP_all)
            VALUES(:Code_MP)");
            $req->execute([
                'Code_MP'=> $_SESSION['Code_MP']
            ]);
        }
        elseif($_GET['allerg']=="save"){
            $res= table_to_table('matieres_premieres','comp_allerg','Code_MP_all','Code_MP_all',$_SESSION['Code_MP'],$bdd)->fetchAll();
            for($i=0;$i<count($res);$i++){
                $req=$bdd->prepare("UPDATE comp_allerg SET Code_MP_all=:Code_MP_all, Nom_all_comp=:Nom_all_comp , `%_aller_MP`=:aller_MP WHERE id_allerg=:id_allerg");
                $req->execute([
                'Code_MP_all'=> $_SESSION["Code_MP"],
                'Nom_all_comp'=> $_POST["Nom_all_comp_$i"],
                'aller_MP' => str_replace("%", "", $_POST["%_aller_MP_$i"]),
                'id_allerg'=> $_POST["id_allerg_$i"]
            ]);
            }
        }
        elseif($_GET['allerg']=='trash'){
            $req=$bdd->prepare("DELETE FROM comp_allerg WHERE id_allerg=:id_allerg");
            $req->execute([
                'id_allerg'=> $_GET['id']
            ]);
        }

        
    }
?>

    <div>
    <?php
    if(isset($_SESSION['Code_MP'])){?>
        <div>
            <button class="btn btn-primary" style="margin-bottom:20px;" onclick="location.href = 'index.php?allerg=add'">
            <i class="bi bi-plus-lg" ></i> Ajouter un allergène à la MP
            </button>
        </div>
        <?php
        $res= table_to_table('matieres_premieres','comp_allerg','Code_MP_all','Code_MP_all',$_SESSION['Code_MP'],$bdd,'ORDER BY `%_aller_MP` DESC')->fetchAll();
        if(count($res)!=0){
            ?>
        <h5>La matière première a <?php echo count($res);?> allergènes </h5>
        <form action="index.php?allerg=save" method="POST">
            <table class="table" style="max-width:800px;">
                <colgroup>
                    <col span="1" style="width: 30%;">
                    <col span="1" style="width: 15%;"> 
                    <col span="1" style="width: 15%;">
                    <col span="1" style="width: 15%;"> 
                    <col span="1" style="width: 5%;">
                    <col span="1" style="width: 5%;"> 
                    <col span="1" style="width: 15%;">
                </colgroup>
                <thead>
                    <tr>
                        <th class="v-long">Nom INCI de l'Allergène</th>
                        <th class="long">N°CAS</th>
                        <th class="v-long">N°EC/EINECS/ELINCS</th>
                        <th class="long">% allergènes dans la MP</th>
                        <th class="unique">All reg</th>
                        <th class="lone"></th>
                        <th class="lone">appuyer pour mettre en composant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $maxAll=false;
                    for($i=0;$i<count($res);$i++){
                    $data=table_single_query('allergenes','Nom_INCI_all',$res[$i]['Nom_all_comp'],$bdd);
                    $all=table_all_queries('allergenes',$bdd);
                    if(!$maxAll || $maxAll<$res[$i]['%_aller_MP']){
                        $maxAll=$res[$i]['%_aller_MP'];
                    }
                    
                    ?>
                        <tr>
                            <td hidden><input type="text" name="id_allerg_<?php echo $i;?>" value="<?php echo $res[$i]['id_allerg'] ?>"> </td>
                            <td>
                                <select class="custom-select" name="Nom_all_comp_<?php echo $i;?>">
                                    <option value=""></option>
                                    <?php
                                    for($j=0;$j<count($all);$j++){
                                    ?>
                                    <option <?php echo ($all[$j]['Nom_INCI_all']==$res[$i]['Nom_all_comp'])?"selected":"";?> ><?php echo $all[$j]['Nom_INCI_all'];?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <!-- voir pour mettre du JS en eventlistener-->
                            <td><input type="text" readonly value="<?php echo ($data)?$data['NCAS_all']:"" ?>"></td>
                            <td><input type="text" readonly value="<?php echo ($data)?$data['NEC_all']:"" ?>"></td>
                            <td><input type="text" name="%_aller_MP_<?php echo $i;?>" value="<?php echo $res[$i]['%_aller_MP']."%"?>"></td>
                            <td><input type="checkbox" disabled <?php echo ($data && $data['All_reg']=='VRAI')?"checked":""?> ></td>
                            <td>
                                <a class="btn btn-danger" style="border-radius:35%;padding: 0 .25rem;" onclick="location.href = 'index.php?allerg=trash&id=<?php echo $res[$i]['id_allerg'];?>'">
                                <i class="bi bi-x"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-outline-secondary" style="border-radius:5px;padding: 0 .25rem;" onclick="location.href = 'index.php?MP_comp=push&id=<?php echo $res[$i]['id_allerg'];?>'">
                                    push
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
            if(count($res)!=0 && $maxAll!=0){
              ?>
            <table class="table">
                <tr>
                    <td>allergène(s) étiquetable à partir de </td>
                    <td><i class="bi bi-arrow-right" style="font-size:20px;"></i></td>
                    <td class="long"><input type="text" readonly value="<?php echo round(0.1/$maxAll,6)."%" ?>"></td>
                    <td> dans les produits non rincés</td>
                </tr>
                <tr>
                    <td>allergène(s) étiquetable à partir de </td>
                    <td><i class="bi bi-arrow-right" style="font-size:20px;"></i></td>
                    <td class="long"><input type="text" readonly value="<?php echo round(1/$maxAll,6)."%" ?>"></td>
                    <td> dans les produits rincés</td>
                </tr>
            </table>
        <?php  
            }
        }
    }
    ?>
</div>