

<?php
include('config.php');
$prod=table_get_all('produits',$bdd,'ORDER BY Gamme_RD, Ligne_RD, Nom_RD ASC');?>


<table style="width :100%; margin-bottom:10px;">
    <thead>
        <tr>
        <th style="width:250px;">Nom R et D produit</th>
            <th style="width:10px; ">Code <br> R et D</th>
            <th>
                <table>
                <tr>
                    <th style="width:120px;">Référence R et D</th>
                    <th style="width:100px;"> Statut formule </th>
                    <th style="width:60px;">Code GPAO</th>
                    <th style="width:40px;">Année com</th>
                    <th>
                        <table style="width:40%;">
                        <tr>
                            <th class="w-150">Nom(s) commerci(aux)</th>
                            <th class="w-150">Gamme(s) commerciale(s)</th>
                            <th class="w-150">Ligne(s) commerciale(s)</th>
                        </tr>
                        </table>
                        
                    </th>
                </tr>
                </table>
            </th>
        </tr>
    </thead>
    <tbody>
    <?php
    if($prod){
    
        for($i=0;$i<count($prod)/12;$i++){
            
        
    if(!isset($Gamme_RD) || $Gamme_RD!=$prod[$i]['Gamme_RD']){
    $Gamme_RD=$prod[$i]['Gamme_RD'];?>
        <tr>
            <th colspan=3 class="gammeRD"><?php echo $Gamme_RD; ?></th>
        </tr><?php
    }
    if(!isset($Ligne_RD) || $Ligne_RD!=$prod[$i]['Ligne_RD']){
        $Ligne_RD=$prod[$i]['Ligne_RD'];?>
        <tr >
            <th colspan=3 class="ligneRD"><?php echo $Ligne_RD; ?></th>
        </tr><?php
    } 
    ?>
        <tr valign="top" style="width:95%; ">
            <td class="w-150" style=" border-top:grey solid 1px; padding:10px; "> <?php echo $prod[$i]['Nom_RD'];?></td>
            <td class="w-120" style=" border-top:grey solid 1px; padding:10px;"> <?php echo $prod[$i]['Code_RD_prod'];?></td>
            <td  style=" border-top:grey solid 1px;">
                <table style="width:60%;">
              
                    <?php 

                    $form=table_to_table('produits','formules','Code_RD','Code_RD',$prod[$i]['Code_RD_prod'],$bdd,"ORDER BY Ref_form ASC");
                        for($j=0;$j<count($form);$j++){ 
                            $app= table_to_table('formules','appellations','Ref_form_appel','Ref_form_appel',$form[$j]['Ref_form'],$bdd);
                            ?>
                    <tr style="border-top:1px solid #bebebe">
                        <td class="w-150" style="min-width:150;"><?php echo $form[$j]['Ref_form']?></td>
                        <td>
                            <table class="checkbox w-150" >
                                <tr><td>Retenue <div class="<?php echo $form[$j]['Retenue']; ?>"></div></td></tr>
                                <tr><td>Validé RD<div class="<?php echo $form[$j]['Val_RD']; ?>"></div></td></tr>
                                <tr><td>Validé AR<div class="<?php echo $form[$j]['Val_AR']; ?>"></div></td></tr>
                                <tr><td>Annulée<div class="<?php echo $form[$j]['Annulee']; ?>"></div></td></tr>
                            </table>
                        </td>
                        <td style="padding: 0 20px; min-width:60px;"><?php echo $form[$j]['Code_GPAO']?></td>
                        <td style="padding: 0 20px"><?php echo $form[$j]['Annee_com']?></td>
                        <td>
                            <table  style="width:40%;">
                               
                                    <?php
                                    for($k=0;$k<count($app);$k++){
                                        ?>
                                        <tr class="f-col" style="padding:15px;">
                                            <td style="width:125px;"><?php echo $app[$k]['Nom_com'];?></td>
                                            <td style="width:125px;"><?php echo $app[$k]['Gamme_com'];?></td>
                                            <td style="width:125px;"><?php echo $app[$k]['Ligne_com'];?></td>
                                    </tr>
                                    <?php } ?>
                            </table>
                        </td>
                    </tr>
                        <?php }?>
                </table>
            </td>
        </tr>
        <?php
            }
        }
        ?>
        </tbody>
       
    
    </table>

           


<style>
    thead { display: table-header-group }
    div.VRAI{
        border: 1px black solid;
        background-color: darkblue;
        width:5px;
        height:5px;
        float:right;
    }
    div.FAUX{
        border: 1px black solid;
        background-color: white;
        width:5px;
        height:5px;
        float:right;
    }
    .checkbox{
        width:1%;
        padding:5px;
        max-width:100px;
    }
    .checkbox tr{
        width: 20px;
    }
    
    .w-100{
        width:100px;
    }
    .w-120{
        width:120px;
    }
    .w-150{
        width:150px;
    }
    .ligneRD{
        border-top: lightblue solid 2px;
        font-size:20px;
        color: lightblue;
        
    }
    .gammeRD{
        border-top: blue solid 2px;
        font-size:23px;
        color: blue;
    }
    .f-row{
        display:flex;
        flex-direction: column;
    }
    .f-col{
        display:flex;
        flex-direction: row;
    }
    td, th{
        padding:0px;
    }
    tr{
        height:min-content;
    }
    
</style>