<?php
    if(isset($_GET['reg_IFRA']) && $_SESSION['Code_MP']!=''){
        if($_GET['reg_IFRA']=="add"){
            $req=$bdd->prepare("INSERT INTO reg_MP_IFRA 
            (Code_MP_IFRA)
            VALUES(:Code_MP)");
            $req->execute([
                'Code_MP'=> $_SESSION['Code_MP']
            ]);
        }
        elseif($_GET['reg_IFRA']=="save"){
            $res= table_to_table('matieres_premieres','reg_MP_IFRA','Code_MP_IFRA','Code_MP_IFRA',$_SESSION['Code_MP'],$bdd)->fetchAll();
            for($i=0;$i<count($res);$i++){
                $req=$bdd->prepare("UPDATE reg_MP_IFRA SET Code_MP_IFRA=:Code_MP_IFRA, Cat_IFRA_MP=:Cat_IFRA_MP , `%_max_IFRA`=:max_IFRA WHERE id_reg_IFRA=:id_reg_IFRA");
                $req->execute([
                'Code_MP_IFRA'=> $_SESSION["Code_MP"],
                'Cat_IFRA_MP'=> $_POST["Cat_IFRA_MP_$i"],
                'max_IFRA' => str_replace("%", "", $_POST["%_max_IFRA_$i"]),
                'id_reg_IFRA'=> $_POST["id_reg_IFRA_$i"]
            ]);
            }
        }
        elseif($_GET['reg_IFRA']=='trash'){
            $req=$bdd->prepare("DELETE FROM reg_MP_IFRA WHERE id_reg_IFRA=:id_reg_IFRA");
            $req->execute([
                'id_reg_IFRA'=> $_GET['id']
            ]);
        }
    }
?>

    <div>
    <?php
    if(isset($_SESSION['Code_MP'])){?>
        <div>
            <button class="btn btn-primary" style="margin:20px 0px;" onclick="location.href = 'index.php?reg_IFRA=add'">
            <i class="bi bi-plus-lg" ></i> Ajouter une réglementation IFRA
            </button>
        </div>
        <?php
        $res= table_to_table('matieres_premieres','reg_MP_IFRA','Code_MP_IFRA','Code_MP_IFRA',$_SESSION['Code_MP'],$bdd)->fetchAll();
        if(count($res)!=0){?>
        <form action="index.php?reg_IFRA=save" method="POST">
        
            <table class="table">
                <thead>
                    <tr>
                        <th class="long">Catégorie IFRA</th>
                        <th class="vv-long">Pourcentage max IFRA</th>
                        <th class="vv-long">Type de produits finis</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $minPrcnt=101;
                    $tab=array();
                    for($i=0;$i<count($res);$i++){
                        $data=table_single_query('categorie_IFRA','Cate_IFRA',$res[$i]['Cat_IFRA_MP'],$bdd);

                        if($res[$i]['%_max_IFRA']!="" && $res[$i]['%_max_IFRA']<$minPrcnt && $res[$i]['%_max_IFRA']>=2){
                            $minPrcnt=$res[$i]['%_max_IFRA'];
                        }
                        if($res[$i]['%_max_IFRA']<2){
                            $tab[]=array(($data)?$data['Type_prod_short']:"",$res[$i]['%_max_IFRA']);
                        }
                        $columns = array_column($tab, 1);
                        array_multisort($columns, SORT_NATURAL, $tab);
                        $_SESSION['id_IFRA']=$res[$i]['id_reg_IFRA'];
                       
                    ?>
                        <tr>
                            <td hidden><input type="text" name="id_reg_IFRA_<?php echo $i;?>" value="<?php echo $res[$i]['id_reg_IFRA'] ?>"> </td>
                            
                            <td class="unique">
                                <select class="custom-select" name="Cat_IFRA_MP_<?php echo $i;?>">
                                    <option value=""></option>
                                    <?php
                                    $cat=table_all_queries('Categorie_IFRA',$bdd);
                                    for($j=0;$j<count($cat);$j++){
                                    ?>
                                    <option <?php echo ( $cat[$j]['Cate_IFRA']==$res[$i]['Cat_IFRA_MP'])?"selected":"";?> ><?php echo $cat[$j]['Cate_IFRA'];?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="vv-long"><input  type="text" name="%_max_IFRA_<?php echo $i;?>" value="<?php echo ($res[$i]['%_max_IFRA']!="")?$res[$i]['%_max_IFRA']."%":"0%" ; ?>"></td>
                            <td class="vv-long"><textarea cols="100" rows="1"><?php echo ($data)?$data['Type_prod_short']:"";?></textarea></td>
                            <td>
                                <a class="btn btn-danger" style="border-radius:35%;padding: 0 .25rem;" onclick="location.href = 'index.php?reg_IFRA=trash&id=<?php echo $_SESSION['id_IFRA'];?>'">
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
        
            <div>
                <h5>% max IFRA ok pour tout produits</h5>
                <?php 
                if($minPrcnt>=2 && $minPrcnt!=101){
                ?>
                    <input type="text" value="<?php echo "  ".$minPrcnt."%";?>">
                <?php
                }?>
            </div>
                
        
        <table class="table">
            
            <?php
            if(count($tab)!=0){
                ?><h5>
                    Sauf Catégorie &lt; 2%
                </h5><?php
            }
            for($i=0;$i<count($tab);$i++){?>
                <tr>
                    <td class="vv-long" style="width:75%;">
                        <textarea style="width:100%;" rows="1"><?php echo $tab[$i][0]; ?></textarea>
                    </td>
                    <td class="v-long">
                        <input type="text" value="<?php echo ($tab)?$tab[$i][1]."%":"0%"; ?>">
                    </td>
                </tr>
            <?php } ?>
        </table>

    <?php }
    } ?>
    </div>