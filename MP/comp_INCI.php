<?php
    if(isset($_GET['MP_comp']) && $_SESSION['Code_MP']!=''){
        if($_GET['MP_comp']=="add"){
            $req=$bdd->prepare("INSERT INTO comp_INCI 
            (Code_MP_INCI)
            VALUES(:Code_MP)");
            $req->execute([
                'Code_MP'=> $_SESSION['Code_MP']
            ]);
        }
        elseif($_GET['MP_comp']=="save"){
            $res= table_to_table('matieres_premieres','comp_INCI','Code_MP_INCI','Code_MP_INCI',$_SESSION['Code_MP'],$bdd)->fetchAll();
            for($i=0;$i<count($res);$i++){
                $req=$bdd->prepare("UPDATE comp_INCI SET Code_MP_INCI=:Code_MP_INCI, Nom_INCI_comp=:Nom_INCI_comp ,Nat_comp=:Nat_comp ,N_CAS=:N_CAS ,N_EC=:N_EC, `%_comp_MP`=:comp_MP  WHERE index_INCI=:index_INCI");
                $req->execute([
                'Code_MP_INCI'=> $_SESSION["Code_MP"],
                'Nom_INCI_comp'=> $_POST["Nom_INCI_comp_$i"],
                'Nat_comp'=> $_POST["Nat_comp_$i"],
                'N_CAS'=> $_POST["N_CAS_$i"],
                'N_EC'=> $_POST["N_EC_$i"],
                'comp_MP' => str_replace("%", "", $_POST["%_comp_MP_$i"]),
                'index_INCI'=> $_POST["index_INCI_$i"]
            ]);
            }
        }
        elseif($_GET['MP_comp']=='trash'){
            $req=$bdd->prepare("DELETE FROM comp_INCI WHERE index_INCI=:index_INCI");
            $req->execute([
                'index_INCI'=> $_GET['id']
            ]);
        }
        if($_GET['MP_comp']=="push"){
            $data=table_single_query('comp_allerg','id_allerg',$_GET['id'],$bdd);
            $req=$bdd->prepare("INSERT INTO comp_INCI 
            (Code_MP_INCI, Nom_INCI_comp, `%_comp_MP`)
            VALUES(:Code_MP, :Nom_INCI_comp, :prcnt_aller_MP)");
            $req->execute([
                'Code_MP'=> $data['Code_MP_all'],
                'Nom_INCI_comp'=> $data['Nom_all_comp'],
                'prcnt_aller_MP'=>$data['%_aller_MP']
            ]);
        }

        
    }
?>


 
    <div>
    <?php
    if(isset($_SESSION['Code_MP'])){?>
        <div>
            <button class="btn btn-primary" style="margin:20px 0px;" onclick="location.href = 'index.php?MP_comp=add'">
            <i class="bi bi-plus-lg" ></i> Ajouter un composant à la MP
            </button>
        </div>
        <?php

        $comp=table_all_queries('composants',$bdd);
        $res= table_to_table('matieres_premieres','comp_INCI','Code_MP_INCI','Code_MP_INCI',$_SESSION['Code_MP'],$bdd,'ORDER BY `%_comp_MP` DESC')->fetchAll();
        $sum=0;
        if(count($res)!=0){?>
        <h5>La matière première a <?php echo count($res);?> composants </h5>
        <form action="index.php?MP_comp=save" method="POST">
            <table class="table">
                <thead>
                    <tr>
                        <th class="v-long">Nom INCI du composant</th>
                        <th class="lone">Nat. comp.</th>
                        <th class="long">N°CAS</th>
                        <th class="v-long">N°EC/EINECS/ELINCS</th>
                        <th class="long">% du composant dans la MP</th>
                        <th class="long">Fonction Principale</th>
                        <th class="long">Fonction Secondaire</th>
                        <th class="unique">Comp. rég. ou à risque</th>
                        <th class="lone"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for($i=0;$i<count($res);$i++){
                    $data=table_single_query('composants','Nom_INCI',$res[$i]['Nom_INCI_comp'],$bdd);
                    
                    ?>
                        <tr>
                            <td hidden><input type="text" name="index_INCI_<?php echo $i;?>" value="<?php echo $res[$i]['index_INCI'] ?>"> </td>
                            <td>
                                <select class="custom-select" name="Nom_INCI_comp_<?php echo $i;?>">
                                    <option value=""></option>
                                    <?php
                                    for($j=0;$j<count($comp);$j++){
                                    ?>
                                    <option <?php echo ($comp[$j]['Nom_INCI']==$res[$i]['Nom_INCI_comp'])?"selected":"";?> ><?php echo $comp[$j]['Nom_INCI'];?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <select class="custom-select" name="Nat_comp_<?php echo $i;?>">
                                    <option <?php echo ($res[$i]['Nat_comp']=='-')?"selected":"";?> >-</option>
                                    <option <?php echo ($res[$i]['Nat_comp']=='add')?"selected":"";?> >add</option>
                                    <option <?php echo ($res[$i]['Nat_comp']=='imp')?"selected":"";?> >imp</option>
                                </select>
                            </td>
                            <td><input type="text" name="N_CAS_<?php echo $i;?>" value="<?php echo $res[$i]['N_CAS']; ?>"></td>
                            <td><input type="text" name="N_EC_<?php echo $i;?>" value="<?php echo $res[$i]['N_EC'] ;?>"></td>
                            <td><input type="text" name="%_comp_MP_<?php echo $i;?>" value="<?php echo $res[$i]['%_comp_MP']."%"?>"></td>
                            <td><input type="text" readonly value="<?php echo ($data)?$data['Fonct_prin']:"" ;?>"></td>
                            <td><input type="text" readonly value="<?php echo ($data)?$data['Fonct_sec']:""  ;?>"></td>
                            <td><input type="checkbox" disabled <?php echo ($data && $data['Comp_reg_risk']=='VRAI')?"checked":""?> ></td>
                            <td>
                                <a class="btn btn-danger" style="border-radius:35%;padding: 0 .25rem;" onclick="location.href = 'index.php?MP_comp=trash&id=<?php echo $res[$i]['index_INCI'];?>'">
                                <i class="bi bi-x"></i>
                                </a>
                            </td>
                            <td class="lone">
                                <a class="btn btn-outline-secondary" style="border-radius:5px;padding: 0 .25rem;" onclick="location.href = '../compo/index.php?code=<?php echo $res[$i]['Nom_INCI_comp'];?>'">
                                    info
                                </a>
                            </td>
                        </tr>
                    <?php
                    if($data && $res[$i]['Nat_comp']!='imp'){
                        $sum+=$res[$i]['%_comp_MP'];
                    }
                } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td style="background-color: #EEE;" colspan=3 >Calcule d'ingrédient qsp100%</td>
                        <td> <input class="long" type="text"  value="<?php echo number_format(100-$sum, 4, '.', '').'%';?>"></td>
                    </tr>
                </tfoot>
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