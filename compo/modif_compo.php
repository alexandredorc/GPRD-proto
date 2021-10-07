<?php


if(isset($_POST['nom_inci'])){
    $_SESSION['Nom_INCI']=$_POST['nom_inci'];
}elseif(!isset($_SESSION['Nom_INCI'])){
    $_SESSION['Nom_INCI']="";
}
$fonct=table_all_queries('categories_ingre',$bdd);
$data=table_single_query('composants','Nom_INCI',$_SESSION['Nom_INCI'],$bdd);
$cat=get_single_attribut('composants','Cat_CMR',$bdd);
?>

<div class="body-center" style="max-width:none;">
    <form action="index.php?compo=modif" style="margin:30px;" method="POST">
        <h4>Changement Composant rapide</h4>
        <div class="input-group">
            <input class="form-control" name="nom_inci" style="max-width:120px;">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" ><i class="bi bi-search"></i></button>
            </div>
        </div>
    </form>
    <h1>Modifier un Composant</h1>
    <form action="index.php?compo=change" method="POST" style="display:flex;flex-direction:column;">
        <table class="table">
            <tr>
                <th>Nom INCI Composant
                    <input name="Nom_INCI" class="form-control" value="<?php echo ($data)?$data['Nom_INCI'] :"";?>">
                </th>
                
                <th>Fonction principale
                    <select class="custom-select" name="Fonct_prin">
                        <?php
                        for($i=0;$i<count($fonct);$i++){
                        ?>
                        <option <?php echo (($data) && $fonct[$i]['Fonction']==$data['Fonct_prin'])?"selected":"";?> >
                        <?php echo $fonct[$i]['Fonction'];?>
                        </option>
                        <?php } ?>
                    </select>
                </th>
                <th>Fonction secondaire
                <select class="custom-select" name="Fonct_sec">
                        <?php
                        for($i=0;$i<count($fonct);$i++){
                        ?>
                        <option <?php echo (($data) && $fonct[$i]['Fonction']==$data['Fonct_sec'])?"selected":"";?> >
                        <?php echo $fonct[$i]['Fonction'];?>
                        </option>
                        <?php } ?>
                    </select>
                </th>
                <th>Information supplémentaire
                    <textarea name="Info_supp" cols="30" rows="2"><?php echo ($data)?$data['Info_supp']:'';?></textarea>
                </th>
            </tr>
            <tr>
                <th>Substance réglementé
                    <input name="Sub_reg" class="form-control" value="<?php echo ($data)?$data['Sub_reg'] :"";?>">
                </th>
                <th>Mélange réglementé
                    <input name="Mel_reg" class="form-control" value="<?php echo ($data)?$data['Mel_reg'] :"";?>">
                </th>
                <th>Substance réglementé exprimé en
                    <input name="Sub_reg_expr" class="form-control" value="<?php echo ($data)?$data['Sub_reg_expr'] :"";?>">
                </th>
                <th>Mélange réglementé exprimé en
                    <input name="Mel_reg_expr" class="form-control" value="<?php echo ($data)?$data['Mel_reg_expr'] :"";?>">
                </th>
            </tr>
            <tr>
                <th>Quantité composant</br>
                    <input name="Qtt_comp_reg" class="form-control" value="<?php echo ($data)?$data['Qtt_comp_reg'] :"";?>"> 
                </th>
                <th>Quantité substance réglementé</br>
                    <input name="Qtt_reg_comp" class="form-control" value="<?php echo ($data)?$data['Qtt_reg_comp'] :"";?>"> 
                </th>
                <th>Composant CMR</br>
                     <input type="checkbox" name="Comp_CMR" class="form-control" <?php if(($data) && $data['Comp_CMR']=='VRAI'){echo 'checked';}?> >
                </th>
                <th>Catégories CMR</br>
                    <input list="Cat_CMR"  name="Cat_CMR" class="form-control" value="<?php echo ($data)?$data['Cat_CMR'] :"";?>">
                    <datalist id="Cat_CMR">
                        <?php
                            for($k=0;$k<count($cat);$k++){
                        ?>
                            <option value="<?php echo $cat[$k][0]?>"></option>
                        <?php } ?>
                    </datalist>
                </th>
            </tr>
            <tr>
                <th>Composant réglementé et à risque</br>
                    <input type="checkbox" name="Comp_reg_risk" class="form-control" <?php if(($data) && $data['Comp_reg_risk']=='VRAI'){echo 'checked';}?> >
                </th>
                <th>Composant validé</br>
                    <input type="checkbox" name="Comp_val" class="form-control" <?php if(($data) && $data['Comp_val']=='VRAI'){echo 'checked';}?> >
                </th>
            </tr>
        </table>
        <div>
            <button class="btn btn-success" name="btn" value="save">
                <strong>Enregistrer</strong>
            </button>

            <button class="btn btn-danger" name="btn" value="suppr">
                <strong>Supprimer</strong>
            </button>
        </div>
    </form>
</div>
