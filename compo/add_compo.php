
<div class="body-center" style="max-width:none;">
    <?php $data=table_all_queries('categories_ingre',$bdd); ?>
    <h1>Ajouter un Composant</h1>
    <form action="index.php?compo=push" method="POST" style="display:flex;flex-direction:column;">
        <table>
            <tr>
                <th>Nom INCI composant
                    <input type="text" name="Nom_INCI" class="form-control" >
                </th>
                <th>
                Fonction Principale
                <select class="custom-select" name="Fonct_prin">
                    <?php
                    for($i=0;$i<count($data);$i++){
                    ?>
                    <option>
                    <?php echo $data[$i]['Fonction'];?>
                    </option>
                    <?php } ?>
                </select>
                </th>
                <th>
                Fonction Secondaire
                <select class="custom-select" name="Fonct_sec">
                    <?php
                    for($i=0;$i<count($data);$i++){
                    ?>
                    <option>
                    <?php echo $data[$i]['Fonction'];?>
                    </option>
                    <?php } ?>
                </select>
                </th>
            </tr>
        </table>
        <div>
        <button class="btn btn-success">
            <strong>Ajouter</strong>
        </button>
        <?php if(isset($_GET['erreur'])){
            ?>
            <div class="erreur">
                la réference qui à été renseigné existe déjà
            </div>
        <?php } ?>
        </form>

        </div>
        
    </form>
</div>
