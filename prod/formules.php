<?php

$_SESSION['ref_form']=NULL;
    $data=table_single_nquery('produits',$_SESSION['id_prod'],$bdd);
    if(isset($data) && $data){
        $res_forms= table_to_table('produits','formules','Code_RD','Code_RD',$data['Code_RD_prod'],$bdd)->fetchAll();
        $nb_form=count($res_forms);
        if($nb_form!=0){
            ?>
            <div class="mb-5">
                <h2>Liste des formules du produit</h2>
                <form action="../formules/index.php" method="POST">
                    <?php
                    ?>
                    <h4>Le produit a <?php echo $nb_form;?> formules</h4>
                    
                    <?php
                    for($i=0;$i<$nb_form;$i++){
                        ?><input type="submit"  name="ref_form" style="margin: 2px;" value="<?php echo $res_forms[$i]['Ref_form'] ?>"></br>
                    <?php
                        }
                    ?>
                </form>
            </div>
            
            <?php
        }?>
        <form action="../formules/index.php?modif=add_form&main=true" method="POST"  style="display:flex;flex-direction:column;">
            <button class="btn btn-success"><i class="bi bi-plus-lg" ></i> Ajouter</button>
        </form>
    <?php } ?>
