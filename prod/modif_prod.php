<?php

if(isset($_POST['mod_prod'])){
    $_SESSION['mod_prod']=$_POST['mod_prod'];
}elseif(!isset($_SESSION['mod_prod'])){
   // $_SESSION['mod_prod']="1";
}

$res=$bdd->query("select * from produits where Code_RD_prod='".$_SESSION['mod_prod']."'");
$res=$res->fetchAll();
if(count($res)==1){
    $res=$res[0];
}else{$res=false;}

?>
<div class="body-center" style="max-width:none;">
    <form action="index.php?modif=produit" style="margin:30px;" method="POST">
        <h4>Changement code R&D rapide</h4>
        <div class="input-group">
            <input type="text" class="form-control" name="mod_prod" style="max-width:120px;">
            <button class="btn btn-outline-secondary" ><i class="bi bi-search"></i></button></br>
        </div>
    </form>
    
    <h1>Modifier un produit</h1>
    <form action="index.php?modif=change_prod" method="POST">
    <table class="table">
        <tr>
            <th>
                
                Code R&D <input type="text" class="form-control" name="Code_RD_prod" value="<?php echo ($res)?$res['Code_RD_prod']:"";?>">
            </th>
            <th>
                Gamme R&D <input type="text" class="form-control" name="Gamme_RD" value="<?php echo ($res)?$res['Gamme_RD']:"";?>">
            </th>
            <th>
                Ligne R&D <input type="text" class="form-control" name="Ligne_RD" value="<?php echo ($res)?$res['Ligne_RD']:"";?>">
            </th>
        </tr>
        <tr>
            <th>
                Nom R&D <input type="text" class="form-control" name="Nom_RD" value="<?php echo ($res)?$res['Nom_RD']:"";?>">
            </th>
            <th>
                Catégorie Prod 
                <select class="custom-select" name="Cat_prod">
                    <option value="" > </option>
                    <option value="Non rincé" <?php echo (($res) && "Non rincé"==$res['Cat_prod'])?"selected":"";?> >
                    Non rincé</option>
                    <option value="Rincé" <?php echo (($res) && "Rincé"==$res['Cat_prod'])?"selected":"";?> >
                    Rincé</option>
                </select>
            </th>
            <th>
                Catégorie IFRA 
                <select class="custom-select" name="Cat_IFRA_prod">
                    <option value=""> </option>
                    <?php
                    $data=table_all_queries('Categorie_IFRA',$bdd);
                    for($i=0;$i<count($data);$i++){
                    ?>
                    <option <?php echo (($res) && $data[$i]['Cate_IFRA']==$res['Cat_IFRA_prod'])?"selected":"";?> >
                    <?php echo $data[$i]['Cate_IFRA'];?>
                    </option>
                    <?php } ?>
                </select>
            </th>
        </tr>
    </table>
    <div style="margin:20px;">
            <button class="btn btn-success" name="btn" value="change">
                <strong>Enregistrer</strong>
            </button>

            <button class="btn btn-danger" name="btn" value="suppr">
                <strong>Supprimer</strong>
            </button>
        </div>
    </form>
</div>
