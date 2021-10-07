<?php
function notzero($var){
    return ($var!==0);
}

function notempty($var){
    return ($var!='');
}
?>




    <?php 
    $pays=array_column(get_single_attribut('pays_organism','Pays_org',$bdd), 'Pays_org');
    $data=table_single_query('matieres_premieres','Code_MP',$_SESSION['Code_MP'],$bdd);
    include('reg_comps.php');
    ?>
    <h4>
        Synthèse réglementaire MP
    </h4>
    <textarea cols="100" rows="4" style="overflow:initial; width:500px"><?php echo $data['Synt_MP']?></textarea>
    <?php
    if( true || $_SESSION['reg_synth']){ ?>    
    <div class="halfies">
        <div class="half">
            <div><h3>Produits non rincés: </h3></div>    
            <div style="padding: 10px;">
                <?php 
                if(isset($_SESSION['reg_synth'][0][0])){
                echo  "Autorisations (non rincés): </br>";
                ksort($_SESSION['reg_synth'][0][0]);
                foreach($_SESSION['reg_synth'][0][0] as $cle => $val){
                ?>
                    <input type="text" readonly value="<?php echo $pays[$cle]; ?>">
                    à
                    <input type="text" readonly value="<?php echo  ($val!="" && $val<100)? $val."%":""; ?>">
                    max de MP
                    </br>   
                <?php } 
                if(empty(array_filter($_SESSION['reg_synth'][0][0],"notempty"))){
                    $min="";
                }else{
                    $min=min(array_filter($_SESSION['reg_synth'][0][0],"notempty"));
                }
                ?>
                % max autorisé: (OK tout pays/org)
                <input type="text" readonly value="<?php echo  ($min!="" && $min<100)?$min."%":""; ?>">
                <?php } ?>
            </div>
            <div style="padding: 10px;">
            
                <?php 
                if(isset($_SESSION['reg_synth'][0][1])){
                echo "Interdiction (non rincés): </br>";
                ksort($_SESSION['reg_synth'][0][1]);
                foreach($_SESSION['reg_synth'][0][1] as $cle => $val){
                ?>
                    <input type="text" readonly value="<?php echo $pays[$cle]; ?>">
                    </br>   
                <?php } }?>
            </div>
            <div style="padding: 10px;">
            <?php 
                if(isset($_SESSION['reg_synth'][0][2])){
                $_SESSION['reg_synth'][0][2]=unique_multidim_array($_SESSION['reg_synth'][0][2],1,2);
                echo  "Restriction particulières (non rincés): </br>";
                foreach($_SESSION['reg_synth'][0][2] as $cle => $val){
                    if($val[0]<100){
                ?>
                    <input type="text" readonly value="<?php echo $val[2]; ?>">
                    <textarea cols="25" rows="1"><?php echo $val[1]; ?></textarea>
                    max:
                    <input type="text" readonly value="<?php echo ($val[0]!=="")? $val[0]."%":"";  ?>">
                    </br>   
                <?php } } } ?>
            </div>
            <div style="padding: 10px;">
            <?php 
                if(isset($_SESSION['reg_synth'][0][3])){
                $_SESSION['reg_synth'][0][3]=unique_multidim_array($_SESSION['reg_synth'][0][3],1,2);
                echo  "Etiquetage à indiquer (non rincés): </br>";
                ksort($_SESSION['reg_synth'][0][3]);
                foreach($_SESSION['reg_synth'][0][3] as $cle => $val){
                    if($val[0]<100){
                ?>
                    <input type="text" readonly value="<?php echo $val[2]; ?>">
                    <input type="text" readonly value="<?php echo $val[1]; ?>">
                    max:
                    <input type="text" readonly value="<?php echo ($val[0]!=="")? $val[0]."%":"";  ?>">
                    </br>   
                <?php } }
                $min=min(array_column($_SESSION['reg_synth'][0][3],0));
                ?>
                % max autorisé: (OK tout pays/org)
                <input type="text" readonly value="<?php echo $min."%"; ?>">
                <?php } ?>
            </div>
            <div style="padding: 10px;">
               
               <?php 
                if(isset($_SESSION['reg_synth'][0][4])){
                $_SESSION['reg_synth'][0][4]=unique_multidim_array($_SESSION['reg_synth'][0][4],1,2,3);
                echo  "Conditions particulières d'utilisation et autres infos règlementaires (non rincés) </br>";
                ksort($_SESSION['reg_synth'][0][4]);
                foreach($_SESSION['reg_synth'][0][4] as $cle => $val){
                    if($val[0]<=100){
                ?>
                    <i style="font-size:10px;"><?php echo $val[3]; ?></i></br>
                    <input type="text" class="long" readonly value="<?php echo $val[2]; ?>">
                    <textarea cols="30" rows="1"><?php echo $val[1]; ?></textarea>
                    max:
                    <input type="text" readonly value="<?php echo ($val[0]!=="")? $val[0]."%":"";  ?>">
                    </br>   
                    <?php } } } ?>
            </div>
        </div>
        
        <div class="half">
            <div><h3>Produits rincés: </h3></div>    
            <div style="padding: 10px;">
                <?php
                if(isset($_SESSION['reg_synth'][1][0])){
                echo  "Autorisations (rincés): </br>";
                ksort($_SESSION['reg_synth'][1][0]);
                foreach($_SESSION['reg_synth'][1][0] as $cle => $val){
                ?>
                    <input type="text" readonly value="<?php echo $pays[$cle]; ?>">
                    à
                    <input type="text" readonly value="<?php echo ($val!="" && $val<100)? $val."%":""; ?>">
                    max de MP
                    </br>   
                <?php } 
                if(empty(array_filter($_SESSION['reg_synth'][1][0],"notempty"))){
                    $min="";
                }else{
                    $min=min(array_filter($_SESSION['reg_synth'][1][0],"notempty"));
                }

                ?>
                % max autorisé: (OK tout pays/org)
                <input type="text" readonly value="<?php echo ($min!="" && $min<100)?$min."%":""; ?>">
                <?php } ?>
            </div>
            <div style="padding: 10px;">
            <?php 
                if(isset($_SESSION['reg_synth'][1][1])){
                echo "Interdiction (rincés): </br>";
                ksort($_SESSION['reg_synth'][1][1]);
                foreach($_SESSION['reg_synth'][1][1] as $cle => $val){
                ?>
                    <input type="text" readonly value="<?php echo $pays[$cle]; ?>">
                    </br>   
                <?php } }?>
            </div>
            <div style="padding: 10px;">
            <?php 
                if(isset($_SESSION['reg_synth'][1][2])){
                $_SESSION['reg_synth'][1][2]=unique_multidim_array($_SESSION['reg_synth'][1][2],1,2);
                echo  "Restriction particulières (rincés): </br>";
                foreach($_SESSION['reg_synth'][1][2] as $cle => $val){
                    if($val[0]<=100){
                ?>
                    <input type="text" readonly value="<?php echo $val[2]; ?>">
                    <textarea cols="25" rows="1"><?php echo $val[1]; ?></textarea>
                    max:
                    <input type="text" readonly value="<?php echo ($val[0]!=="")? $val[0]."%":"";  ?>">
                    </br>   
                <?php } } } ?>
            </div>
            <div style="padding: 10px;">
            <?php 
                if(isset($_SESSION['reg_synth'][1][3])){
                $_SESSION['reg_synth'][1][3]=unique_multidim_array($_SESSION['reg_synth'][1][3],1,2);
                echo  "Etiquetage à indiqué (rincés): </br>";
                //ksort($_SESSION['reg_synth'][1][3]);
                foreach($_SESSION['reg_synth'][1][3] as $cle => $val){
                    if($val[0]<=100){
                ?>
                    <input type="text" readonly value="<?php echo $val[2]; ?>">
                    <input type="text" readonly value="<?php echo $val[1]; ?>">
                    max:
                    <input type="text" readonly value="<?php echo ($val[0]!=="")? $val[0]."%":"";  ?>">
                    </br>   
                <?php } }
                $min=min(array_column($_SESSION['reg_synth'][1][3],0));
                ?>
                % max autorisé: (OK tout pays/org)
                <input type="text" readonly value="<?php echo $min."%"; ?>">
                <?php } ?>
            </div>
            <div style="padding: 10px;">
               
               <?php 
                if(isset($_SESSION['reg_synth'][1][4])){
                $_SESSION['reg_synth'][1][4]=unique_multidim_array($_SESSION['reg_synth'][1][4],1,2,3);
                echo  "Conditions particulières d'utilisation et autres infos règlementaires (rincés) </br>";
                ksort($_SESSION['reg_synth'][1][4]);
                foreach($_SESSION['reg_synth'][1][4] as $cle => $val){
                    if($val[0]<=100){
                ?>
                    <i style="font-size:10px;"><?php echo $val[3]; ?></i></br>
                    <input type="text" class="long" readonly value="<?php echo $val[2]; ?>">
                    <textarea cols="30" rows="1"><?php echo $val[1]; ?></textarea>
                    max:
                    <input type="text" readonly value="<?php echo ($val[0]!=="")? $val[0]."%":"";  ?>">
                    </br>   
                    <?php } } } ?>
            </div>
        </div>
    </div>
    <div>
        
        <?php 
        if(isset($_SESSION['reg_synth'][2])){
            echo "CMR présents dans la MP </br>";
            foreach($_SESSION['reg_synth'][2] as $cle => $val){
            ?>
                <input type="text" class="vv-long" readonly value="<?php echo $val[0]; ?>">
                <input type="text" class="vv-long" readonly value="<?php echo $val[1]; ?>"></br>
            <?php } } ?>
    </div>
    <?php } ?>
