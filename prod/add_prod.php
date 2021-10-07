<?php
if(isset($_GET['erreur']) && $_GET['erreur']==1){
    $erreur=true;
}?>

<div class="body-center" style="max-width:none;">
        
        <form action="index.php?modif=push_prod" method="POST">
        <h1>Ajouter un produit</h1>
        <table class="table">
            <tr>
                <th>
                    Code R&D produit <input type="text" class="form-control" name="Code_RD_prod">
                </th>
                <th>
                    Nom produit <input type="text" class="form-control" name="Nom_RD">
                </th>
            </tr>
        </table>
    <button class="btn btn-success">
        <strong>Ajouter</strong>
    </button>
    <?php if(isset($erreur) && $erreur){
        ?>
        <div class="erreur">
            le code produit qui à été renseigné existe déjà
        </div>
    <?php } ?>
    </form>
</div>
