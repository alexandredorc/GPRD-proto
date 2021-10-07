<?php
/*
*
*
//////// FORMULES ////////
*
*
*
*/
//Access à la page de modification formules

if($_GET['modif']=='formule'){
    include('modif_form.php');
}

//Access à la page de ajout formules

elseif($_GET['modif']=='add_form'){
    include('add_form.php');
}

//Inserer une nouvelle formule

elseif($_GET['modif']=='push_form'){
    $data=$bdd->query("SELECT Ref_form FROM formules WHERE Ref_form='".$_POST['Ref_form']."'");
    $data=$data->fetchAll();
    if(count($data)!=0){
        header('Location: index.php?modif=add_form&erreur=1');
        
    }else{
        $req=$bdd->prepare("INSERT INTO formules 
        (Ref_form, Code_RD)
        VALUES(:Ref_form,:Code_RD )");
        $req->execute([
            'Ref_form' => $_POST['Ref_form'],
            'Code_RD' => $_POST['Code_RD'], 
            ]);
        $_SESSION['ref_form']=$_POST['Ref_form'];
        header('Location: index.php');
    }
}


//Appliquer les changements des formules

elseif($_GET['modif']='change_form'){
    if($_POST['btn']=='change'){
        $req=$bdd->prepare("UPDATE formules SET 
        Ref_form= :Ref_form , 
        Retenue= :Retenue , 
        Etat_form= :Etat_form , 
        Val_RD= :Val_RD , 
        Val_AR= :Val_AR , 
        Date_val= :Date_val , 
        Info_form= :Info_form , 
        Code_GPAO= :Code_GPAO , 
        Annee_com= :Annee_com , 
        Mode_ope= :Mode_ope , 
        Code_RD= :Code_RD , 
        Annulee= :Annulee WHERE Ref_form= :Reference ");
        $req->execute(array(
        'Ref_form'=>$_POST['Ref_form'] , 
        'Retenue'=>(isset($_POST['Retenue']))?"VRAI":"FAUX", 
        'Etat_form'=>(isset($_POST['Etat_form']))?$_POST['Etat_form']:"", 
        'Val_RD'=>(isset($_POST['Val_RD']))?"VRAI":"FAUX",
        'Val_AR'=>(isset($_POST['Val_AR']))?"VRAI":"FAUX",
        'Date_val'=>$_POST['Date_val'], 
        'Info_form'=>$_POST['Info_form'], 
        'Code_GPAO'=>$_POST['Code_GPAO'], 
        'Annee_com'=>$_POST['Annee_com'], 
        'Mode_ope'=>$_POST['Mode_ope'], 
        'Code_RD'=>$_POST['Code_RD'], 
        'Annulee'=>(isset($_POST['Annulee']))?"VRAI":"FAUX",
        'Reference' => $_SESSION['ref_form'] ));
        
    }
    elseif($_POST['btn']="suppr"){
        $data=$_SESSION['mod_form'];
        $req=$bdd->exec("DELETE FROM formules WHERE Ref_form='$data'");
        $req=$bdd->exec("DELETE FROM comp_form WHERE Ref_form_RD='$data'");
    }
    header('Location: index.php');
}
?>