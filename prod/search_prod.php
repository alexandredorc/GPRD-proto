
<div class="body-center" style="max-width:none;">
    <form action="index.php?recherche=end_produit" method="POST">
        <h1>Recherche d'un produit</h1>
        <table class="table">
            <tr>
                <th>
                    Code R&D <input type="text" class="form-control" name="Code_RD_prod">
                </th>
                <th>
                    Gamme R&D <input type="text" class="form-control" name="Gamme_RD">
                </th>
                <th>
                    Ligne R&D <input type="text" class="form-control" name="Ligne_RD">
                </th>
            </tr>
            <tr>
                <th>
                    Nom R&D <input type="text" class="form-control" name="Nom_RD">
                </th>
                <th>
                    Catégorie Prod 
                    <select class="custom-select" name="Cat_prod">
                        <option value=""> </option>
                        <option value="Non rincé">Non rincé</option>
                        <option value="Rincé">Rincé</option>
                    </select>
                </th>
                <th>
                    
                    Catégorie IFRA 
                    <select class="custom-select" name="Cat_IFRA_prod">
                        <option value=""> </option>
                        <?php
                        $res=table_all_queries('Categorie_IFRA',$bdd);
                        for($i=0;$i<count($res);$i++){
                        ?>
                        <option><?php echo $res[$i]['Cate_IFRA'];?></option>
                        <?php } ?>
                    </select>
                </th>
            </tr>
        </table>
        <button class="btn btn-primary">
            Rechercher
        </button>
    </form>
</div>
