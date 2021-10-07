<?php
    $synth=array();
    $res= table_to_table('composants','reglement_comp','Nom_INCI_reg','Nom_INCI_reg',$_SESSION['Nom_INCI'],$bdd)->fetchAll();
    $pays=table_all_queries('pays_organism',$bdd);
    $prod=['Non rincé','Rincé'];
    $label=['%_max_auto','Seuil_etiqu'];
    for($i=0;$i<count($res);$i++){//part entrée
        for($k=0;$k<2;$k++){//type de produit
            for($l=0;$l<2;$l++){// autorisé ou étiquetage
                if((!isset($synth[$k][$l][0]) || $synth[$k][$l][0]>$res[$i][$label[$l]] ) //condition de tri pour les réglementation
                && $res[$i]['Type_prod']==$prod[$k] 
                && $res[$i][$label[$l]]!="" 
                && ($l==1 || $res[$i]['Statut_reg']=='Autorisé')){
                    $synth[$k][$l][0]=$res[$i][$label[$l]];
                }
                if( //condition de tri pour les réglementation
                $res[$i]['Type_prod']==$prod[$k] 
                && $res[$i][$label[$l]]!="" 
                && ($l==1 || $res[$i]['Statut_reg']=='Autorisé')){
                    if(strpos($res[$i]['Type_ingre_reg'],'x') && (!isset($synth[$k][$l][1]) || $synth[$k][$l][1]>$res[$i][$label[$l]]*$_SESSION['frac_reg'])){
                        $synth[$k][$l][1]=doubleval($res[$i][$label[$l]])*$_SESSION['frac_reg'];
                    }elseif(!strpos($res[$i]['Type_ingre_reg'],'x') && (!isset($synth[$k][$l][1]) || $synth[$k][$l][1]>$res[$i][$label[$l]])){
                        $synth[$k][$l][1]=$res[$i][$label[$l]];
                    }
                }
            }
            
            if($res[$i]['Statut_reg']=='Interdit'&& $res[$i]['Type_prod']==$prod[$k] ){
                $a=$res[$i]['Pays_org'];
                $b=(isset($synth[$k][2]))?$synth[$k][2]:false;
                if(!($b) || !in_array($a,$b)){
                    $synth[$k][2][]=$res[$i]['Pays_org'];
                }
            }

            if($res[$i]['Restric_part']!="" && $res[$i]['Type_prod']==$prod[$k]){
                $synth[$k][3][]=array($res[$i]['Pays_org'],$res[$i]['Restric_part'],$res[$i]['%_max_restric'],($res[$i]['%_max_restric']!="")?$res[$i]['%_max_restric']*$_SESSION['frac_reg']:"");
            }
            if($res[$i]['Autre_info_reg']!="" && $res[$i]['Type_prod']==$prod[$k]){
                $synth[$k][4][]=array($res[$i]['Pays_org'],$res[$i]['Autre_info_reg'],$res[$i]['Seuil_alerte'],($res[$i]['Seuil_alerte']!="")?doubleval($res[$i]['Seuil_alerte'])*$_SESSION['frac_reg']:"");
            }
        }
    }
    $_SESSION['reg_synth']=(isset($synth))?$synth:false;
