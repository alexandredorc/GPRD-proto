<div >
    <button class="btn btn-secondary" style="margin:20px;" onclick="location.href = 'index.php?comp_form=true'">
        Retour Formule
    </button>
</div>


<div class="comp_form">
<?php

if($_GET['ajust']=="save"){
    $res=$res= table_to_table('formules','comp_form','Ref_form_RD','Ref_form_RD',$_SESSION['ref_form'],$bdd," ORDER BY Ligne ASC ")->fetchAll();
    $size=count($res);
    
    $req=$bdd->prepare("UPDATE comp_form SET `%_MP_maxi`= :MP_maxi , `%_MP_mini`= :MP_mini WHERE id_comp= :id_comp ");
    for($i=0;$i<$size;$i++){
        str_replace("%", "", $_POST["%_MP_maxi_$i"]);
        str_replace("%", "", $_POST["%_MP_mini_$i"]);
        $req->execute([
        'MP_maxi' => $_POST["%_MP_maxi_$i"],
        'MP_mini' => $_POST["%_MP_mini_$i"],
        'id_comp'=> ($res[$i]['id_comp'])
        ]);
    
    }
}

if(isset($_POST['Ref_form'])){
    $_SESSION['ref_form']=$_POST['Ref_form'];
}
if(isset($_SESSION['ref_form'])){
    $res= table_to_table('formules','comp_form','Ref_form_RD','Ref_form_RD',$_SESSION['ref_form'],$bdd," ORDER BY Ligne ASC ")->fetchAll();
   
        ?>
        
        
        <form action="index.php?ajust=save" method="POST">
            <table style="font-size:11px;">
                <thead class="table">
                    <tr>
                        <th>Phase</th>
                        <th>Ligne</th>
                        <th>Code MP</th>
                        <th>Nom Commercial MP</th>
                        <th>% MP dans formules</th>
                        <th>% MP mini dans formules</th>
                        <th>% MP maxi dans formules</th>
                        <th>Recommendation MP</th>
                        <th>Synthèse règlementation MP</th>
                    </tr>
                </thead>
                <tbody id="tableau">
                <?php
                    $sum=0;
                    $sum_max=0;
                    $sum_min=0;
                    for($i=0;$i<count($res);$i++){
                ?>
                    <tr>
                        
                        <td><input readonly class="lone"  type="text"  value="<?php echo $res[$i]['Phase'] ?>"></td>
                        <td><input readonly class="lone"  type="text"  value="<?php echo ($i+1); ?>"></td>
                        <td><input readonly class="unique MP" type="text"  value="<?php echo $res[$i]['Code_MP'] ?>"></td>
                        <?php $data=table_single_query('matieres_premieres','Code_MP',$res[$i]['Code_MP'],$bdd);?>
                        <td><input readonly class="vv-long Nom_MP" readonly id="Nom_com_MP"  type="text"  value="<?php echo ($data)?$data['Nom_com_MP']:'';?>"></td>
                        <td><input readonly class="long prcnt" name="%_MP_form_<?php echo $i; ?>" type="text"  value="<?php echo doubleval($res[$i]['%_MP_form']) .'%'?>"></td>

                        <td><input class="long prcnt" name="%_MP_mini_<?php echo $i; ?>" type="text"  value="<?php echo ($res[$i]['%_MP_mini']!=="")?doubleval($res[$i]['%_MP_mini']) .'%':""; ?>"></td>

                        <td><input class="long prcnt" name="%_MP_maxi_<?php echo $i; ?>" type="text"  value="<?php echo ($res[$i]['%_MP_maxi']!=="")?doubleval($res[$i]['%_MP_maxi']) .'%':""; ?>"></td>
                        <td><textarea readonly cols="20" rows="1"><?php echo ($data)?$data['Reco_MP']:'';?></textarea></td>
                        <td><textarea readonly cols="20" rows="1"><?php echo ($data)?$data['Synt_MP']:'';?></textarea></td>
                        <td><a class="btn" style="padding: .3rem .5rem;"r onclick="location.href = '../MP/index.php?code=<?php echo $res[$i]['Code_MP'];?>'" data-parent="#accordion" href="#collapse1">+info</a></td>
                        
                    </tr>
                    <?php 
                        if($data){
                            $sum+=$res[$i]['%_MP_form'];
                            $sum_max+=($res[$i]['%_MP_maxi']!=="")?doubleval($res[$i]['%_MP_maxi']):$res[$i]['%_MP_form'];
                            $sum_min+=($res[$i]['%_MP_mini']!=="")?doubleval($res[$i]['%_MP_mini']):$res[$i]['%_MP_form'];
                        }
                    } ?> 
                    
                </tbody>
                <tfoot>
                    <tr style="border: solid #EEE 1px">
                        <td ></td>
                        <td style="background-color: #EEE;" colspan=3 >Calcule d'ingrédient qsp100%</td>
                        <td ><input readonly class="long" type="text"  value="<?php echo number_format(100-$sum, 4, '.', '').'%';?>"></td>

                        <td ><input readonly class="long" type="text"  value="<?php echo number_format(100-$sum_min, 4, '.', '').'%';?>"></td>

                        <td ><input readonly class="long" type="text"  value="<?php echo number_format(100-$sum_max, 4, '.', '').'%';?>"></td>
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