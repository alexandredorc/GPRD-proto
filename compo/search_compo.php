
<div class="body-center" style="max-width:none;">
    <?php $data=table_all_queries('categories_ingre',$bdd); ?>
    <h1>Modifier un Composant</h1>
    <form action="index.php?compo=result" method="POST" style="display:flex;flex-direction:column;">
        <table class="table">
            <tr>
                <th>Nom INCI Composant
                    <input type="text" name="Nom_INCI" class="form-control" >
                </th>
                <th>
                    Fonction Principale
                    <select class="custom-select" name="Fonct_prin">
                        <option value=""></option>
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
                        <option value=""></option>
                        <?php
                        for($i=0;$i<count($data);$i++){
                        ?>
                        <option>
                        <?php echo $data[$i]['Fonction'];?>
                        </option>
                        <?php } ?>
                    </select>
                    </th>
                    <th>Fonction principale
                        <input type="text" name="Info_supp" class="form-control" >
                    </th>
            </tr>
            <tr>
                <th>Substance réglementé
                    <input type="text" name="Sub_reg" class="form-control" >
                </th>
                <th>Mélange réglementé
                    <input type="text" name="Mel_reg" class="form-control" >
                </th>
                <th>Substance réglementé exprimé en
                    <input type="text" name="Sub_reg_expr" class="form-control" >
                </th>
                <th>Mélange réglementé exprimé en
                    <input type="text" name="Mel_reg_expr" class="form-control" >
                </th>
            </tr>
            <tr>
                <th>Quantité composant</br>
                    <input type="text" name="Qtt_comp_reg" class="form-control" > 
                </th>
                <th>Quantité substance réglementé</br>
                    <input type="text" name="Qtt_reg_comp" class="form-control" > 
                </th>
                <th>Composant CMR</br>
                     <input type="checkbox" name="Comp_CMR" class="form-control" >
                </th>
                <th>Catégories CMR</br>
                    <input type="text" name="Cat_CMR" class="form-control" > 
                </th>
            </tr>
            
            <tr>
                <th>Composant réglementé et à risque</br>
                    <input type="checkbox" name="Comp_reg_risk" class="form-control" >
                </th>
                <th>Composant validé</br>
                    <input type="checkbox" name="Comp_val" class="form-control" >
                </th>
            </tr>
        </table>
        <div>
            <button class="btn btn-primary" name="btn" value="save">
                <strong>Recherche</strong>
            </button>

        </div>
        
    </form>
</div>
