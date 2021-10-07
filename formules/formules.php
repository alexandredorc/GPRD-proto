<h2>Formules Produits</h2>
<a class="btn btn-secondary" href="../prod/index.php?form=true" style="width:50px; margin-bottom:10px;" >
    <i class="bi bi-arrow-left"></i>
</a>

<form action="index.php?recherche=quick_form"  method="POST">
    <h4>recherche rapide</h4>
    <div class="input-group" style="padding:0 25% 0 0">
        <input type="text" class="form-control" name="Ref_form" style="min-width:50px;">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" ><i class="bi bi-search"></i></button>
        </div>
        
    </div>
</form>



    
    <?php
    if(isset($_SESSION['ref_form'])){
        
        $data=table_single_query('formules','Ref_form',$_SESSION['ref_form'],$bdd);
        if($data){
            ?>
            <form action="index.php?modif=formule" method="POST" style="display:flex; flex-direction:column;">
                Réference Formule:
                <input type="text" readonly name="mod_form" value= "<?php echo $data['Ref_form'];?>"> </br>
                État de la formule: 
                <input type="text" readonly value= "<?php echo ($data['Etat_form']==1)?"Commercialisé":(($data['Etat_form']==2)?"En développement":"");?>"> </br>
                <table class="table">
                    <tr>
                        <td>
                            Retenue: 
                            <input type="checkbox" disabled <?php if($data['Retenue']=='VRAI'){echo 'checked';};?>>
                        </td>
                        <td>
                            Validation RD: 
                            <input type="checkbox" disabled <?php if($data['Val_RD']=='VRAI'){echo 'checked';};?>> 
                        </td>
                        <td>
                            Validation AR: 
                            <input type="checkbox" disabled <?php if($data['Val_AR']=='VRAI'){echo 'checked';};?>> 
                        </td>
                        <td>
                            Annulée: 
                            <input type="checkbox" disabled <?php if($data['Annulee']=='VRAI'){echo 'checked';};?>> 
                        </td>
                    </tr>
                </table>
                Date de validation:
                <input type="date" readonly value= "<?php echo $data['Date_val'];?>"> </br>
                information formule: 
                <textarea readonly ><?php echo $data['Info_form'];?></textarea> </br>
                Code GPAO: 
                <input type="text" readonly value= "<?php echo $data['Code_GPAO'];?>"> </br>
                Année commercial: 
                <input type="text" readonly value= "<?php echo $data['Annee_com'];?>"> </br>
                Mode opératoire: 
                <textarea readonly ><?php echo $data['Mode_ope'];?></textarea> </br> 
                <button class="btn btn-warning" style="margin:50px 0;">Modifier</button>
            </form>        
        <?php   
        } 
    }
?>


