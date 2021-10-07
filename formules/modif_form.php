<?php
if(isset($_POST['mod_form'])){
    $_SESSION['mod_form']=$_POST['mod_form'];
}elseif(isset($_SESSION['ref_new'])){
    $_SESSION['mod_form']=$_SESSION['ref_new'];
    $_SESSION['ref_new']=NULL;
}else{
    $_SESSION['mod_form']="";
}
$sql="select * from formules where Ref_form='".$_SESSION['mod_form']."'";

$res=$bdd->query($sql);
$data=$res->fetchAll();
if(count($data)==1){
    $data=$data[0];
}else{
    $data=false;
}
?>

<div class="body-center" style="max-width:none;">
    <div class="head-center" style="display:flex; justify-content: space-between;">
        
            <form action="index.php?modif=formule" style="margin:30px;" method="POST">
            <h4>Changement code R&D rapide</h4>

            <div class="input-group">
                <input type="text" class="form-control" name="mod_form" style="max-width:120px;">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" ><i class="bi bi-search"></i></button>
                </div>
            </div>
        </form>
            <button class="btn btn-success" style="height: 3em; margin-top:50px;" onclick="location.href = 'index.php?modif=add_form'" >
                Ajouter
            </button>
    </div>
        
        <form action="index.php?modif=change_form" method="POST">
        <h1>Modifier une formule</h1>
        <table class="table">
            <tr>
                <th>
                    Réference Formule <input type="text" class="form-control" name="Ref_form"value="<?php echo ($data)?$data['Ref_form']:"";?>">
                </th>
                <th>
                    Retenue <input type="checkbox" class="form-control" name="Retenue" <?php echo ($data && $data['Retenue']=='VRAI')?'checked':"";?> >
                </th>
                <th>
                    Validation RD<input type="checkbox" class="form-control" name="Val_RD" <?php echo ($data && $data['Val_RD']=='VRAI')?'checked':"";?> >
                </th>
                <th>
                    Validation AR<input type="checkbox" class="form-control" name="Val_AR" <?php echo ($data && $data['Val_AR']=='VRAI')?'checked':"";?> >
                </th>
                <th>
                    Annulée <input type="checkbox" class="form-control" name="Annulee" <?php echo ($data && $data['Annulee']=='VRAI')?'checked':"";?> >
                </th>
            </tr>
            <tr>
                <th>
                    Date de validation <input type="date" class="form-control" name="Date_val" value="<?php echo ($data)?$data['Date_val']:"";?>">
                </th>
                <th>
                    information formule </br>  <textarea name="Info_form" cols="30" rows="2"><?php echo ($data)?$data['Info_form']:'';?></textarea>
                </th>
                <th>
                    Code GPAO <input type="text" class="form-control" name="Code_GPAO" value="<?php echo ($data)?$data['Code_GPAO']:"";?>">
                </th>
                <th>
                    Année de commercialisation <input type="text" class="form-control" name="Annee_com" value="<?php echo ($data)?$data['Annee_com']:"";?>">
                </th>
                
            </tr>
            <tr>
                <th>
                    Code R&D <input type="text" class="form-control" name="Code_RD" value="<?php echo ($data)?$data['Code_RD']:'';?>">
                </th>
                <th>
                    État de la formule 
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="com" name="Etat_form" value="1" <?php echo ($data && $data['Etat_form']=='1')?'checked':"";?>>
                        <label for="com" class="form-check-label" style="padding-left:20px;">Commercialisé</label>
                    </div>
                    
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="dev" name="Etat_form" value="2" <?php echo ($data && $data['Etat_form']=='2')?'checked':"";?>>
                        <label for="dev" class="form-check-label" style="padding-left:20px;" >En développement</label>
                    </div>
                </th>
                <th>
                    Mode opératoire <textarea name="Mode_ope" cols="30" rows="2"><?php echo ($data)?$data['Mode_ope']:'';?></textarea>
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
