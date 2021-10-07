
<div class="panel-heading">
    <h4 class=" title">
        <a data-toggle="collapse" data-parent="#accordion_form" href="#collapse1">Composition Formule Produit</a>
    </h4>
</div>
<div id="collapse1" class="panel-collapse collapse">
    <div class="comp_form_prod">
    <?php
    if(isset($_SESSION['ref_form'])){
        $res= table_to_table('formules','comp_form','Ref_form_RD','Ref_form_RD',$_SESSION['ref_form'],$bdd," ORDER BY Ligne ASC ")->fetchAll();
        if(count($res)!=0){?>
        <h5>La formule a <?php echo count($res);?> lignes </h5>
            <table class="table">
                <thead>
                    <tr>
                        <th class="unique">Phase</th>
                        <th class="unique">Code MP</th>
                        <th class="vv-long">Nom MP</th>
                        <th class="long">% MP dans formule</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for($i=0;$i<count($res);$i++){
                        $data=table_single_query('matieres_premieres','Code_MP',$res[$i]['Code_MP'],$bdd);
                    ?>
                        <tr>
                            <td class="unique"><input type="text" readonly value="<?php echo $res[$i]['Phase'] ?>"></td>
                            <td class="unique"><input type="text" readonly value="<?php echo $res[$i]['Code_MP'] ?>"></td>
                            <td style="width:300px;"><input  type="text" readonly value="<?php echo $data['Nom_MP'] ?>"></td>
                            <td class="long"><input  type="text" readonly value="<?php echo ($res[$i]['%_MP_form']).'%'?>"></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            
            
        <?php
        }?>
        <button class="btn btn-primary" style="margin-top:50px;" onclick="location.href = '../comp_form'">
                Voir la Formule Compléte
            </button><?php
    }
    ?>
    </div>  
</div>    

