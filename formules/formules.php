<h2>Formules Produits</h2>
<a class="btn btn-secondary" href="../prod/index.php?form=true" style="width:50px; margin-bottom:10px;" >
    <i class="bi bi-arrow-left"></i>
</a>

<form action="index.php?recherche=quick_form"  method="POST">
    <h4>recherche rapide</h4>
    <div class="input-group" style="padding:0 25% 0 0">
    <input type="text" class="form-control" name="Code_RD" style="width:200px;">
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
            <form action="index.php?modif=formule" method="POST" style="display:flex; flex-direction:column;  width:70%;padding:50px ;">
                <table class="table" >
                    <colgroup>
                        <col span="1" style="width: 15%;">
                        <col span="1" style="width: 70%;">
                    </colgroup>
                    <tr style="text-align:left;">
                        <td>Réference Formule: </td>
                        <td><h5><?php echo $data['Ref_form'];?></h5></td>
                    </tr>
                    <tr style="text-align:left;">
                        <td>État de la formule:  </td>
                        <td><h5><?php echo ($data['Etat_form']==1)?"Commercialisé":(($data['Etat_form']==2)?"En développement":"");?></h5></td>
                    </tr>
                    <tr style="text-align:left;">
                        <td colspan="2"> 
                            <table class="table" style="width:50%">
                                <tr>
                                    <td>
                                        Retenue
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
                        </td>
                       
                    </tr>
                    <tr style="text-align:left;">
                        <td>Date de validation: </td>
                        <td><h5><?php echo $data['Date_val'];?></h5></td>
                    </tr>
                    <tr style="text-align:left;">
                        <td>information formule: </td>
                        <td><h5><?php echo $data['Info_form'];?></h5></td>
                    </tr>
                    <tr style="text-align:left;">
                        <td>Code GPAO: </td>
                        <td><h5><?php echo $data['Code_GPAO'];?></h5></td>
                    </tr>
                    <tr style="text-align:left;">
                        <td>Année commercial: </td>
                        <td><h5><?php echo $data['Annee_com'];?></h5></td>
                    </tr>
                    <tr style="text-align:left;">
                        <td>Mode opératoire: </td>
                        <td><h5><?php echo $data['Mode_ope'];?></h5></td>
                    </tr>
                </table>
                
                <button class="btn btn-warning" style="width:100px;"><strong>Modifier</strong></button>
            </form>        
        <?php   
        } 
    }
?>


