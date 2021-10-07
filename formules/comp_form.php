


    <div class="comp_form">
    <?php
    if(isset($_POST['Ref_form'])){
        $_SESSION['ref_form']=$_POST['Ref_form'];
    }
    if(isset($_SESSION['ref_form'])){
        $res= table_to_table('formules','comp_form','Ref_form_RD','Ref_form_RD',$_SESSION['ref_form'],$bdd," ORDER BY Ligne ASC ")->fetchAll();
       
            ?>
            
            <button class="btn btn-secondary" style="margin:20px;" onclick="location.href = 'modif.php?clean=true'">   
                    Effacer Phase
            </button>
            <form action="modif.php?save=true" method="POST">
                <table style="font-size:10px;">
                    <thead class="table">
                        <tr>
                            <th colspan=2>Phase</th>
                            <th>Ligne</th>
                            <th>Code MP</th>
                            <th>Nom Commercial MP</th>
                            <th>% MP dans formules</th>
                            <th>Prix/kg de MP</th>
                            <th>Prix/kg MP dans formule</th>
                            <th>MP en voie sup</th>
                            <th>Indice Naturel</th>
                            <th>Contenu Naturel</th>
                            <th>Indice d'Origine Naturel</th>
                            <th>Contenu d'Origine Naturel</th>
                            <th>Indice Biologique</th>
                            <th>Contenu Biologique</th>
                            <th>Indice d'Origine Biologique</th>
                            <th>Contenu d'Origine Biologique</th>
                            <th>Recommendation MP</th>
                            <th>Synthèse règlementation MP</th>
                        </tr>
                    </thead>
                    <tbody id="tableau">
                    <?php
                        $sum=0;
                        $cost=0;
                        $sumCN=0;
                        $sumCON=0;
                        $sumCB=0;
                        $sumCOB=0;
                        for($i=0;$i<count($res);$i++){
                    ?>
                        <tr>
                            <td><input type="checkbox" class="check_phase" id="check_phase_<?php echo $i;?>"  <?php if(!isset($res[$i-1]) || $res[$i]['Phase']>$res[$i-1]['Phase']) {echo "checked";}?> ></br></td>
                            <td><input class="lone" name="Phase_<?php echo $i; ?>" type="text"  value="<?php echo $res[$i]['Phase'] ?>"></td>
                            <td><input class="lone"  name="Ligne_<?php echo $i; ?>" type="text"  value="<?php echo ($i+1); ?>"></td>
                            <td><input class="unique MP" name="Code_MP_<?php echo $i; ?>" type="text"  value="<?php echo $res[$i]['Code_MP'] ?>"></td>
                            <?php $data=table_single_query('matieres_premieres','Code_MP',$res[$i]['Code_MP'],$bdd);?>
                            <td><input class="vv-long Nom_MP" readonly id="Nom_com_MP"  type="text"  value="<?php echo ($data)?$data['Nom_com_MP']:'';?>"></td>
                            <td><input class="long prcnt" name="%_MP_form_<?php echo $i; ?>" type="text"  value="<?php echo doubleval($res[$i]['%_MP_form']) .'%'?>"></td>
                            <td><input class="long" readonly id="Prix_MP" type="text"  value="<?php echo ($data)?$data['Prix_MP'].' €':''?>"></td>
                            <td><input class="long"readonly type="text"  value="<?php 
                            $val=($data)?doubleval($res[$i]['%_MP_form'])*doubleval($data['Prix_MP']):0;
                            echo ($data)?$val.' €':''?>"></td>
                            <td><input type="checkbox" disabled <?php if($data &&$data['MP_suppr']=='VRAI') {echo 'checked';}?> > </br></td>
                            <td><input class="lone" readonly type="num"  value="<?php echo ($data)?$data['IN_MP']:''?>"></td>
                            <td><input class="unique" readonly type="num"  value="<?php echo ($data)?(doubleval($data['IN_MP']) * doubleval($res[$i]['%_MP_form']) .'%'):''?>"></td>
                            <td><input class="unique" readonly type="num"  value="<?php echo ($data)?$data['ION_MP']:''?>"></td>
                            <td><input class="unique" readonly type="num"  value="<?php echo ($data)?(doubleval($data['ION_MP']) * doubleval($res[$i]['%_MP_form']) .'%'):''?>"></td>
                            <td><input class="unique" readonly type="num"  value="<?php echo ($data)?$data['IB_MP']:''?>"></td>
                            <td><input class="unique" readonly type="num"  value="<?php echo ($data)?(doubleval($data['IB_MP']) * doubleval($res[$i]['%_MP_form']) .'%'):''?>"></td>
                            <td><input class="unique" readonly type="num"  value="<?php echo ($data)?$data['IOB_MP']:''?>"></td>
                            <td><input class="unique" readonly type="num"  value="<?php echo ($data)?(doubleval($data['IOB_MP']) * doubleval($res[$i]['%_MP_form']) .'%'):''?>"></td>
                            <td><textarea name="" readonly cols="20" rows="1"><?php echo ($data)?$data['Reco_MP']:'';?></textarea></td>
                            <td><textarea name="" readonly cols="20" rows="1"><?php echo ($data)?$data['Synt_MP']:'';?></textarea></td>
                            <td><a class="btn" style="padding: .3rem .5rem;" href = "../MP/index.php?code=<?php echo $res[$i]['Code_MP'];?>" target="_blank">+info</a></td>
                            <td>
                                <a class="btn btn-danger" style="border-radius:35%;padding: 0 .25rem;" onclick="location.href = 'modif.php?comp_form=true&trash=<?php echo $res[$i]['id_comp'];?>'">
                                <i class="bi bi-x"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-success" style="border-radius:35%;padding: 0 .25rem;" onclick="location.href = 'modif.php?comp_form=true&add=<?php echo $res[$i]['id_comp'];?>'">
                                <i class="bi bi-plus"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-primary" style="border-radius:35%;padding: 0 .25rem;" onclick="location.href = 'modif.php?comp_form=true&up=<?php echo $res[$i]['id_comp'];?>'">
                                <i class="bi bi-arrow-bar-up"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-primary" style="border-radius:35%;padding: 0 .25rem;" onclick="location.href = 'modif.php?comp_form=true&down=<?php echo $res[$i]['id_comp'];?>'">
                                <i class="bi bi-arrow-bar-down"></i>
                                </a>
                            </td>
                        </tr>
                        <?php 
                            if($data){
                                $sum+=$res[$i]['%_MP_form'];
                                $cost+=doubleval($res[$i]['%_MP_form'])*doubleval($data['Prix_MP'])/100;
                                $sumCN+= doubleval($data['IN_MP']) * doubleval($res[$i]['%_MP_form']);
                                $sumCON+= doubleval($data['ION_MP']) * doubleval($res[$i]['%_MP_form']);
                                $sumCB+= doubleval($data['IB_MP']) * doubleval($res[$i]['%_MP_form']);
                                $sumCOB+= doubleval($data['IOB_MP']) * doubleval($res[$i]['%_MP_form']);
                            }
                        } ?> 
                        <tr>
                            <td colspan=21>
                                <td>
                                    <a class="btn btn-success" style="border-radius:35%;padding: 0 .25rem;" onclick="location.href = 'modif.php?comp_form=true&add=-1'">
                                    <i class="bi bi-plus"></i>
                                    </a>
                                </td>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="border: solid #EEE 1px">
                            <td ></td>
                            <td ></td>
                            <td style="background-color: #EEE;" colspan=3 >Calcule d'ingrédient qsp100%</td>
                            <td ><input readonly class="long" type="text"  value="<?php echo number_format(100-$sum, 4, '.', '').'%';?>"></td>
                            <td style="background-color: #EEE;">Coût Formule</td>
                            <td><input class="long" type="text"  value="<?php echo $cost.' €'?>"></td>
                            <td></td>
                            <td style="background-color: #EEE;">Contenu Naturel Formule</td>
                            <td><input readonly class="unique" type="text"  value="<?php echo $sumCN .'%'?>"></td>
                            <td style="background-color: #EEE;">Contenu d'Origine Naturel Formule</td>
                            <td><input readonly class="unique" type="text"  value="<?php echo $sumCON .'%'?>"></td>
                            <td style="background-color: #EEE;">Contenu Biologique Formule</td>
                            <td><input readonly class="unique" type="text"  value="<?php echo $sumCB .'%'?>"></td>
                            <td style="background-color: #EEE;">Contenu d'Origine Biologique Formule</td>
                            <td><input readonly class="unique" type="text"  value="<?php echo $sumCOB .'%'?>"></td>
                            <td colspan=2></td>
                        </tr>
                    </tfoot>
                </table>
                <div>
                    <button class="btn btn-success" style="margin-top:50px;">   
                        Enregistrer
                    </button>
                </div>
            </form>
        <?php
    
    }
    ?>
    </div>
<script type="text/javascript" src="update.js"></script>