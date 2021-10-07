<?php
    $prod=['Non rincé','Rincé'];
    $ingre=['Substance','Mélange','Substance exp en','Mélange exp en'];
    $type_ingre=['Sub_reg','Mel_reg','Sub_reg_expr','Mel_reg_expr'];
    $MP= table_to_table('matieres_premieres','comp_INCI','Code_MP_INCI','Code_MP_INCI',$_SESSION['Code_MP'],$bdd)->fetchAll();
    $pays= array_column(get_single_attribut('pays_organism','Pays_org',$bdd), 'Pays_org');
    for($i=0;$i<count($MP);$i++){
        
        $nom_inci=$MP[$i]['Nom_INCI_comp'];
        $comp=table_single_query('composants','Nom_INCI',$nom_inci,$bdd);
        if($comp['Comp_CMR']=='VRAI')
        $synth[2][]=array($nom_inci,$comp['Cat_CMR']);
        $res= table_to_table('composants','reglement_comp','Nom_INCI_reg','Nom_INCI_reg',$nom_inci,$bdd)->fetchAll();
        if(count($res)!=0){
            $frac_reg=$comp['Qtt_reg_comp']/$comp['Qtt_comp_reg'];
            for($j=0;$j<count($res);$j++){//part entrée
                $type=array_search($res[$j]['Type_ingre_reg'],$ingre);
                $id=array_search($res[$j]['Pays_org'],$pays);
                $k=($res[$j]['Type_prod']==$prod[0])?0:1;
                $prcnt_reg=$MP[$i]['%_comp_MP']*(($type>=2)?$frac_reg:1);
                
                if($res[$j]['Statut_reg']!=''){
                    if($res[$j]['Statut_reg']=='Interdit'){
                        $synth[$k][1][$id]=1;
                        $synth[$k][0][$id]=0;
                    }
                    elseif(!isset($synth[$k][0][$id])){
                        $synth[$k][0][$id]=floatval($res[$j]['%_max_auto'])*100/$prcnt_reg;
                    }
                    elseif($res[$j]['%_max_auto']==""){
                        if($synth[$k][0][$id]>(10000/$prcnt_reg)){
                            $synth[$k][0][$id]=100;
                        }
                    }
                    elseif( $synth[$k][0][$id]>(100*floatval($res[$j]['%_max_auto'])/$prcnt_reg)){
                        if( (floatval($res[$j]['%_max_auto'])/$prcnt_reg>1)){
                            $synth[$k][0][$id]=100;
                        }else{
                            $synth[$k][0][$id]=floatval($res[$j]['%_max_auto'])*100/$prcnt_reg;
                            
                        }
                    }
                }
                    if($res[$j]['%_max_restric']!="" || $res[$j]['Restric_part']!=""){
                        $synth[$k][2][]=array(floatval($res[$j]['%_max_restric'])*100/$prcnt_reg,$res[$j]['Restric_part'],$res[$j]['Pays_org']);
                        //echo floatval($res[$j]['%_max_restric'])*100/$prcnt_reg."  ".$res[$j]['Restric_part']."  ".$res[$j]['Pays_org']." </br> ";
                    }
                    if($res[$j]['Seuil_etiqu']!="" || $res[$j]['Etiquetage']!=""){
                        $synth[$k][3][]=array(floatval($res[$j]['Seuil_etiqu'])*100/$prcnt_reg,$res[$j]['Etiquetage'],$res[$j]['Pays_org']);
                    }
                    if($res[$j]['Autre_info_reg']!=""){
                        if($res[$j]['Seuil_alerte']===""){
                            $synth[$k][4][]=array("",$res[$j]['Autre_info_reg'],$res[$j]['Pays_org'],$comp[$type_ingre[$type]]);
                        }elseif($res[$j]['Seuil_alerte']==0){
                            $synth[$k][4][]=array(0,$res[$j]['Autre_info_reg'],$res[$j]['Pays_org'],$comp[$type_ingre[$type]]);
                        }
                        else{
                            $synth[$k][4][]=array(floatval($res[$j]['Seuil_alerte'])*100/$prcnt_reg,$res[$j]['Autre_info_reg'],$res[$j]['Pays_org'],$comp[$type_ingre[$type]]);
                        }
                    }
                }
            
        }
        
    }
    $_SESSION['reg_synth']=(isset($synth))?$synth:false;
?>