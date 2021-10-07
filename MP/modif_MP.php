<?php

if(isset($_POST['code'])){
    $_SESSION['Code_MP']=$_POST['code'];
}elseif(!isset($_SESSION['Code_MP'])){
    $_SESSION['Code_MP']="";
}

$data=table_single_query('matieres_premieres','Code_MP',$_SESSION['Code_MP'],$bdd);
?>
<div class="body-center" style="max-width:none;">
    <form action="index.php?MP=modif" style="margin:30px;" method="POST">
        <h4>Changement code MP rapide</h4>
        <div class="input-group">
            <input type="text" class="form-control" name="code" style="max-width:120px;">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" ><i class="bi bi-search"></i></button>
            </div>
        </div>
    </form>
    <h1>Modifier une Matières Premières</h1>
    <form action="index.php?MP=change" method="POST" style="display:flex;flex-direction:column;">
        <table>
            <tr>
                <th>Code MP 
                    <input type="text" name="Code_MP" class="form-control" value="<?php echo ($data)?$data['Code_MP']:"";?>">
                </th>
                <th>Nom commercial de la MP 
                    <input type="text" name="Nom_com_MP" class="form-control" value="<?php echo ($data)?$data['Nom_com_MP']:"";?>">
                </th>
                <th>Dénomination INCI 
                    <input type="text" name="Nom_MP" class="form-control" value="<?php echo ($data)?$data['Nom_MP']:"";?>">
                </th>
                <th>Prix de la MP en Kg 
                    <input type="text" name="Prix_MP" class="form-control" value="<?php echo ($data)?$data['Prix_MP'] ." €":"";?>">
                </th>
                
            </tr>
            <tr>
                <th>MP inerté à l'argon
                    <input type="checkbox" name="MP_argon" class="form-control" <?php if(($data) && $data['MP_argon']=='VRAI'){echo 'checked';}?> >
                </th>
                <th>MP en voie de suppression
                    <input type="checkbox" name="MP_suppr" class="form-control" <?php if(($data) && $data['MP_suppr']=='VRAI'){echo 'checked';}?> >
                </th>
                <th>Validation MP
                    <input type="checkbox" name="Val_MP" class="form-control" <?php if(($data) && $data['Val_MP']=='VRAI'){echo 'checked';}?> >
                </th>
                <th>Huile Essentiel
                    <input type="checkbox" name="HE_MP" class="form-control" <?php if(($data) && $data['HE_MP']=='VRAI'){echo 'checked';}?> >
                </th>
            </tr>
            <tr>
                <th>Recommendation MP</br>
                    <textarea class="form-control" name="Reco_MP" cols=50 rows=2><?php echo ($data)?$data['Reco_MP']:"";?></textarea> </br> 
                </th>
                <th>Information supplémentaire de la MP</br>
                    <textarea class="form-control" name="Info_supp" cols=50 rows=2><?php echo ($data)?$data['Info_supp']:"";?></textarea> </br> 
                </th>
                <th>synthèse réglementaire MP</br>
                    <textarea class="form-control" name="Synt_MP" cols=50 rows=2><?php echo ($data)?$data['Synt_MP']:"";?></textarea> </br> 
                </th>
                <th>
                    Propriété de la MP</br>
                    <textarea class="form-control" name="Props_MP" cols=50 rows=2><?php echo ($data)?$data['Props_MP']:"";?></textarea> </br> 
                </th>
            </tr>
            <tr><h1>Indices de naturalité</h1></tr>
            <tr>
                <th>Indice Naturel: 
                <input type="text" name="IN_MP" class="form-control" value="<?php echo ($data)?$data['IN_MP']:"" ;?>"> </th>
                <th>Indice d'Origine Naturel: 
                <input type="text" name="ION_MP" class="form-control" value="<?php echo ($data)?$data['ION_MP']:"" ;?>"> </th>
                <th rowspan=2 style="padding:20px;">Commentaire Indice de Naturalité: 
                <textarea cols=50 rows=3 name="Com_ind" class="form-control" ><?php echo ($data)?$data['Com_ind']:"";?></textarea> </th>
            </tr>
            <tr>
                <th>Indice Biologique: 
                <input type="text" name="IB_MP" class="form-control" value="<?php echo ($data)?$data['IB_MP']:"";?>"> </th>
                <th>Indice d'Origine Biologique: 
                <input type="text" name="IOB_MP" class="form-control" value="<?php echo ($data)?$data['IOB_MP']:"" ;?>"> </th>
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
