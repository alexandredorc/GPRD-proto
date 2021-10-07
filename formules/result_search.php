<?php
	//listing des resultats de la recherche pour les formules

if($_GET['recherche']=='end_formule'){// cehck le problème av'ec etat form vide select option is shit(put a third option 'both')
    $data=table_columns('formules',$bdd);
    $sql="SELECT * FROM formules WHERE 1=1";
    for($i=0;$i<count($data);$i++){
        $attr=$data[$i]['COLUMN_NAME'];
        $val=$_POST[$attr];
        if(isset($val) && $val!=""){
            $sql="$sql AND $attr LIKE '%$val%'";
        }
    }
    $res=$bdd->query($sql);
    ?>
    <div class="body-center" style="max-width:none; padding-bottom:100px;">
        <form action="index.php" method="POST">
        <?php
            $i=0;
            $res=$res->fetchAll();
            for($i=0;$i<count($res);$i++){
                $data=$res[$i];
                ?>
                    <table class="table">
                        <tr>
                            <th><input class="form-control" type="submit" name="ref_form" value="<?php echo $data['Ref_form'] ?>" style="min-width:200px; border: 2px solid grey "></th>
                            <th><textarea  class="form-control" cols="30" rows="1"><?php echo $data['Info_form'] ?></textarea></th>
                            <th><input type="text" readonly value="<?php echo $data['Code_GPAO']?>" style="min-width:300px;"></th>
                            <th><input type="text" readonly value="<?php echo $data['Code_RD']?>" style="min-width:300px;"></th>
                        </tr>
                    </table>
                
                
                
                
                <?php
            }
            ?>
                </form>
                    <button class="btn btn-secondary" style="margin: 20px; width:fit-content;" onclick="location.href='index.php?recherche=formule'">
                        <i class="bi bi-arrow-left"></i> Retour
                    </button>		
            <?php
            if(count($res)==1){
                $_SESSION['id_prod']=table_single_nsearch('produits','Code_RD_prod',$res[0]['Code_RD'],$bdd);	
                $_SESSION['ref_form']=$res[0]['Ref_form'];
                $_SESSION['search']=true;
                
                header("Location: index.php");
            }
        ?>
    </div>
    <?php

}
    
// recherche formule rapide

elseif($_GET['recherche']=='quick_form'){
    $sql= "select * from formules where Ref_form='".$_POST['Ref_form']."'";
    $res=$bdd->query($sql);
    $res=$res->fetchAll();
    if(count($res)==1){
        $_SESSION['ref_form']=$res[0]['Ref_form'];
        $_SESSION['id_prod']=table_single_nsearch('produits','Code_RD_prod',$res[0]['Code_RD'],$bdd);
        $_SESSION['search']=true;
       
        
    }
    else{
        $_SESSION['ref_form']=NULL;
    }
    header("Location: index.php");
}

//page de recherche formules

elseif($_GET['recherche']=='formule'){
    include('search_form.html');
}