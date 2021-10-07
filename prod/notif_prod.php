

<?php
    $data=table_single_nquery('produits',$_SESSION['id_prod'],$bdd);
    if(isset($_GET['notif_prod']) && $data){
        
        if($_GET['notif_prod']=="add"){
            $req=$bdd->prepare("INSERT INTO cat_notif_prod 
            (Code_RD_notif)
            VALUES(:Code_RD)");
        $req->execute([
            'Code_RD'=> $data['Code_RD_prod']
            ]);
        }
        elseif($_GET['notif_prod']=="save"){
            $res= table_to_table('produits','cat_notif_prod','Code_RD_notif','Code_RD_notif',$data['Code_RD_prod'],$bdd)->fetchAll();
            for($i=0;$i<count($res);$i++){
                $req=$bdd->prepare("UPDATE cat_notif_prod SET Cat_notif_prod=:Cat_notif_prod, Code_RD_notif=:Code_RD_notif WHERE id_notif_prod= :id_notif_prod");
                $req->execute([
                'Cat_notif_prod'=> $_POST["Cat_notif_prod_$i"],
                'Code_RD_notif'=> $data["Code_RD_prod"],
                'id_notif_prod'=> $_POST["id_notif_prod_$i"]
            ]);
            }
        }
        elseif($_GET['notif_prod']=="trash"){
            $req=$bdd->prepare("DELETE FROM cat_notif_prod WHERE id_notif_prod= :id_notif_prod");
            $req->execute([
                'id_notif_prod'=> $_GET['id']
            ]);
        }
    }
?>



    <h4 class=" title">
         Catégorie(s) de notification du produit
    </h4>
    <div class="comp_form_prod">
    <?php
    if(isset($data)) { ?>
        <div>
            <button class="btn btn-primary" style="margin:20px 0px;" onclick="location.href = 'index.php?notif_prod=add'">
            <i class="bi bi-plus-lg" ></i> Ajouter une Notification
            </button>
        </div>
        <form action="index.php?notif_prod=save" method="POST">
        <?php
        $res= table_to_table('produits','cat_notif_prod','Code_RD_notif','Code_RD_notif',$data['Code_RD_prod'],$bdd)->fetchAll();
        if(count($res)!=0){
            ?>Le produits a <?php echo count($res);?> catégories de notification </br>
                <table class="table">
                <thead>
                    <tr>
                        <th class="vv-long">Catégorie notification</th>
                        <th class="lone"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for($i=0;$i<count($res);$i++){
                        $_SESSION['id_notif_prod']=$res[$i]['id_notif_prod']
                    ?>
                        <tr>
                            <td hidden><input type="text" name="id_notif_prod_<?php echo $i;?>" value="<?php echo $res[$i]['id_notif_prod'] ?>"> </td>
                            <td class="vv-long">  
                                <select class="custom-select" name="Cat_notif_prod_<?php echo $i;?>">
                                    <option value=""> </option>
                                    <?php
                                    $data=table_all_queries('Categories_notif',$bdd);
                                    for($j=0;$j<count($data);$j++){
                                    ?>
                                    <option <?php echo (($res) && $data[$j]['Cat_notif']==$res[$i]['Cat_notif_prod'])?"selected":"";?> >
                                    <?php echo $data[$j]['Cat_notif'];?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <a class="btn btn-danger" style="border-radius:35%;padding: 0 .25rem;" onclick="location.href = 'index.php?notif_prod=trash&id=<?php echo $_SESSION['id_notif_prod'];?>'">
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
            <?php } ?>
        </form>
    </div>

