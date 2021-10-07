<?php
if(isset($_GET['main'])){
    $data=table_single_nquery('produits',$_SESSION['id_prod'],$bdd);
    $data=$data['Code_RD_prod'];
}
if(isset($_GET['erreur']) && $_GET['erreur']==1){
    $data=table_single_nquery('produits',$_SESSION['id_prod'],$bdd);
    $data=$data['Code_RD_prod'];
    $erreur=true;
}?>

<div class="body-center" style="max-width:none;">
    <form action="index.php?modif=push_form" method="POST">
        <h1>Ajouter une formule</h1>
        <table class="table">
            <tr>
                <th>
                    Réference Formule <input type="text" class="form-control" name="Ref_form">
                </th>
                <th>
                    Code R&D <input type="text" class="form-control" name="Code_RD" value="<?php echo (isset($data)?$data:"");?>">
                </th>
            </tr>
        </table>
    <button class="btn btn-success">
        <strong>Ajouter</strong>
    </button>
    <?php if(isset($erreur) && $erreur){
        ?>
        <div class="erreur">
            la réference qui à été renseigné existe déjà
        </div>
    <?php } ?>
    </form>
</div>