?>



    <div class="halfies" style="font-size: 10px;">
        <?php
         if($_SESSION['reg_synth']){ ?>
        <div class="half">
            <div><h3>Produits non rincés: </h3></div>    
            <div>
                % max autorisé(OK tous pays/org):</br>
                <input type="text" readonly value="<?php echo (isset($_SESSION['reg_synth'][0][0][0]))?($_SESSION['reg_synth'][0][0][0]."%"):""; ?>">
                soit
                <input type="text" readonly value="<?php echo (isset($_SESSION['reg_synth'][0][0][1]))?($_SESSION['reg_synth'][0][0][1]."%"):""; ?>">
                de composant
            </div>
            <div>
                Seuil d'étiquetage mini (OK tt pays/org):</br>
                <input type="text" readonly value="<?php echo (isset($_SESSION['reg_synth'][0][1][0]))?($_SESSION['reg_synth'][0][1][0]."%"):""; ?>">
                soit
                <input type="text" readonly value="<?php echo (isset($_SESSION['reg_synth'][0][1][1]))?($_SESSION['reg_synth'][0][1][1]."%"):""; ?>">
                de composant
            </div>
            <div>
                <?php if(isset($_SESSION['reg_synth'][0][2])){ ?>
                <div>Sauf interdit</div>
                <div style="clear:left;">  
                <?php 
                for($i=0;$i<count($_SESSION['reg_synth'][0][2]);$i++){
                ?>
                    <input type="text" readonly value="<?php echo $_SESSION['reg_synth'][0][2][$i]; ?>"></br>
                <?php } ?>
                </div><?php } ?>
            </div>
            <div>
                <?php if(isset($_SESSION['reg_synth'][0][3])){ ?>
                <h3>Sauf restriction particulières (non rincés)</h3>
                <table>
                    <?php 
                    for($i=0;$i<count($_SESSION['reg_synth'][0][3]);$i++){
                    ?>
                    <tr>
                        <td><input class="long" readonly type="text" value="<?php echo $_SESSION['reg_synth'][0][3][$i][0]; ?>"></td>
                        <td><textarea readonly cols="40" rows="1"><?php echo $_SESSION['reg_synth'][0][3][$i][1]; ?></textarea></td>
                        <td>max</td>
                        <td><input class="long" readonly type="text" value="<?php echo $_SESSION['reg_synth'][0][3][$i][2]."%"; ?>"></td>
                        <td>soit</td>
                        <td><input class="long" readonly type="text" value="<?php echo $_SESSION['reg_synth'][0][3][$i][3]."%"; ?>"></td>
                    </tr>
                    <?php } ?>
                </table>
                <?php } ?>
            </div>
            <div>
                <?php if(isset($_SESSION['reg_synth'][0][4])){ ?>
                <h3>condition particulières d'utilisation et autres infos réglementaire  (non rincés)</h3>
                <table>
                    <?php 
                    for($i=0;$i<count($_SESSION['reg_synth'][0][4]);$i++){
                    ?>
                    <tr>
                        <td><input class="long" readonly type="text" value="<?php echo $_SESSION['reg_synth'][0][4][$i][0]; ?>"></td>
                        <td><textarea readonly cols="40" rows="1"><?php echo $_SESSION['reg_synth'][0][4][$i][1]; ?></textarea></td>
                        <td>à partir</td>
                        <td><input class="long" readonly type="text" value="<?php echo $_SESSION['reg_synth'][0][4][$i][2]."%"; ?>"></td>
                        <td>soit</td>
                        <td><input class="long" readonly type="text" value="<?php echo $_SESSION['reg_synth'][0][4][$i][3]."%"; ?>"></td>
                    </tr>
                    <?php } ?>
                </table>
                <?php } ?>
            </div>
        </div>
        <div class="half">
            <div><h3>Produits rincés: </h3></div>    
            <div>
                % max autorisé(OK tout pays/org):</br>
                <input type="text" readonly value="<?php echo (isset($_SESSION['reg_synth'][1][0][0]))?($_SESSION['reg_synth'][1][0][0]."%"):""; ?>">
                soit
                <input type="text" readonly value="<?php echo (isset($_SESSION['reg_synth'][1][0][1]))?($_SESSION['reg_synth'][1][0][1]."%"):""; ?>">
                de composant
            </div>
            <div>
                Seuil d'étiquetage mini (OK tt pays/org): </br>
                <input type="text" readonly value="<?php echo (isset($_SESSION['reg_synth'][1][1][0]))?($_SESSION['reg_synth'][1][1][0]."%"):""; ?>">
                soit
                <input type="text" readonly value="<?php echo (isset($_SESSION['reg_synth'][1][1][1]))?($_SESSION['reg_synth'][1][1][1]."%"):""; ?>">
                de composant
            </div>
            <div>
                <?php if(isset($_SESSION['reg_synth'][1][2])){ ?>
                <div>Sauf interdit</div>
                <div style="clear:left;">  
                <?php 
                for($i=0;$i<count($_SESSION['reg_synth'][1][2]);$i++){
                ?>
                
                    <input type="text" readonly value="<?php echo $_SESSION['reg_synth'][1][2][$i]; ?>"></br>
                <?php } ?></div>
            <?php } ?>
            </div>
            <div>
                <?php if(isset($_SESSION['reg_synth'][1][3])){ ?>
                <h3>Sauf restriction particulières (rincés)</h3>
                <table>
                    <?php 
                    for($i=0;$i<count($_SESSION['reg_synth'][1][3]);$i++){
                    ?>
                    <tr>
                        <td><input class="long" type="text" readonly value="<?php echo $_SESSION['reg_synth'][1][3][$i][0]; ?>"></td>
                        <td><textarea readonly cols="40" rows="1"><?php echo $_SESSION['reg_synth'][1][3][$i][1]; ?></textarea></td>
                        <td>max</td>
                        <td><input class="long" type="text" readonly value="<?php echo $_SESSION['reg_synth'][1][3][$i][2]."%"; ?>"></td>
                        <td>soit</td>
                        <td><input class="long" type="text" readonly value="<?php echo $_SESSION['reg_synth'][1][3][$i][3]."%"; ?>"></td>
                    </tr>
                    <?php } ?>
                </table>
                <?php } ?>
            </div>
            <div>
                <?php if(isset($_SESSION['reg_synth'][1][4])){ ?>
                <h3>condition particulières d'utilisation et autres infos réglementaire (rincés)</h3>
                <table>
                    <?php 
                    for($i=0;$i<count($_SESSION['reg_synth'][1][4]);$i++){
                    ?>
                    <tr>
                        <td><input class="long" type="text" readonly value="<?php echo $_SESSION['reg_synth'][1][4][$i][0]; ?>"></td>
                        <td><textarea readonly cols="40" rows="1"><?php echo $_SESSION['reg_synth'][1][4][$i][1]; ?></textarea></td>
                        <td>à partir</td>
                        <td><input class="long" type="text" readonly value="<?php echo $_SESSION['reg_synth'][1][4][$i][2]."%"; ?>"></td>
                        <td>soit</td>
                        <td><input class="long" type="text" readonly value="<?php echo $_SESSION['reg_synth'][1][4][$i][3]."%"; ?>"></td>
                    </tr>
                    <?php } ?>
                </table>
                <?php } ?>
            </div>
        </div>
        <?php 
       
    } ?>
    </div>